
//google.setOnLoadCallback(drawChart);

/*function drawChart() 
{
    //var obj = JSON.parse(stringJSON);
    var data = new google.visualization.DataTable(chartdata);
    /*data.addColumn('string', 'Name');
    data.addColumn('string', 'Manager');
    data.addColumn('string', 'ToolTip');
    data.addRows([
      [{v:'Mike', f:'Mike<div style="color:red; font-style:italic">President <div><img src="images/ShriAnan.jpg"></div></div>'}, '', 'The President'],
      [{v:'Jim', f:'Jim<div style="color:red; font-style:italic">Vice President</div>'}, 'Mike', 'VP'],
      ['Alice', 'Mike', ''],
      ['Bob', 'Jim', 'Bob Sponge'],
      ['Carol', 'Bob', '']
    ]);
    chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
    chart.draw(data, {allowHtml:true});
    google.visualization.events.addListener(chart,'select',orgChartClick);
  }*/

  function orgChartClick()
  {
    var selection=chart.getSelection();
    if (selection.length==1)
    {
        var item=selection[0];
    }
  }