
	@extends('_master')
	

	@section('bodycontent')
		<div id='chart_div' class="orgchartformat"></div>
		<script>
			var chart;
			drawChart();
		</script>
	@stop

		
	@section('headsection')
		<script src='https://www.google.com/jsapi'></script>
		<script src='js/orgchart.js'></script>
	@stop

	