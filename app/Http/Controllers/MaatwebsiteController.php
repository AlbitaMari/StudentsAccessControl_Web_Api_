<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use DB;
use Session;
use Excel;
use App\Import\AlumnosImport;
use App\Import\AutorizadosImport;
use App\Import\AutorizacionesImport;
use App\Alumnos;

class MaatwebsiteController extends Controller
{
    public function importExport()
    {
        return view('importExport');
    }

    public function downloadExcel($type)
    {
        $data = Post::get()->toArray();
        return Excel::create('laravelcode', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    public function importExcel(Request $request)
    {
        if($request->hasFile('import_file')){

            

            $data = Excel::toArray(new AlumnosImport(), $request->file('import_file'));

            foreach ($data[0] as $key => $row) {

                    $code = $row[0];
                    $name = $row[1];
                    $surname = $row[2];
                    $birthDate = $row[3];
                    $authorized = $row[4];
                    $email = $row[5];
                    $password = \Hash::make($row[6]);
                    $dni = $row[7];
                
                if($key>=1){

                    $userExist = Alumnos::where('code','=',$code)->exists();
                
                    if(!empty($data) && $userExist == False) {
                        $id = DB::table('users')->insertGetId([
                            'email' => $email,
                            'password' => $password,
                            'dni' => $dni
                        ]);

                        DB::table('alumnos')->insert([
                            'id_user' => $id,
                            'code' => $code,
                            'name' => $name,
                            'surname' => $surname,
                            'birthDate' => date("Y-m-d H:i:s", strtotime($birthDate)),
                            'authorized' => intval($authorized)
                        ]);
                        
                        $success =  'Se han importado los datos correctamente a la base de datos';
                    }
                    else{
                        $success = 'Ya existe el alumno en la base de datos';
                    }
                }

            }
        }
        else{
            $success = 'No existen filas para importar';
        }

        return redirect()->back()->with('success',$success);
    }

    public function importExcelAutorizados(Request $request)
    {
        if($request->hasFile('autorized_table')){

            $success =  'Se han importado los datos correctamente a la base de datos';

            $data = Excel::toArray(new AutorizadosImport(), $request->file('autorized_table'));

            foreach ($data[0] as $key => $row) {

                if($key>=1){
                    $code = $row[0];
                    $name = $row[1];
                    $surname = $row[2];
                    $dni = $row[3];

                    $alumno = Alumnos::where('code','=',$code)->first();

                    if($alumno != null){

                        if(!empty($data)) {
                            $id_alumno = $alumno->id;

                            $id_authorized = DB::table('autorizados')->insertGetId([
                                'name' => $name,
                                'surname' => $surname,
                                'dni' => $dni
                            ]);
    
                            DB::table('autorizados_alumnos')->insert([
                                'id_alumno' => $id_alumno,
                                'id_autorizado' => $id_authorized,
                            ]);
                        }
                    }
                    else{
                        $success = 'No existe ningún alumno en la base de datos para autorizar';
                    }

                }

            }
        }
        else{
            $success = 'No existen filas para importar';
        }

       return redirect()->back()->with('success', $success);

    }

    public function importExcelAutorizaciones(Request $request)
    {
        if($request->hasFile('authorizations')){

            $success =  'Se han importado los datos correctamente a la base de datos';

            $data = Excel::toArray(new AutorizacionesImport(), $request->file('authorizations'));

            foreach ($data[0] as $key => $row) {

                if($key>=1){

                    $code = $row[0];
                    $authorized = $row[1];

                    $alumno = Alumnos::where('code','=',$code)->first();

                    if($alumno != null){
                        $id_alumno = $alumno->id;

                        if(!empty($data)) {
    
                            DB::table('alumnos')->where('id', $id_alumno)->update(['authorized' => $authorized]);
                        }
                    }
                    else{
                        $success = 'No existe el alumno en la base de datos.';
                    }

                }

            }
        }
        else{
            $success = 'No existen filas para importar';
        }

       return redirect()->back()->with('success', $success);

    }
}