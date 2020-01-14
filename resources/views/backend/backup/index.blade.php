 @extends('layouts.backend')
@section('content')
<div id="title" class="col80"> Administración de Copias de Seguridad: </div>
<div id="content" class="col100"> 
 <a href="{{ url('backup/create') }}">Crear una nueva copia de seguridad</a> 
</div>
@endsection