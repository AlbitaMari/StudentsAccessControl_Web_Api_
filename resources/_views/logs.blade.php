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
                <div class="col-8">
                    <h4>Historial de recogida de alumnos del centro</h4>
                </div>
            </div>
            <div class="row pt-5">
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
                            <td>{{ $log->alumno->birthDate }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function() {
            $('#logger').DataTable({
                "order":[[4,"desc"]]
            });
            } 
        );

</script>
</body>
</html>