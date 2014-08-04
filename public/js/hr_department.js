$(document).ready(function()
{
	var getSupervisorList=function()
	{
		$.ajax(
		  {
		     type: "GET",
		     url: "hr/supervisorlist/0/0",	//this is the corporate head department id
		     success: function(data)
		     {
				var positions=JSON.parse(data);
				var options='';
				for (var i = 0; i < positions.length; i++) 
				{
				  options += '<option value="' + positions[i]['id'] + '">' + positions[i]['description'] + '</option>';
				}
				$("select#supervisor_position").html(options);
		     }
		  });
	}

	//Add department button click
	$("#add_department").click(function()
	{
		$("#department_code").val('');
		$("#department_name").val('');
		$("#divEditDepartment").css('display','block');
		getSupervisorList();

	});

	
	//edit department button click
	$("[id^=departmentedit]").click(function()
	{
		var id=$(this).attr('id');
		var depid=id.substr(('departmentedit').length);
		$('#department_code').val($('#departmentcode'+depid).text());
		$('#department_name').val($('#departmentname'+depid).text());
		var positiondesc=$('#departmenthead'+ depid).text();
		var firstchar=positiondesc.indexOf('-')+1;
		var lastchar=positiondesc.indexOf(':');
		var posid=positiondesc.substr(firstchar,lastchar-firstchar);
		getSupervisorList();
		$("select#supervisor_position").val(posid);
		$("#divEditDepartment").css('display','block');
		$("#department_code").attr('disabled',true);
		return false;

	});
	
	

	//------------------------------------------------------------------
	//Function to save department
	//------------------------------------------------------------------
	$("#save_department").click(function()
	{
		if($('#department_code').val() && $('#department_name').val())
		{
		  var postdata=$("#edit_department_form").serialize();
		  $.ajax(
	      {
	        type: "POST",
	        url: "hr/department/save",
	        data: postdata, // serializes the form's elements.
	        success: function(data)
	        {
	          $('#department_table tr:last').after(data);
	        }

	      });
	      $("#department_code").attr('disabled',false);
	      $("#divEditDepartment").css('display','none');
		}
	});
});