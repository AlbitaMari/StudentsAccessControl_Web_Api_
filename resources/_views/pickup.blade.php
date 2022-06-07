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
    <link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}">

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
                    <h4 class="aj">Recogida de alumnos</h4>
                    <form action="{{ route('searchauthorized') }}" method="GET" id="enviar">
                        @csrf
                        <label>Código alumno</label>
                        <input type="text" name="code" id="code" oninput="myFunction()"/>
                        <button class="mt-3 bt" type="submit">Buscar</button>
                    </form>
                </div>
                <div class="col-5">
                    @if(isset($alumno))
                        @if(is_int($alumno))
                            <h4><strong>El código no corresponde a ningún alumno del centro</strong></h4>
                        @else
                        <h5>{{ $alumno->surname }}, {{ $alumno->name }}</h5>
                        <h5><strong>Fecha de nacimiento: </strong> {{ $alumno->birthDate }}</h5>
                        <h5><strong>Código: </strong> {{ $alumno->code }}</h5>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="row pt-5 justify-content-center">
                <div class="col-12 cnt">
                    <h5><strong>PERSONAS AUTORIZADAS</strong></h5>
                </div>
        </div>
        <div class="row justify-content-center">
                <div class="col-10 maut">
                    <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Dni</th>
                                    <th>Recogida</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($alumno))
                                    @if(is_int($alumno))
                                    <h4><strong></strong></h4>
                                    @else
                                        @foreach($alumno->autorizados as $autorizado)
                                            <tr>
                                                <td>{{ $autorizado->name }}</td>
                                                <td>{{ $autorizado->surname }}</td>
                                                <td>{{ $autorizado->dni }} </td>
                                                <td>
                                                    <form method="POST" action="{{ route('pickuplog') }}">
                                                    @csrf
                                                        <input type="hidden" value="{{ $autorizado->name }}" name="is_authorized"/>
                                                        <input type="hidden" value="{{ $alumno->id }}" name="alumno"/>
                                                        <button type="submit">
                                                        <i class="fas fa-school"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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

    </script>
</body>
</html>