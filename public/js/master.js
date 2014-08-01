function processSearch()
{
	if($('#search').val())
	{
		window.location.replace('/search/'+$('#search').val());
	}
}

$( document ).ready(function()
{  
	$('#search').keyup(function(e){
	    if(e.keyCode == 13)
	    {
	        processSearch();
	    }
	});

	$('#submit_search').click(processSearch);
});