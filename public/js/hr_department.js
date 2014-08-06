$(document).ready(function()
{
	var getSupervisorList=function(selectposid)
	{	
		if(selectposid===undefined)
		{
			selectposid=0;
		}
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
				$("#supervisor_position option[value='"+String(selectposid)+"']").attr('selected','selected');
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
	var departmentEdit=function(depid)
	{
		if(depid===undefined) return false;
		if(depid==0) return false;

		$('#department_code').val($('#departmentcode'+depid).text());
		$('#department_name').val($('#departmentname'+depid).text());
		var positiondesc=$('#departmenthead'+ depid).text();
		var firstchar=positiondesc.indexOf('-')+1;
		var lastchar=positiondesc.indexOf(':');
		var posid=positiondesc.substr(firstchar,lastchar-firstchar);
		getSupervisorList(posid);
		//$("select#supervisor_position").val(posid);
		$("#divEditDepartment").css('display','block');
		$("#department_code").attr('disabled',true);
		return false;

	};
	
	$('#department_table').on('click','a',function(e)
		{
			e.preventDefault();
			var id=e.target.id;
			index=id.indexOf('departmentedit');
			if(index>=0)
			{
				
				departmentEdit(Number(id.substring(("departmentedit").length)));
			}
		});
	

	//------------------------------------------------------------------
	//Function to save department
	//------------------------------------------------------------------
	$("#edit_department_form").submit(function()
	{
		if($('#department_code').val() && $('#department_name').val())
		{
		  $("#department_code").attr('disabled',false);
	      $("#department_code").attr('disabled',false);
	      $("#divEditDepartment").css('display','none');
		}
		else
		{
			return false;
		}
	});
});