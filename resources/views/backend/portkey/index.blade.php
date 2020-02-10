@extends('layouts.backend')


@section('content')
	<h2> Hola gente </h2>
	<p>Portkeys</p>
		<table border='1'>
		@foreach($portkeyList as $prk)
			<tr>
				<td>{{ $prk->name }}</td> 
			</tr>

		@endforeach
		
		
@endsection