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
        <div class="cont pt-5 maut">
            <div class="row justify-content-center">
                <div class="col-5 dp">
                    <h4 class="aj">Control de salidas</h4>
                    <form action="{{ route('search') }}" method="POST" id="enviar">
                        @csrf
                        <label class="lb">Código alumno</label>
                        <input type="text" name="code" id="code" oninput="myFunction()"/>
                        <button class="mt-3 bt" type="submit">Buscar</button>
                    </form>
                </div>
                <div class="col-5">
                    @if(isset($alumno))
                        @if(is_int($alumno))
                            <h4 class="lb"><strong>El código no corresponde a ningún alumno del centro</strong></h4>
                        @else
                            <h5 class="lb">{{ $alumno->surname }}, {{ $alumno->name }}</h5>
                            <h5 class="lb"><strong>Fecha de nacimiento: </strong> {{ $alumno->birthDate }}</h5>
                            <h5 class="lb"><strong>Código: </strong> {{ $alumno->code }}</h5>
                            @if($access == True)
                            <p class="acss">Permitido</p>
                            @else
                            <p class="noacc">No Permitido</p>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
            <div class="row pt-5 justify-content-center">
                <div class="col-10">
                    <table id="logger" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Fecha de nacimiento</th>
                            <th>Acción</th>
                            <th>Fecha y hora</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($logs))
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->alumno->name }}</td>
                                <td>{{ $log->alumno->surname }}</td>
                                <td>{{date("d F Y", strtotime($log->alumno->birthDate))}}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{date("d F Y", strtotime($log->created_at))}}</td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>

        function myFunction() {
        var x = document.getElementById("code").value;
        document.getElementById("enviar").submit();
        }


        $(document).ready(function() {
            $('#logger').DataTable({
                "order":[[4,"desc"]]
            });
            } 
        );

    </script>
</body>
</html>