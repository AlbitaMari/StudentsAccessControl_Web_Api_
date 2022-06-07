<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pdf</title>
  <style>
        /* table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        } */
        th{
            background-color: #cacdcf;
        }
        .st{
            border: 1px solid white;
            border-collapse: collapse;
        }
        table, td , th{
            border: 1px solid black;
            border-collapse: collapse;
        }
        .t{
            padding-right: 100px;
        }
        .tm{
            padding-right: 250px;
        }
    </style>
</head>
<body>
    <h2>Historial de Logs</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Fecha de Nacimiento</th>
                <th>Acción</th>
                <th>Fecha de Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->alumno->name }}</td>
                <td>{{ $log->alumno->surname }}</td>
                <td>{{ $log->alumno->birthDate }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>