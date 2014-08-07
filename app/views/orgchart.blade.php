
	@extends('_master')
	

	@section('bodycontent')
		<div id='divHidden' style='display:none'>{{$dataArray}}</div>
		{{HTML::image('','No Image',array('style'=>'display:none','id'=>'hiddenImage'))}}
		<div class="row orgrow">

			<div class='col-xs-7 orgcol'><div id='chart_div' style="overflow:auto"></div></div>
			<div class='col-xs-5 orgcol'>
				@include('employeebasicdataview')
				<div class='row'>
					<div class='col-xs-12'>
						<h4 style='text-align:center'><a href={{'/employee/view/'.$data['current_id']}}>View Page</a></h4>
					</div>
				</div>
			</div>
		</div>

		{{-- The following script is for generating org chart and trapping evemts --}}
		
		<script>
			var chart;
			function drawChart() 
			{
				    var data = new google.visualization.DataTable();
				    data.addColumn('string', 'Name');
				    data.addColumn('string', 'Manager');
				    data.addColumn('string', 'ToolTip');
				    
				    dataJSON=document.getElementById('divHidden').innerHTML;

				    var dataJSON=JSON.parse(dataJSON);

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
						str=str.concat(row[name],'<div style="color:red; font-style:bold">',row[title])
						
						if(row[imagename] !== '')
						{
							str=str.concat('<div><img style="max-width=75px;max-height:75px;" src="','/images/',
							 			row[imagename],'"><br></div>');
						}
				    	str=str.concat('</div>');

				    	data.addRow([{v:row[id].toString(), 
				    		f:str},row[supervisor_id].toString(),row[title]]);	
				    }

				    chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
				    chart.draw(data, {allowHtml:true});

					function orgChartClick()
					{
						var selection=chart.getSelection();
						var selectedItem = chart.getSelection()[0];
						if (selection.length==1)
						{
							if (selectedItem) 
							{
								var value = data.getValue(selectedItem.row, 0);
								strurl="/employee/orgchart/";
								strurl=strurl.concat(value.toString());
								window.location.replace(strurl);
							}
						}
					}


				    google.visualization.events.addListener(chart,'select',orgChartClick);



			}

			

			//console.log(dataJSON);

			drawChart();
		</script>
	@stop

		
	@section('headsection')
		{{ HTML::script('https://www.google.com/jsapi'); }}
		{{ HTML::script('js/orgchart.js'); }}
		{{ HTML::style('css/orgchart.css'); }}
		<script>google.load('visualization', '1', {packages:['orgchart']});</script>
	@stop

	