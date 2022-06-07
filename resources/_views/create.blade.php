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
                    <a href="{{ route('crudal') }}"><i class="fa fa-chevron-left">  Volver</i></a>
                </div>
        </div>
        <div class="row justify-content-center pt-5">
            <div class="col-8 cnt">
                <h4 class="foredit"><strong>CREAR ALUMNO</strong></h4>
            </div>
            <div class="col-8 pt-4 cnt">
                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="{{ route('create') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label"><strong>Nombre</strong></label>

                                    <div class="col-md-6 marcnt">
                                        <input id="name" type="text" class="form-control" name="name" required>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                                    <label for="surname" class="col-md-4 control-label"><strong>Apellido</strong></label>

                                    <div class="col-md-6 marcnt">
                                        <input id="surname" type="text" class="form-control" name="surname" required>

                                        @if ($errors->has('surname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('surname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('birthDate') ? ' has-error' : '' }}">
                                    <label for="birthDate" class="col-md-4 control-label"><strong>Fecha de Nacimiento</strong></label>

                                    <div class="col-md-6 marcnt">
                                        <input id="birthDate" type="date" class="form-control" name="birthDate" required>

                                        @if ($errors->has('birthDate'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('birthDate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('authorized') ? ' has-error' : '' }}">
                                    <label for="authorized" class="col-md-4 control-label"><strong>Autorizado</strong></label>

                                    <div class="col-md-6 marcnt">
                                    <select name="authorized">
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                        @if ($errors->has('authorized'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('authorized') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4 marcnt pt-3">
                                        <button type="submit" class="abutton">
                                            Registrar Alumno
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>