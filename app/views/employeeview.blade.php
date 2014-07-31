@extends('_master')

@section('headsection')
	{{ HTML::script('js/employee_portal.js'); }}
@stop

@section('bodycontent')
	
	@include('employeebasicdataview')
	
	<div class="row formmargin" id="divViewInfo">
		<blockquote class="bg-info">
			{{{$data['paragraph']}}}
		</blockquote>
		
		<div class="col-xs-2">
			{{Form::open(array('route'=>array('emp_org_chart',$data['current_id']),'method'=>'GET'))}}
				<button type="submit" class= "btn btn-success btn-lg pull-left">View Org Chart</button>
			{{Form::close()}}	
		</div>

		<div class="col-xs-10">
			@if(Auth::check()?Auth::user()->id==$data['current_id']:false)
				<button type="button" onclick="clickEdit()" class="btn btn-warning btn-lg pull-right">Edit Information</button>
			@endif
		</div>
			
	</div>

	<div class="row formmargin" id="divEditInfo" style="display:none">
		
		<div class='col-xs-12'>	
			
			{{Form::open(array('url'=>'/employee/save','method'=>'POST','files'=>true))}} 
		      	<h2> Edit Your Information</h2><br>
				
				<div class='form-group'>
					<label for="employee_info">Your Information</label><br>
					{{Form::textarea('employee_info',$data['paragraph'],array('class'=>'form-control','rows'=>20))}}<br>
				</div>
				
				<div class='form-group'>
					<label for="fileImageInput">Upload Image File</label>
					{{ Form::file('fileImageInput',array('id'=>'fileImageInput')) }}<br>
				</div>

				<div class='form-group'>
					<button type='submit'class="btn btn-info btn-lg pull-left" name='btnSave'>Save</button>
					<button type='button' onclick="clickCancel()"class="btn btn-default btn-lg pull-left" name='btnCancel'>Cancel</button>
					<button type="button" href="/resetpassword" class="btn btn-danger btn-lg pull-right" name='btnResetPassword'>Reset Password</button>
				</div>

			{{Form::close()}}

		</div>

	</div>

@stop