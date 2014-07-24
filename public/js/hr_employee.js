function employeeAddEdit(addEdit)
{
	if (addEdit === undefined) 
	{
          addEdit = 'add';
    }

    if (addEdit==='add')
    {
    	document.getElementById("divView").style.display = 'none';
    	document.getElementById("divEdit").style.display = 'block';
    }
    elseif(addEdit='view')
    {
    	document.getElementById("divView").style.display = 'block';
    	document.getElementById("divEdit").style.display = 'none';
    }
}