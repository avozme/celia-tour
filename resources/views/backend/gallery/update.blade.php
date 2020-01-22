 @extends('layouts.backend')
@section('content')
    <form method="POST" action="/gallery/{{ $gallery->id }}" enctype="multipart/form-data">
        @csrf
        ID:<br /> <input type='text' name='type' value={{ $gallery->id }}><br />
        <br />Titulo:<br/><input type='text' name='title' value='{{ $gallery->title }}'><br/>
        <br />Descripcion:<br /><textarea name="description" rows="10" cols="40" >{{ $gallery->description }}</textarea>
        <br/><input type="submit" name="edit" value=" Guardar">
    </form>
@endsection