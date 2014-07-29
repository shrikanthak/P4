function employeeNewCurrent()
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
}
function getEmployeeData()
{
    if(loginArray.indexOf($("#search_employee").val())>=0)
    {
        $.ajax(
        {
           type: "GET",
           url: "/hr/ajax/employeeview/",
           data: {search_content:$("#search_employee").val()}, // serializes the form's elements.
           success: function(data)
           {
               //alert(data);
               $('#divEmployeeDataView').html(data);
           }
        });

    }
}

function clickEditEmployee()
{
    
}

$( document ).ready(function() {
   
});