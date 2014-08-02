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
        if (document.getElementById("newEmployee").checked)
        {
          clearEditForm();
        }
         
    }
}

function setSelectedValue(selectObj, valueToSet) {
    for (var i = 0; i < selectObj.options.length; i++) {
        if (selectObj.options[i].value== valueToSet) {
            selectObj.options[i].selected = true;
            return;
        }
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
     async:false,
     url: "/openpositions/"+$("#employee_department").val()+'/'+$("#_employee_id").val(),
     success: function(data)
     {
          var positions=JSON.parse(data);
          var options='';
          for (var i = 0; i < positions.length; i++) 
          {
              options += '<option value="' + positions[i]['id'] + '">' + positions[i]['description'] + '</option>';
          }
          $("select#employee_position").html(options);

     }
  });
}

function clearEditForm()
{
    $("#Login_id").val("Login ID: ");
    $("#first_name").val("");
    $("#last_name").val("");
}

$( document ).ready(function()
{    
  
  $("select#employee_department").change(departmentChange)

  $("#cancel").click(function()
  {
    clearEditForm();
    $("#divEditEmployee").css("display","none");
    
    if ($("#currentEmployee").val()==1)
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
        url: "hr/employee/save/"+$("#_employee_id").val(),
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
             $("#Login_id").val("Login ID: "+$(data).find('#_login').text());
             $("#first_name").val($(data).find('#_first_name').text());
             $("#last_name").val($(data).find('#_last_name').text());
             $("input#_employee_id").val($(data).find('#_emp_id').text());
             $('select[name="employee_department"]').find('option[value="'+$(data).find('#_department_id').text()+'"]').attr("selected",true);
             //$("#employee_department").val(value);
             departmentChange();
             //value=$(data).find('#_position_id').text();
             //setSelectedValue(document.getElementByID("#employee_position"),$(data).find('#_position_id').text());
             $('select[name="employee_position"]').find('option[value="'+$(data).find('#_position_id').text()+'"]').attr("selected",true);
             //$("#employee_position").val(value);
             $("#edit_employee_button").bind('click',function()
                {
                   itemNewCurrent("new");
                  

                });
           }
        });

    }
  });


});