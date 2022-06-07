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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body class="cbg">
    <div class="container pt-5">
        <div class="flex-center position-ref full-height">
            <div class="top-right links first">
                <h3 class="prin">Conectado como <strong>{{ auth()->user()->name }}</strong></h3>
                <form action="{{ route('logout') }}" method="POST">
                @csrf
                    <button class="btn" type="submit">Cerrar Sesión</a>
                </form>
            </div>
        </div>
        <div class="cont pt-5 maut">
            <div class="row">
                <div class="col-5 bg mr">
                    <h4 class="h"> Control de salida </h4>
                    <h5 class="">Registro de alumnos con salida autorizada</h5>
                    <a class="abutton" href="{{ route('exit.control') }}">Acceder</a>
                </div>
                <div class="col-5 bg">
                    <h4 class="h"> Recogida de alumnos </h4>
                    <h5>Registro de autorizados para recogida</h5>
                    <a class="abutton" href="{{ route('pickup') }}">Acceder</a>
                </div>
                <div class="col-5 bg mt-3 mr">
                    <h4 class="h"> Logs </h4>
                    <h5>Historial de Logs de Alumnos</h5>
                    <a class="abutton" href="{{ route('loggs') }}">Acceder</a>
                </div>
                <div class="col-5 bg mt-3">
                    <h4 class="h"> Alumnos </h4>
                    <h5>CRUD de Alumnos</h5>
                    <a class="abutton" href="{{ route('crudal') }}">Acceder</a>
                </div>
            </div>
            <div class="row justify-content-center pp">
                <div class="col-2">
                    <a class="button-rounded align-items-center d-flex justify-content-center" href="{{ route('rise') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 26" fill="none">
                            <path d="M24 9.83585V15.6H0V9.83585H24ZM15.0541 0V26H8.96994V0H15.0541Z" fill="white"/>
                        </svg>
                    </a>
                    <h5 class="ct">Subir datos</h5>
                </div>
            </div>
        </div>
    </div>
</body>
</html>