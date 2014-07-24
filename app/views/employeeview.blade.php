@extends('_master')

@section('headsection')
	{{ HTML::style('css/employeeview.css'); }}
@stop

@section('bodycontent')
		
	@include('employeebasicdataview')
	
	@if($bView)
		<blockquote class="bg-info">
			{{{$paragraph}}}
		</blockquote>

		<div class="row">
			<div class="col-xs-1">
				{{Form::open(array('url'=>'/employee/edit','method'=>'GET'))}}
					<input type="submit" name="btnEdit" class="btn btn-info btn-lg pull-left" value="Edit">
				{{Form::close()}}
			</div>
			<div class="col-xs-11"></div>
		</div>
	@else

		<div class="row textareaformat">
		      <h2> Edit Your Information</h2><br>
		      
				{{Form::open(array('url'=>'/employee/save','method'=>'POST','files'=>true))}} 
					<div class="form-group">
						<label for="txtEmployeeInputText">Your Information</label><br>
						{{Form::textarea('txtEmployeeData',$paragraph,array('class'=>'form-control','rows'=>20))}}<br>
						<label for="fileImageInput">Upload Image File</label>
						{{ Form::file('fileImageInput') }}
					</div>

					<button type="submit" class="btn btn-info btn-lg pull-left" name='btnSave'>Save</button>

				{{Form::close()}}

	  	</div>

	@endif

@stop