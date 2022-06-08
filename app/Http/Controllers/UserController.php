<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Alumnos;
use App\Logs;
use App\Autorizados;
use App\User;
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
            if($date >= 18 || $alumno->authorized == 1):
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
        $user = User::where('id','=',$alumno->id_user)->first();
        return view('edit',['alumno'=>$alumno,'user'=>$user]);
    }

    protected function update(Request $request,$id) {

        $this->validate($request,['code'=>'required','name'=>'required', 'surname'=>'required', 'birthDate'=>'required']);
 
        Alumnos::find($id)->update($request->all());
        $alumno = Alumnos::find($id);
        $user = User::where('id','=',$alumno->id_user)->first();
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
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
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $email = $request['email'];
        $code = $request['code'];
        $exist = User::where('email','=',$email)->exists();
        $code_exists = Alumnos::where('code','=',$code)->exists();
        if($exist === False && $code_exists === False){
            $user = User::create([
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'dni' => $request['dni'],
            ]);
    
            $alumno = Alumnos::create([
                'id_user' => $user->id,
                'code' => $request['code'],
                'name' => $request['name'],
                'surname' => $request['surname'],
                'birthDate' => $request['birthDate'],
                'authorized' => $request['authorized'],
            ]);
    
            $alumnos = Alumnos::all();
            $message = 'El alumno se ha creado correctamente';
        }
        else{
            $alumnos = Alumnos::all();
            $message = 'Código de alumno o correo electrónico existente en la base de datos. No se ha creado el alumno.';
        }
        return view('alumnos',['alumnos'=>$alumnos, 'message' => $message]);
    }

    protected function searcher(Request $request){

        $filtro = $request['filtro'];
        $filtro2 = $request['filtro2'];
        $filtro3 = $request['filtro3'];
        $filtro4 = $request['filtro4'];
        $message='';

        if($filtro === 'name'){
            $exist = Alumnos::where('name','=',$filtro2)->exists();
            if($exist){
                $alumnos = Alumnos::where('name','=',$filtro2)->get();
                $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
            }else{
                $message = 'No existe ningún registro en la base de datos con ese nombre.';
                $logs = Logs::all();
            }
        }

        if($filtro === 'surname'){
            $exist = Alumnos::where('name','=',$filtro2)->exists();
            if($exist){
                $alumnos = Alumnos::where('surname','=',$filtro2)->get();
                $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
            }else{
                $message = 'No existe ningún registro en la base de datos con ese apellido.';
                $logs = Logs::all();
            }
        }

        if($filtro === 'birthDate'){
            if($filtro3 > $filtro4){
                $message = 'La fecha de comienzo no puede ser posterior a la fecha fin.';
                $logs = Logs::all();

            }else if($filtro3 == $filtro4){
                $message = 'Las fechas no pueden ser iguales';
                $logs = Logs::all();
            }
            else{
                $exist = Alumnos::whereDate('birthDate','>=',$filtro3)->whereDate('birthDate','<=',$filtro4)->exists();
                if($exist){
                    $alumnos = Alumnos::whereDate('birthDate','>=',$filtro3)->whereDate('birthDate','<=',$filtro4)->get();
                    $logs = Logs::whereIn('id_alumno',$alumnos->pluck('id'))->get();
                }else{
                    $message = 'No existe ningún registro nacido entre las fechas indicadas.';
                    $logs = Logs::all();
                }
            }
        }

        if($filtro === 'action'){
            $exist = Logs::where('action','=',$filtro2)->exists();
            if($exist){
                $logs = Logs::where('action','=',$filtro2)->get();
            }else{
                $message = 'No existe la acción indicada o no existe un log con esa acción. Busca "Salida del centro" o "Recogida del centro"';
                $logs = Logs::all();
            }

        }

        if($filtro === 'created_at'){
            if($filtro3 > $filtro4){
                $message = 'La fecha de comienzo no puede ser posterior a la fecha fin';
                $logs = Logs::all();

            }else if($filtro3 == $filtro4){
                $message = 'Las fechas no pueden ser iguales';
                $logs = Logs::all();
            }
            else{
                $exist = Logs::whereDate('created_at','>=',$filtro3)->whereDate('created_at','<=',$filtro4)->exists();
                if($exist){
                    $logs = Logs::whereDate('created_at','>=',$filtro3)->whereDate('created_at','<=',$filtro4)->get();
                }else{
                    $message = 'No existe ningún alumno registrado en las fechas indicadas.';
                    $logs = Logs::all();
                }

            }
        }

        if($filtro === 'selecciona'){
            $logs = Logs::all();
        }
        
        return view('loggs',['logs'=>$logs,'f'=>$filtro,'f1'=>$filtro2,'f2'=>$filtro3,'f3'=>$filtro4,'message'=>$message]);
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
        $success = 'Email enviado correctamente';
        
        return view('loggs',['logs'=>$logs,'success'=>$success]);
    }

}
