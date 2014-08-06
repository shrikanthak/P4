
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
        
        $("#currentEmployee").attr("disabled",true);
        $("#newEmployee").attr("disabled",true);
        
        if (document.getElementById("newEmployee").checked)
        {
          document.getElementById('_employee_id').value=0;
          clearEditForm();
        }
         
    }
}


function clearEditForm()
{
    $("#Login_id").text("Login ID: ");
    $("#first_name").val("");
    $("#last_name").val("");
}

$( document ).ready(function()
{    

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
        async:false,
        url: "hr/employee/save/" + $("#_employee_id").val(),
        data: postdata, // serializes the form's elements.
        success: function(data)
        {
          $("#currentEmployee").attr("disabled",false);
          $("#newEmployee").attr("disabled",false);
          $("#currentEmployee").attr("checked",true);
          itemNewCurrent("current");
          $('#divViewEmployee').html(data);
        }

      });
    }
    
  });
  

  $("#search_employee").change(function()
  {
    if(loginArray.indexOf($("#search_employee").val())>=0)
    {
        $.ajax(
        {
           type: "GET",
           url: "/employeebasicview/"+$("#search_employee").val(),
           success: function(data)
           {
             $('#divViewEmployee').html(data);
             $("#Login_id").text("Login ID: "+$(data).find('#_login').text());
             $("#first_name").val($(data).find('#_first_name').text());
             $("#last_name").val($(data).find('#_last_name').text());
             $("#_employee_id").val($(data).find('#_emp_id').text());
             $("#_login_id").val($(data).find('#_login').text());
             $("#_delete_employee_id").val($(data).find('#_emp_id').text());
             $("#edit_employee_button").bind('click',function()
              {
                 itemNewCurrent("new");

              });
             
             $("#delete_employee_button").bind('click',function()
              {

                 if(confirm('You are about to delete employee: '+
                    $("#first_name").val()  + ' ' + $("#last_name").val()))
                 {
                    $.ajax(
                    {
                        type: "POST",
                        url: "hr/employee/delete",
                        data:$('#employee_delete_form').serialize(),
                        success: function(data)
                        {
                          if(data=='success')
                          {
                             itemNewCurrent("current");
                             $('#loginList option[value="'+$('#_login_id').val()+'"]').remove();
                             $('#search_employee').val('');
                             
                          }
                        }

                    });
                 }

              });

           }
        });

    }
  });


});