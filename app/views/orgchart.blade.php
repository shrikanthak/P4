
	@extends('_master')
	

	@section('bodycontent')
		<div id='divHidden' style='display:none'>{{$dataArray}}</div>
		{{HTML::image('','No Image',array('style'=>'display:none','id'=>'hiddenImage'))}}
		<div id='chart_div'></div>
		<script>
			google.load('visualization', '1', {packages:['orgchart']});
			var chart;
			var dataJSON;
			function drawChart() 
			{
	
				    var data = new google.visualization.DataTable();
				    data.addColumn('string', 'Name');
				    data.addColumn('string', 'Manager');
				    data.addColumn('string', 'ToolTip');
				    dataJSON=document.getElementById('divHidden').innerHTML;

				    dataJSON=JSON.parse(dataJSON);

				    var id='id';
				    var name='name'
				    var title='title';
				    var imagename='imagename';
				    var supervisor_id='supervisor_id';

				    var imagePath = document.getElementById('hiddenImage').src; // or whatever means of access


					if(imagePath.indexOf('/') >= 0) {
					   imagePath = imagePath.substring(imagePath.lastIndexOf('/')+1);
					}



				    for (var i = 0; i < dataJSON.length; i++)
				    {
				    	var row=dataJSON[i];
				    	var str='';
				    	str=str.concat(row[name],'<div style="color:red; font-style:italic">',
				    			 '<img style="max-width=75px;max-height:75px;" src="','/images/',
				    			 row[imagename],'"><br>',row[title],'</div></div>');

				    	data.addRow([{v:row[id].toString(), 
				    		f:str},row[supervisor_id].toString(),row[title]]);	
				    }

				    chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
				    chart.draw(data, {allowHtml:true});
			}

			//console.log(dataJSON);
			drawChart();
		</script>
	@stop

		
	@section('headsection')
		{{ HTML::script('https://www.google.com/jsapi'); }}
		<!--script src='https://www.google.com/jsapi'></script-->
		{{ HTML::script('js/orgchart.js'); }}
	@stop

	