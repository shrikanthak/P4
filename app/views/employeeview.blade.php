@extends('_master')

@section('headsection')
	{{ HTML::style('css/employeeview.css'); }}
	{{ HTML::script('js/employee_portal.js'); }}
@stop

@section('bodycontent')
		
	@include('employeebasicdataview')
	
		<div class="row" id="divViewInfo">
			<blockquote class="bg-info">
				{{{$data['paragraph']}}}
			</blockquote>

			
				<div class="row">
					<div class="col-xs-2">
						<button type="button" class="btn btn-success btn-lg pull-left buttonmargin">View Org Chart</button>
					</div>
			
					<div class="col-xs-10">
						@if(Auth::check()?Auth::user()->id==$data['current_id']:false)
							<button type="button" onclick="clickEdit()"class="btn btn-info btn-lg pull-right buttonmargin">Edit Information</button>
						@endif
					</div>
				</div>
			
		</div>

		<div class="row textareaformat" id="divEditInfo" style="display:none">
		      <h2> Edit Your Information</h2><br>
		      
				{{Form::open(array('url'=>'/employee/save','method'=>'POST','files'=>true))}} 
					
					<div class="form-group">
						<label for="employee_info">Your Information</label><br>
						{{Form::textarea('employee_info',$data['paragraph'],array('class'=>'form-control','rows'=>20))}}<br>
						<label for="fileImageInput">Upload Image File</label>
						{{ Form::file('fileImageInput',array('id'=>'fileImageInput','onchange','displayFileName()')) }}
					</div>

					<button type='submit'class="btn btn-info btn-lg pull-left" name='btnSave'>Save</button>
					<button type='button' onclick="clickCancel()"class="btn btn-default btn-lg pull-left" name='btnCancel'>Cancel</button>
					<button type="button" href="/resetpassword" class="btn btn-danger btn-lg pull-right" name='btnResetPassword'>Reset Password</button>

				{{Form::close()}}


	  	</div>

@stop