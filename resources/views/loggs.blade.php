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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/custom.css">
    
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer" ></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}" defer></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}" ></script>
    <script src="{{ asset('locales/bootstrap-datepicker.es.min.js') }}" ></script>


</head>
<body class="cbg">
    <div class="container pt-5">
        <div class="row">
                <div class="col-3">
                    <a href="{{ route('home') }}"><i class="fa fa-chevron-left">  Volver</i></a>
                </div>
        </div>
        <div class="cont pt-5 maut">
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
            <div class="row justify-content-center">
                <div class="col-8">
                    <h4 class="lb mb-5">Historial de Logs</h4>
                </div>
            </div>
            <form action="{{ route('searcher') }}" method="GET" autocomplete="off">
                <div class="row">
                    <div class="col-4">
                            <input autocomplete="false" name="hidden" type="text" style="display:none;">
                            <label class="lb">Filtrar por </label>
                            <select name="filtro" id="filtro">
                                <option value="selecciona">--Selecciona--</option>
                                <option value="name">Nombre</option>
                                <option value="surname">Apellidos</option>
                                <option value="birthDate">Fecha de Nacimiento</option>
                                <option value="action">Acción</option>
                                <option value="created_at">Fecha de Registro</option>
                            </select>
                    </div>
                    <div class="col-3" id="yes" style="display:none">
                        <input placeholder="Escribe tu búsqueda..." type="text" name="filtro2" />
                    </div>
                    <div class="col-3 df" id="datte" style="display:none">
                            <p class="lb">Desde: </p><input type="text" name="filtro3" id="checkout"/>
                            <p class="lb">Hasta: </p><input type="text" name="filtro4" id="checko"/>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="abutton btn">
                                Buscar
                        </button>
                    </div>
                </div>
            </form>

            <form class="form-horizontal" method="POST" action="{{ route('pdf') }}">
                {{ csrf_field() }}
                <div class="row pt-5 justify-content-center">
                    <div class="col-12">
                        <table id="logger" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Fecha de nacimiento</th>
                                <th>Acción</th>
                                <th>Fecha de Acción</th>
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
                                    <td>{{date("d F Y h:i:s", strtotime($log->created_at))}}</td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if(isset($f))
                        <input type="hidden" name="f" value="{{ $f }}"/>
                        <input type="hidden" name="f1" value="{{ $f1 }}"/>
                        <input type="hidden" name="f2" value="{{ $f2 }}"/>
                        <input type="hidden" name="f3" value="{{ $f3 }}"/>
                    @endif
                    <div class="col-2 mt-5">
                        <button class="abutton btn" type="submit">Generar PDF</button>
                    </div>
                </div>
            </form>
            <div class="row justify-content-center pt-3">
                <div class="col-2 mb-5">
                    <form action="{{ route('sendemail') }}" method="GET">
                        @if(isset($f))
                            <input type="hidden" name="f" value="{{ $f }}"/>
                            <input type="hidden" name="f1" value="{{ $f1 }}"/>
                            <input type="hidden" name="f2" value="{{ $f2 }}"/>
                            <input type="hidden" name="f3" value="{{ $f3 }}"/>
                        @endif
                        <button class="abutton btn" type="submit">Enviar Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function() {
            $('#logger').DataTable();
            } 
        );

        $('#checkout').datepicker({
            format: "yyyy-mm-dd",
        });
        $('#checko').datepicker({
            format: "yyyy-mm-dd",
        });

        $(function () {
            $("#filtro").change(function () {
                if ($(this).val() == "selecciona") {
                    $("#yes").hide();
                    $("#datte").hide();
                }
                else if ($(this).val() == "name") {
                    $("#yes").show();
                    $("#datte").hide();
                }
                else if ($(this).val() == "surname") {
                    $("#yes").show();
                    $("#datte").hide();
                }
                else if ($(this).val() == "action") {
                    $("#yes").show();
                    $("#datte").hide();
                
                }else {
                    $("#yes").hide();
                    $("#datte").show();
                }
            });
        });

    </script>
</body>
</html>