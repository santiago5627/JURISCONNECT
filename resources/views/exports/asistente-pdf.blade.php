<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Abogados</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Listado de Asistentes</h2>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assistants as $assistant)
            <tr>
                <td>{{ $assistant->id }}</td>
                <td>{{ $assistant->nombre }}</td>
                <td>{{ $assistant->apellido }}</td>
                <td>{{ $assistant->correo }}</td>
                <td>{{ $assistant->telefono }}</td>
                <td>{{ $assistant->tipo_documento }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>