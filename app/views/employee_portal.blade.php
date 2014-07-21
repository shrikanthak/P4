@extends('_master')


@section('bodycontent')
		
	<h1>{{$data['firstName']." ".{$data['lastName']}}</h1></br>
	<h2>{{$data['title']}}</h2>
	<h2>{{$data['department']}}</h2>
	<h2>{{$data['supervisor']}}</h2></br>



	@if($edit==true)
		{{-- This section is for viewing employee portal --}}

	@else
		{{-- This section is for editing employee portal --}}


	@endif
@stop