/*function employeeNewCurrent()
{
	
    if (document.getElementById("currentEmployee").checked)
    {
       	document.getElementById("divViewEmployee").style.display = 'block';
    	document.getElementById("divEditEmployee").style.display = 'none';
    }
    else if(document.getElementById("newEmployee").checked)
    {
        document.getElementById("divViewEmployee").style.display = 'none';
    	document.getElementById("divEditEmployee").style.display = 'block';
    }
}*/
function getEmployeeData()
{
    if(loginArray.indexOf($("#search_employee").val())>=0)
    {
        $.ajax(
        {
           type: "GET",
           url: "/employeebasicview",
           data: {search_content:$("#search_employee").val()}, // serializes the form's elements.
           success: function(data)
           {
               //alert(data);
               $('#divEmployeeDataView').html(data);
           }
        });

    }
}


function itemNewCurrent(item)
{
    
    if (document.getElementById(("current")+item).checked)
    {
        document.getElementById(("divView")+item).style.display = 'block';
        document.getElementById(("divEdit")+item).style.display = 'none';

    }
    else if(document.getElementById(("new")+item).checked)
    {
        document.getElementById(("divView")+item).style.display = 'none';
        document.getElementById(("divEdit")+item).style.display = 'block';
    }
}

function getPositionsTable()
{
    if ($("#position_department").val()>0)
    {
        $.ajax(
        {
           type: "GET",
           url: "/hr/ajax/department/position",
           data: {department:$("#position_department").val(),allpositions:$("#position_department").checked()}, 
           success: function(data)
           {
               //alert(data);
               $('#divEmployeeDataView').html(data);
           }
        });
    }
}

$( document ).ready(function()
{
   
    
      $("select#employee_department").change(function()
      {
            $.ajax(
            {
               type: "GET",
               url: "/positions/employees",
               data: {departmentid:$("#employee_department").val()}, // serializes the form's elements.
               success: function(data)
               {
                    alert(data);
                    var datArray=JSON.parse(data);
                    var positions=datArray['positions'];
                    var employees=datArray['employees'];
                    var options = '';
                    for (var i = 0; i < positions.length; i++) 
                    {
                        array=positions[i];

                        options += '<option value="' + array['id'] + '">' + array['description'] + '</option>';
                    }
                    $("select#employee_position").html(options);
                    var options2 = '';
                    for (var i = 0; i < employees.length; i++) 
                    {
                        array=employees[i];

                        options2 += '<option value="' + array['id'] + '">' + array['description'] + '</option>';
                    }
                    $("select#employee_supervisor").html(options2);
               }
            });
    
          
      });
  

});