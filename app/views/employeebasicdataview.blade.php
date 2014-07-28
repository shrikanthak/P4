<?php $name= $data['first_name']." ".$data['last_name'];
$imagefile=$data['image']!=''? '/images'.'/'.$data['image']:'';
$supervisor_id=$data['supervisor_id']>0?"/employee/view/".$data['supervisor_id']:'';
$department_id=$data['department_id']!=''?'/department'.'/'.$data['department_id']:'';
?>

<div class="row">
	<div class="col-xs-6">
		@if($imagefile!='')
			{{HTML::image($imagefile,'Your Image',array('class'=>'imageformat'))}}
		@endif
		
	</div>
	<div class="col-xs-6">
		<h1>{{{$name}}}</h1>
		<h3>{{{"Title: ".$data['title']}}}<br>
			
			@if($data['department']!='')
				
				@if($data['head_of_department'])
					{{{"Head of Department: "}}}
				@else
					{{{"Department: "}}}}
				@endif
				<a href=<?=$department_id?>>{{{$data['department']}}}</a></br>
			@endif
			
			@if($data['supervisor']!='')
				{{{"Supervisor: "}}}<a href=<?=$supervisor_id?>>{{{$data['supervisor']}}}</a></br>
			@endif

		</h3>
	</div>
</div>