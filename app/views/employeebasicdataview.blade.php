<?php $name= $data['first_name']." ".$data['last_name'];?>
<div class="row">
	<div class="col-xs-6">

		{{HTML::image('images/'.$data['image'],'Your Image',array('class'=>'imageformat'))}}</br>
		
	</div>
	<div class="col-xs-6">
		<h1>{{{$name}}}</h1>
		<h3>{{{"Title: ".$data['title']}}}<br>
			{{{"Department: ".$data['department']}}}<br>
			{{{"Supervisor: ".$data['supervisor']}}}</h3></br>
	</div>
</div>