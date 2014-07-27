<?php $name= $data['first_name']." ".$data['last_name'];
$imagefile=$data['image']!=''? '/images'.'/'.$data['image']:'';
$supervisor_id=$data['supervisor_id']>0?"/employee/view/".$data['supervisor_id']:'';
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
			{{{"Department: ".$data['department']}}}<br>
			{{{"Group: ".$data['group']}}}<br>
			{{{"Supervisor: "}}}<a href=<?=$supervisor_id?>>{{{$data['supervisor']}}}</a></h3></br>
	</div>
</div>