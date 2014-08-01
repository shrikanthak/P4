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

function itemNewCurrent(state)
{
    
    if (state=="current")
    {
        document.getElementById("divSearchEmployee").style.display = 'block';
        document.getElementById("divEditEmployee").style.display = 'none';
        document.getElementById("divViewEmployee").style.display = 'block';
        document.getElementById("divViewEmployee").innerHTML = '';
    }
    else if(state="new")
    {
        document.getElementById("divSearchEmployee").style.display = 'none';
        document.getElementById("divEditEmployee").style.display = 'block';
        document.getElementById("divViewEmployee").style.display = 'none';
        document.getElementById('_employee_id').value=0;
        $("#currentEmployee").attr("disabled",true);
        $("#newEmployee").attr("disabled",true);
         clearEditForm();
    }
}

function getPositionsTable()
{
    if($("#position_department").val()>0)
    {
        $.ajax(
        {
           type: "GET",
           url: "/positionstable",
           data: {department:$("#position_department").val(),allpositions:$("#position_department").checked()}, 
           success: function(data)
           {
               //alert(data);
               $('#divPositionsView').html(data);
           }
        });
    }
}


function departmentChange()
{
  $.ajax(
  {
     type: "GET",
     url: "/positions/employees/". $("#_employee_id").val(),
     data: {departmentid:$("#employee_department").val()}, // serializes the form's elements.
     success: function(data)
     {
          //alert(data);
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
          $('#select#employee_department').val(0);
          $('#select#employee_department').val(1);
     }
  });
}

function clearEditForm()
{
    $("label#Login_id").val("Login ID: ");
    $("text#first_name").val("");
    $("text#last_name").val("");
}

$( document ).ready(function()
{    
  
  $("#edit_employee_button").click(function()
  {
     itemNewCurrent("new");

     $("label#Login_id").val("Login ID: "+$("#_login").val());
     $("text#first_name").val($("#_first_name").val());
     $("text#last_name").val($("#_last_name").val());
     $("#_employee_id").val($("#_emp_id").val());
     $("select#employee_department").val($("#_department_id").val());
     $("select#employee_position").val($("#_position_id").val());
     $("select#employee_supervisor").val($("#_supervisor_id").val());

  });


  $("select#employee_department").change(departmentChange)

  $("#cancel").click(function()
  {
    clearEditForm();
    $("#divEditEmployee").css("display","none");
    
    if ($("#currentEmployee").checked)
    {
      $("#divViewEmployee").css("display","block");
      $("#divSearchEmployee").css("display","block");
    }
    $("#currentEmployee").attr("disabled",false);
    $("#newEmployee").attr("disabled",false);
    
  });

  $("#save").click(function()
  {
    
    if($("#first_name").val() && $("#last_name").val())
    {

      var postdata=$("#edit_employee_form").serialize();
      $.ajax(
      {
        type: "POST",
        url: "/employee/save",
        data: postdata, // serializes the form's elements.
        success: function(data)
        {
          $('#divViewEmployee').html(data);
          $("#currentEmployee").attr("disabled",false);
          $("#newEmployee").attr("disabled",false);
          $("#currentEmployee").attr("checked",true);
          itemNewCurrent("current");

        }

      });
    }
    
  });
  
  $("#delete").change(function()
  {
    
  });

  $("#search_employee").change(function()
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
               $('#divViewEmployee').html(data);
           }
        });

    }
  });


});