@extends('_master')


@section('bodycontent')



	@include('employeebasicdataview')


	<div id="divViewInfo">
		
		<div class="row formmargin">
			<div class="col-xs-12">
				<blockquote class="bg-info">
					{{{$data['paragraph']}}}
				</blockquote>
			</div>
		</div>
		
		<div class='row'>
			<div class='col-xs-12'>
				{{Form::label('expert','Your Expertise')}}
				<table class="table table-bordered">
					@for($i=1, $expertise_num=0;$i<=3;$i++)
						<tr>
						@for($j=1;$j<=6;$j++, $expertise_num++)
							@if($expertise_num < count($employee_expertise_list))
								<td>{{{$employee_expertise_list[$i*$j-1]['description']}}}</td>
							@else
								<td></td>
							@endif
						@endfor
						</tr>
					@endfor
				</table>
			</div>
		</div>
		<div class='row formmargin'>
			<div class="col-xs-2">
				{{Form::button('View Org Chart',array('class'=>'btn btn-success btn-lg pull-left','onclick'=>'orgChartClick('.$data['position_id'].')'))}}
				<!--button type="button" onclick='employee/orgchart/' class= "btn btn-success btn-lg pull-left">View Org Chart</button-->	
			</div>

			<div class="col-xs-10">
				@if(Auth::check()?Auth::user()->id==$data['current_id']:false)
					<button type="button" onclick="clickEdit()" class="btn btn-warning btn-lg pull-right">Edit Information</button>
				@endif
			</div>
		</div>
				
	</div>

	<div id="divEditInfo" style="display:none">
		{{Form::open(array('url'=>'/employeeportal/save','method'=>'POST','files'=>true))}} 
			<div class="row formmargin">
				<div class='col-xs-12'>	
			      	<h2> Edit Your Information</h2><br>
					
					<div class='form-group'>
						<label for="employee_info">Your Information</label><br>
						{{Form::textarea('employee_info',$data['paragraph'],array('class'=>'form-control','rows'=>15))}}<br>
					</div>
					
					<div class='form-group'>
						<label for="fileImageInput">Upload Image File</label>
						{{ Form::file('fileImageInput',array('id'=>'fileImageInput')) }}<br>
					</div>
				</div>
			</div>
			<div class="row formmargin">
				<div class='col-xs-12'>
					{{Form::label('expertise','')}}
				</div>
			</div>
			<datalist id='expertiselist'>
				@foreach($expertise_list as $id=>$expertise)
					<option>{{{$expertise}}}</option>
				@endforeach
			</datalist>

			@for($i=1, $expertise_num=0;$i<=3;$i++)
				<div class="row formmargin">
					@for($j=1;$j<=6;$j++, $expertise_num++)
						<div class='col-xs-2'>
							@if($expertise_num < count($employee_expertise_list))
								{{Form::text('expertise_row'.$i.'_col'.$j,$employee_expertise_list[$i*$j-1]['description'],['class'=>'form-control','list'=>'expertiselist'])}}
							@else
								{{Form::text('expertise_row'.$i.'_col'.$j,'',['class'=>'form-control','list'=>'expertiselist'])}}
							@endif
						</div>
					@endfor
				</div>
			@endfor
			<div class="row formmargin">			
				<div class='form-group'>
					<div class='col-xs-1'>
						<button type='submit'class="btn btn-info btn-lg pull-left" name='btnSave'>Save</button>
					</div>
					<div class='col-xs-1'>
						<button type='button' onclick="clickCancel()"class="btn btn-default btn-lg pull-left" name='btnCancel'>Cancel</button>
					</div>
					<div>
						<button type="button" class="btn btn-danger btn-lg pull-right" name='resetpassword' id='resetpassword'>Reset Password</button>
					</div>
				</div>
			</div>
					

			
		{{Form::close()}}
	</div>

@stop

@section('footercontent')
	{{ HTML::script('js/employee_portal.js'); }}
@stop