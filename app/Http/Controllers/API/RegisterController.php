<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Alumnos;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class RegisterController extends Controller
{

    public $successStatus = 200;
    
    public function login() {
        
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('authToken')->accessToken;
            $email['email'] = $user->email;

            return response()->json(['success' => $success, 'email' => $email], $this->successStatus);
        }
        else {
            return response()->json(['error' => 'No estás autorizado'], 401);
        }
    }

    public function users(){

        $user = Auth::user();
        $alumno = Alumnos::where('id_user','=',$user->id)->first();
        $dat = Carbon::createFromDate($alumno->birthDate)->age;

        $success['success'] = true;
        $data['data'] = $user->toArray();
        $alumn['alumn'] = $alumno->toArray();
        $date['date'] = $dat;

        return response()->json(['success' => $success,'data' => $data, 'alumn' => $alumn,'date' => $date], $this->successStatus);

    }

}
