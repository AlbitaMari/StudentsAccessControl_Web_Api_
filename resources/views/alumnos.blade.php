<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="/fontawesome-free/css/all.min.css">
    
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

    <script src=//code.jquery.com/jquery.js></script>
    <script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body class="cbg">
    <div class="container pt-5">
        <div class="row">
                <div class="col-3">
                    <a href="{{ route('home') }}"><i class="fa fa-chevron-left">  Volver</i></a>
                </div>
        </div>
        <div class="row justify-content-center pt-5">
                <div class="col-6">
                @if(isset($success))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ $success }}</li>
                        </ul>
                    </div>
                @endif
                </div>
        </div>
        <div class="row justify-content-center pt-5">
            <div class="col-8">
                <h4 class="pb-5 cnt lb"><strong>ALUMNOS DEL CENTRO </strong></h4>
            </div>
            <div class="col-10 mb-3">
                <a class="abutton mb-5 btn" href="{{ route('create') }}">Crear Alumno</a>
            </div>
            <div class="col-10">
                <table id="alumnos" class="table table-bordered table-hover pt-5">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Autorizado</th>
                                    <th>Fecha de registro</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($alumnos as $alumno)
                                    <tr>
                                        <td>{{ $alumno->code }}</td>
                                        <td>{{ $alumno->name }}</td>
                                        <td>{{ $alumno->surname }}</td>
                                        <td>{{date("d F Y", strtotime($alumno->birthDate))}}</td>
                                        @if($alumno->authorized === 1)
                                            <td>Sí</td>
                                        @else
                                            <td>No</td>
                                        @endif
                                        <td>{{date("d F Y", strtotime($alumno->created_at))}}</td>
                                        <td>
                                            <a class="btn btn-warning btn-xs" href="{{ route('edit', ['id' => $alumno->id]) }}"><i class="fas fa-user-edit"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal-{{$alumno->id}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <div class="modal fade" id="exampleModal-{{$alumno->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de eliminar al alumno {{$alumno->name}} {{$alumno->surname}}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a class="btn btn-danger btn-xs"  href="{{ route('delete', ['id' => $alumno->id]) }}">Borrar</a>
                                                        <a type="button" class="btn btn-xs btn-success modal-buton" data-dismiss="modal">Cancelar</a>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function() {
            $('#alumnos').DataTable();
            } 
        );

    </script>
</body>
</html>