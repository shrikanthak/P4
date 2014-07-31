{{Form::open(array('url' => '/book/create', 'method' => 'POST'))}}

	<div class="row formmargin">
		
		<div class="col-xs-8">
			<div class='form-group'>
				{{ Form::label('position_department', 'Department') }}
				{{ Form::select('position_department', $departments,array('onchange'=>'function getPositionsTable()')); }}
			</div>
		</div>

		<div class="col-xs-4">
			<div class='form-group'>
				{{ Form::label('all_positions', 'Check to see all positions. Defaults to open positions only') }}
    			{{ Form::checkbox('all_positions', '0', false,array('onchange'=>'getPositionsTable()') }}
			</div>
		</div>
	
	</div>

	<div class= "row formmargin" >
		<div class="col-xs-12" id="positions_table" style="display:none">
			
		</div>
	</div>
	
	<div class="row formmargin">
		<div class="col-xs-1">
			<input type="button" name="new_position" class="btn btn-lg btn-info pull-left" value="New Position">
		</div>

		<div class="col-xs-11">
		</div>

	</div>

	<div class="row formmargin" id="divEditPosition">

		<div class="col-xs-4">
			{{Form::label('title','Position')}}
			{{Form::text('title','',array('class'=>'form-control'))}}
		</div>
		<div class="col-xs-4">
			{{Form::label('position_department','Department')}}
			{{Form::select('position_department',$departments,array('class'=>'form-control'))}}
		</div>
		<div class="col-xs-4">
			{{Form::label('hr_access','HR Page Access')}}
			{{ Form::checkbox('hr_access', '0', false) }}
		</div>

	</div>

{{Form::close()}}