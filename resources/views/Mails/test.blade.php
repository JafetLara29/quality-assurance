<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prueba de email de laravel</title>
</head>
<body>
    @if ($type == "Functionality")
        <h1>Funcionalidad requiere ser revisada</h1>
    @endif
    @if ($type == "Criterion")
        <h1>Criterio de pruebas requiere ser revisado</h1>
    @endif
    <h3>Hola {{$user->name}}</h3>
    <p>Parece que se han detectado algunos problemas al revisar un sistema del cual formas parte en el proceso de desarrollo o de QA.</p>
    <p>Información de la funcionalidad:</p>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if (isset($data->name))
                    <td>{{$data->name}}</td>
                @else
                    <td>{{$data->scenary}}</td>
                @endif
                <td>{{$data->description}}</td>
                <td>{{$data->state}}</td>
            </tr>
        </tbody>
    </table>
    <p>Observaciones hechas por: <strong>{{$QAUser->name}}</strong></p>
</body>
</html>