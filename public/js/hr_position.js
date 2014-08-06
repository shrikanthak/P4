



$(document).ready(function()
{
	/******************************************************
	This function retrieves the position table
	*******************************************************/
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
	  $("#divPositions").find('#position_error_message').remove();
	  $("#divPositions").css('display','block');

	};

	var PopulateOpenEmployeeSelectorList=function(login)
	{
		if (login===undefined)
		{
			login='';
		}
	
		//load up the employee list. Include the current employee also
		$.ajax(
			{
		     type: "GET",
		     url: "hr/openemployeelist/"+login,
		     success: function(data)
		     {
		     	var employees=JSON.parse(data);
				var options='';
				var select_employee=0;
				
				for (var i = 0; i < employees.length; i++) 
				{
				  options += '<option value="' + employees[i]['id'] + '">' + employees[i]['description'] + '</option>';
				  if (login== (employees[i]['description']).substring(0,(employees[i]['description']).indexOf('(')-1))
				  {
				  	select_employee=i;
				  }
				}
	
				$("#employee_for_position").html(options);
				$("#employee_for_position option[value='"+
					String(employees[select_employee]['id'])+"']").attr('selected','selected');
				//$("#employee_for_position").text(employees[select_employee]['description']);
		     }

		});
	};

/****************************************************************************
	This function sets up the Supervisor selector list.
	In case of edit, if currentpos !=0 it excludes currentpos and its descendents 
	**************************************************************************/
	var PopulateSupervisorSelectorList=function(depid,currentpos,selectid)
	{
		if(depid===undefined)
		{
			depid=0;
		}
		if(currentpos===undefined)
		{
			currentpos=0;
		}
		if(selectid===undefined)
		{
			selectid=0;
		}
		$.ajax(
			{
			     type: "GET",
			     url: "hr/supervisorlist/"+String(depid)+"/"+String(currentpos),
			     success: function(data)
			     {
			     	var positions=JSON.parse(data);
					var options='';
					for (var i = 0; i < positions.length; i++) 
					{
					  options += '<option value="' + positions[i]['id'] + '">' + positions[i]['description'] + '</option>';
					}
					$("#supervisor_position").html(options);
					$("#supervisor_position option[value='"+String(selectid)+"']").attr('selected','selected');
			     }
			});
	};

	/***************************************************************
	This function sets up the position edit form on selection of edit.
	*****************************************************************/
	var positionEdit=function(posid)
	{

		$('#position_title').val($('#positiontitle'+posid).text());
		$('#_position_id').val($('#positionid'+posid).text());
		
		if($('#positionhraccess'+posid).text()=='Allowed')
		{
			$('#_hr_access').val(1)
			$("#hr_access").attr('checked',true);
		}
		else
		{
			$('#_hr_access').val(0)
			$("#hr_access").attr('checked',false);
		}
	     var login='';
	     var employee=$('#positionemployee'+posid).text();
	     if (employee !='')
	     {
	     	login= employee.substring(0,employee.indexOf('(')-1);
	     }
	   	
	   	PopulateOpenEmployeeSelectorList(login);
	   	//This will exclude the current employee and reportees from appearing on the list

	   	var positiondesc=$('#positionsupervisor'+ posid).text();
	   	var sup_posid=0;
	   	if(positiondesc!='')
	   	{
	   		var firstchar=positiondesc.indexOf('-')+1;
			var lastchar=positiondesc.indexOf(':');
			sup_posid=positiondesc.substr(firstchar,lastchar-firstchar);
			
	   	}

	   	PopulateSupervisorSelectorList($('#_department_id').val(),posid,sup_posid);

		$("#divEditPosition").css('display','block');

	}

	var positionDelete=function(posid)
	{
		if (posid===undefined)
		{
			return;
		}
		if (confirm('You are about to delete position'+('#positiontitle'+posid).text()+". Please confirm."))
		{
			var postdata=$("#positiondelete"+posid).serialize();
			$.ajax(
			{
				 type: "POST",
			     url: "/hr/position/delete",
			     data: postdata,
			     success: function(data)
			     {
					if(data=='success')
					{
						GetPositionTable();
						$("#divEditPosition").css('display','none');
					}
					else
					{
						$('#divPositions').prepend("<div class='flash-message' id='position_error_message'>" + data + "</div>");
					}
			     }
			});
		}

	}
//update the positions table
	$("select#position_department").change(function()
	{
		GetPositionTable();
		$("#_department_id").val($("select#position_department").val());
	});

	$("[id$=RadioPositions]").click(GetPositionTable);

	
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

			PopulateSupervisorSelectorList(depid);
			PopulateOpenEmployeeSelectorList();

		});


//position form submitted
	$("#position_form").submit(function()
	{
		if($("#position_title").val())
		{
			var postdata=$('#position_form').serialize();
			$.ajax(
			{
				 type: "POST",
			     url: "/hr/position/save",
			     data:postdata,
			     success: function(data)
			     {
			     	 GetPositionTable();
			     	 $("#divEditPosition").css('display','none');
			     }
			});	
		}

		$("select#position_department").attr('disabled',false);
		return false;
	});

//setting the HR access option
	$("#hr_access").click(function()
	{
		$("#_hr_access").val($('#hr_access').is(':checked')?1:0);
	});

//Clicking the edit button on a position 
	$('#positions_table_data').on('click','a',function(e)
		{
			e.preventDefault();
			var id=e.target.id;
			index=id.indexOf('positionedit');
			if(index>=0)
			{
				
				positionEdit(Number(id.substring(("positionedit").length)));
			}

			index=id.indexOf('positiondelete');
			if(index>=0)
			{
				
				positionDelete(Number(id.substring(("positiondelete").length)),e);
			}
		});
	
	$("#cancel_position_save").click(function()
	{
		$("select#position_department").attr('disabled',false);
		$("#divEditPosition").css('display','none');

	});
	
	 GetPositionTable();
});