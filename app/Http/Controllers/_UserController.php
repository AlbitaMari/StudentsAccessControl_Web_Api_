<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Alumnos;
use App\Logs;
use App\Autorizados;
use Carbon\Carbon;
use App\Mail\MailLogsReceived;
use PDF;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    public function index()
    {
        return view('access');
    }

    public function exit()
    {
        $date= Carbon::today();
        $logs = Logs::where('action','=','Salida del centro')->whereDate('created_at','=',$date)->get();
        return view('exit',['logs' => $logs]);
    }

    public function search(Request $request){

        $alumno = Alumnos::where('code','=',$request['code'])->first();
        $access=False;
        if($alumno != null){
            $date = Carbon::createFromDate($alumno->birthDate)->age;
            if($date >= 18):
                $access = True;
                $exit = Logs::create([
                    'id_alumno' => $alumno->id,
                    'action' => 'Salida del centro',
                ]);
            endif;
        } else
            $alumno = 0;
        $date= Carbon::today();
        $logs = Logs::where('action','=','Salida del centro')->whereDate('created_at','=',$date)->get();
        return view('exit',['alumno' => $alumno,'access' => $access,'logs'=>$logs]);
    }

    public function pickup(){
        return view('pickup');
    }

    public function search_authorized(Request $request){
        $alumno = Alumnos::where('code','=',$request['code'])->first();
        if($alumno === null){
            $alumno = 0;
        }
        return view('pickup', compact('alumno'));
    }

    public function pickuplog(Request $request){

        $is_authorized = $request['is_authorized'];
        $alumno = $request['alumno'];
        $log = Logs::create([
            'id_alumno' => $alumno,
            'action' => 'Recogida del centro por: '.$is_authorized,
        ]);
        $date= Carbon::today();
        $logs = Logs::where('action','!=','Salida del centro')->whereDate('created_at','=',$date)->get();
        return view('logs',compact('logs'));
    }

    public function rise(){
        return view('rise');
    }

    public function loggs(){
        $logs = Logs::all();
        return view('loggs',['logs'=>$logs]);
    }

    public function crudal(){
        $alumnos = Alumnos::all();
        return view('alumnos',['alumnos'=>$alumnos]);
    }

    public function edit($id){
        $alumno = Alumnos::find($id);
        return view('edit',['alumno'=>$alumno]);
    }

    protected function update(Request $request,$id) {

        $this->validate($request,['code'=>'required','name'=>'required', 'surname'=>'required', 'birthDate'=>'required']);
 
        Alumnos::find($id)->update($request->all());
        return redirect()->route('crudal')->with('success','Registro actualizado satisfactoriamente');
    }

    protected function delete($id){
        $alumno = Alumnos::find($id);
        if(!$alumno)
            return redirect("/");
        $alumno->delete();
            return redirect()->route('crudal');
    }

    protected function add(){
        return view('create');
    }

    protected function create(Request $request){

        $data['code'] = str_random(25);

        $alumno = Alumnos::create([
            'code' => $data['code'],
            'name' => $request['name'],
            'surname' => $request['surname'],
            'birthDate' => $request['birthDate'],
            'authorized' => $request['authorized'],
        ]);
        $alumnos = Alumnos::all();
        return view('alumnos',['alumnos'=>$alumnos]);
    }

    protected function searcher(Request $request){

        $filtro = $request['filtro'];
        $filtro2 = $request['filtro2'];
        $filtro3 = $request['filtro3'];
        $filtro4 = $request['filtro4'];

        if($filtro === 'name'){
            $alumnos = Alumnos::where('name','=',$filtro2)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro === 'surname'){
            $alumnos = Alumnos::where('surname','=',$filtro2)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro === 'birthDate'){
            $alumnos = Alumnos::whereDate('birthDate','>=',$filtro3)->whereDate('birthDate','<=',$filtro4)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro === 'action'){
            $logs = Alumnos::where('action','=',$filtro2)->get();
        }

        if($filtro === 'created_at'){
            $logs = Logs::whereDate('created_at','>=',$filtro3)->whereDate('created_at','<=',$filtro4)->get();
        }

        if($filtro === 'selecciona'){
            $logs = Logs::all();
        }
        
        return view('loggs',['logs'=>$logs,'f'=>$filtro,'f1'=>$filtro2,'f2'=>$filtro3,'f3'=>$filtro4]);
    }

    public function generatePDF(Request $request){

        $filtro = $request['f'];
        $filtro2 = $request['f1'];
        $filtro3 = $request['f2'];
        $filtro4 = $request['f3'];

        if($filtro == 'name'){
            $alumnos = Alumnos::where('name','=',$filtro2)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro == 'surname'){
            $alumnos = Alumnos::where('surname','=',$filtro2)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro == 'birthDate'){
            $alumnos = Alumnos::whereDate('birthDate','>=',$filtro3)->whereDate('birthDate','<=',$filtro4)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro === 'created_at'){
            $logs = Logs::whereDate('created_at','>=',$filtro3)->whereDate('created_at','<=',$filtro4)->get();
        }

        if($filtro === null){
            $logs = Logs::all();
        }

        $pdf = \PDF::loadView('pdf',['logs'=>$logs])->save(storage_path('app/public/') . 'informe.pdf');
        return $pdf->setPaper('a4','landscape')->stream();
        return $pdf->download('informe.pdf');
    }

    public function enviarEmail(Request $request){
        
        $filtro = $request['f'];
        $filtro2 = $request['f1'];
        $filtro3 = $request['f2'];
        $filtro4 = $request['f3'];

        if($filtro == 'name'){
            $alumnos = Alumnos::where('name','=',$filtro2)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro == 'surname'){
            $alumnos = Alumnos::where('surname','=',$filtro2)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro == 'birthDate'){
            $alumnos = Alumnos::whereDate('birthDate','>=',$filtro3)->whereDate('birthDate','<=',$filtro4)->get();
            $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
        }

        if($filtro === 'created_at'){
            $logs = Logs::whereDate('created_at','>=',$filtro3)->whereDate('created_at','<=',$filtro4)->get();
        }

        if($filtro === null){
            $logs = Logs::all();
        }
        
        $mailable = new MailLogsReceived($logs);
        Mail::to('albasaenz89@gmail.com')->send($mailable);
        
        return view('loggs',['logs'=>$logs]);
    }

}
