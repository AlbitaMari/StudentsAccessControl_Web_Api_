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
        <div class="row justify-content-center pt-5">
            <div class="col-6">
            @if (\Session::has('success'))
                <div class="alert alert-message">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            </div>
        </div>
        <div class="row justify-content-center pt-2">
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <div>
                            <h5>Subir datos - CSV</h5>
                        </div>
                        <div>
                            <label>Datos de alumnos</label>
                        </div>
                        <div>
                            <form action="{{ route('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="file" name="import_file" />
                                <button type="submit" class="btn btn-primary">Subir</button>
                            </form>  
                        </div>
                        <div class="pt-3">
                            <label>Permisos de salida</label>
                        </div>
                            <form action="{{ route('importExcelAutorizaciones') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="file" name="authorizations" />
                                <button type="submit" class="btn btn-primary">Subir</button>
                            </form>  
                        <div class="pt-3">
                            <label>Autorizaciones</label>
                        </div>
                        <div>
                            <form action="{{ route('importExcelAutorizados') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="file" name="autorized_table" />
                                <button type="submit" class="btn btn-primary">Subir</button>
                            </form>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>