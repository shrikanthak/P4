$(document).ready(function()
{
	$('#password_reset').submit(function()
	{
		if(!$('#newpassword').val() || !$('#confirmnewpassword').val() || !$('#oldpassword').val())
		{
			alert('Please fill in old and new passwords');
			return false;
		}
		else if($('#newpassword').val()!==$('#confirmnewpassword').val())
		{
			alert('Passwords do not match');
			return false;
		}
	});
});