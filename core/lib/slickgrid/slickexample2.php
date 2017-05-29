<link rel="stylesheet" href="slick.grid.css" type="text/css"/>
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>
<link rel="stylesheet" href="examples/examples.css" type="text/css"/>

<div id="myGrid" style="width:100%;height:600px;"></div>
<script src="lib/firebugx.js"></script>
<script src="lib/jquery-1.7.min.js"></script>
<script src="lib/jquery-ui-1.8.16.custom.min.js"></script>
<script src="lib/jquery.event.drag-2.2.js"></script>
<script src="lib/jquery.jsonp-2.4.min.js"></script>
<script src="slick.dataview.js"></script>
<script src="slick.core.js"></script>
<script src="slick.grid.js"></script>
<script>
dataView = new Slick.Data.DataView();
var columns = [
  {id: "usu_id", name: "usu_id", width: 40, field: "usu_id"},
  {id: "usu_nome", name: "usu_nome", width: 150, field: "usu_nome"},
  {id: "usu_usuario", name: "usu_usuario", width: 80, field: "usu_usuario"},
  {id: "usu_doc", name: "usu_doc", width: 50, field: "usu_doc"}
];

var options = {
	rowHeight: 64,
	editable: false,
	enableAddRow: false,
	enableCellNavigation: false
};
//grid = new Slick.Grid("#myGrid", dataView, columns, options);

// wire up model events to drive the grid
dataView.onRowCountChanged.subscribe(function (e, args) {
  grid.updateRowCount();
  grid.render();
});

dataView.onRowsChanged.subscribe(function (e, args) {
  grid.invalidateRows(args.rows);
  grid.render();
});

// When user clicks button, fetch data via Ajax, and bind it to the dataview. 
$(document).ready(function() {
  $.getJSON('http://backoffice.perfam.com.br/Rede/linearjson', function(data) {
    //dataView.beginUpdate();
    grid = new Slick.Grid("#myGrid", data, columns, options);
    //dataView.endUpdate();
  });
});
</script>	
