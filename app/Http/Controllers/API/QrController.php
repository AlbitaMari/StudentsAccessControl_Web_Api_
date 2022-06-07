<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Alumnos;
use App\Logs;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{

    public $successStatus = 200;

    public function qr()
    {
        $user = Auth::user();
        $alumno = Alumnos::where('id_user','=',$user->id)->first();
        $cod = $alumno->code;
        $encode = base64_encode(QrCode::format('svg')->size(60)->generate($cod));

        return response()->json(['encode' => $encode], $this->successStatus);
    }

    public function scannedCode(){
        
        $isAdult = false;
        $scannedCode = request('scannedBarCode');
        $alum = Alumnos::where('code','=',$scannedCode)->first();
        $dat = Carbon::createFromDate($alum->birthDate)->age;
        if($dat>=18){
            $isAdult = true;
            $exit = Logs::create([
                'id_alumno' => $alum->id,
                'action' => 'Salida del centro',
            ]);
        }
        $date= Carbon::today();
        $log = Logs::where('action','=','Salida del centro')->whereDate('created_at','=',$date)->get();
        $adult['adult'] = $isAdult;

        return response()->json(['adult' => $adult], $this->successStatus);
    }

    public function array(){

        $date= Carbon::today();
        $log = Logs::where('action','=','Salida del centro')->whereDate('created_at','=',$date)->get();
        $array_logs = array();
        foreach($log as $one_log) {
            $array_aux = array("name" => $one_log->alumno->name, "surname" => $one_log->alumno->surname, "action" => $one_log->action, "created_at" => $one_log->created_at);
            array_push($array_logs,$array_aux);
        }

        $logs['logs'] = $array_logs;

        return response()->json(['logs' => $logs], $this->successStatus);
    }
}