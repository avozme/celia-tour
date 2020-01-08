@extends('layouts.backend')
@section('content')
    <h2>Administración de recursos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titlo</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Ruta</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Recuerso 1</td>
                <td>Este recurso es el mejor</td>
                <td>Imagen</td>
                <td>/recursos/recurso1</td>
            </tr>
        </tbody>
    </table>

@endsection