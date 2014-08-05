function clickEdit()
{
	document.getElementById("divEditInfo").style.display = 'block';
	document.getElementById("divViewInfo").style.display = 'none';
}

function clickCancel()
{
	document.getElementById("divEditInfo").style.display = 'none';
	document.getElementById("divViewInfo").style.display = 'block';
}

function orgChartClick(id)
{
	if (id>0)
	{
		window.location.replace('/employee/orgchart/'+id);
	}
	
}


$(document).ready(function()
{
	$('#resetpassword').click(function()
	{
		window.location.replace('/resetpassword');
	});

});