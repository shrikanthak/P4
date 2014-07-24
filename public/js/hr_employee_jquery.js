$(document).ready(function() 
{
    $('#frmViewEmployee').submit(function() 
    {
        if(loginArray.indexof(($("#txtLoginID").val())>=0)
        {
        	return true; // return false to cancel form action	
        }
        else
        {
        	alert('Login does not exist');
        	return false;
        }
        
	});

	$('#frmViewEmployee').submit(function() 
    {
        // DO STUFF
        return true; // return false to cancel form action
	});
    
    $( "#tags" ).autocomplete({
      source: loginArray
    });
});