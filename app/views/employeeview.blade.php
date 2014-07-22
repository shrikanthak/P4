@extends('_master')

@section('headsection')
	{{ HTML::style('css/employeeview.css'); }}
@stop

@section('bodycontent')
		
	<?php $name= $data['first_name']." ".$data['last_name'];?>
	<div class="row">
		<div class="col-xs-6">

			{{HTML::image('images/'.$data['image'],'Your Image',array('class'=>'imageformat'))}}</br>
			if(!bView)

			
		</div>
		<div class="col-xs-6">
			<h1>{{{$name}}}</h1>
			<h3>{{{"Title: ".$data['title']}}}<br>
				{{{"Department: ".$data['department']}}}<br>
				{{{"Supervisor: ".$data['supervisor']}}}</h3></br>
		</div>
	</div>

	@if($bView)
		<blockquote class="bg-info">
			{{{$paragraph}}}
		</blockquote>

		<div class="row">
			<div class="col-xs-1">
				{{Form::open(array('url'=>'/employee/edit','method'=>'POST'))}}
					<input type="submit" name="btnEdit" class="btn btn-info btn-lg pull-left" value="Edit">
				{{Form::close()}}
			</div>
			<div class="col-xs-11"></div>
		</div>
	@else

	<div class="row">
	      <h2> Edit Your Portal</h2><br>
	      {{Form::open(array('url'=>'/employee/save','method'=>'POST','files'=>true))}}
	        
	        <div class="form-group">
				<label for="txtEmployeeInputText">Your Information</label>
				{{HTML::textarea('txtEmployeeData',$paragraph,array('class'=>'form-control','rows'=>'20'))}}
				<label for="fileImageInput">Image File</label>
				{{ Form::file('fileImageInput') }}
	        </div>

	        <button type="submit" class="btn btn-info btn-lg pull-left" name='btnSave'>Save</button>

	      {{Form::close()}}

  	</div>

	@endif

@stop