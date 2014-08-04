$(document).ready(function()
{
	// Position Radio Button Click
	var GetPositionTable=function()
	{
	 
	  var depid=$("#position_department").val();
	  $.ajax(
	  {
	     type: "GET",
	     url: "hr/positionstable/"+depid+'/'+$("input:radio[name ='position_status']:checked").val(),
	     success: function(data)
	     {
			$("#positions_table_data").html(data);
	     }
	  });
	  $("#divPositions").css('display','block');

	};

//update the department table
	$("select#position_department").change(function()
	{

		GetPositionTable();
		$("#_department_id").val($("select#position_department").val());
	});

	$("[id$=RadioPositions]").click(GetPositionTable);

	$("[id^=positionedit]").click(function()
		{
			alert('position edit');
			return false;
		});
	
//Fired when new position button is clicked
	$("#new_position").click(function()
		{
			$("select#position_department").attr('disabled',true);
			$("#divEditPosition").css('display','block');
			$("#position_title").val('');
			$("#hr_access").attr('checked',false);
			$("#_position_id").val(0);
			$("#_hr_access").val(0);
			$("#_hr_access").attr('checked',false);

			var depid=$("#position_department").val();
			$.ajax(
			{
			     type: "GET",
			     url: "hr/supervisorlist/"+depid+"/0",
			     success: function(data)
			     {
			     	var positions=JSON.parse(data);
					var options='';
					for (var i = 0; i < positions.length; i++) 
					{
					  options += '<option value="' + positions[i]['id'] + '">' + positions[i]['description'] + '</option>';
					}
					$("#supervisor_position").html(options);
			     }
			});

			$.ajax(
			{
			     type: "GET",
			     url: "hr/openemployeelist/",
			     success: function(data)
			     {
			     	alert(data);
			     	var employees=JSON.parse(data);
					var options='';
					for (var i = 0; i < employees.length; i++) 
					{
					  options += '<option value="' + employees[i]['id'] + '">' + employees[i]['description'] + '</option>';
					}
					$("#employee_for_position").html(options);
			     }
			});

		});

	$("#position_form").submit(function()
	{
		if($("#position_title").val())
		{
			var postdata=$('#position_form').serialize();
			$.ajax(
			{
				 type: "POST",
			     url: "hr/position/save",
			     data:postdata,
			     success: function(data)
			     {
			     	 GetPositionTable();
			     	 $("#divEditPosition").css('display','none')
			     }
			});	
		}

		return false;
	});

	$("#hr_access").click(function()
	{
		$("#_hr_access").val($("#hr_access").val());
	})

	$("[id^=positionedit]").click(function()
	{

	});

	$("[id^=positiondelete]").click(function()
	{
		
	});
	
});