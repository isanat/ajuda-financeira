<style>
	.cell-title {
	  font-weight: bold;
	}
	
	.cell-effort-driven {
	  text-align: center;
	}
	
	.toggle {
	  height: 9px;
	  width: 9px;
	  display: inline-block;
	}
	
	.toggle.expand {
	  background: url(../core/lib/slickgrid/images/expand.gif) no-repeat center center;
	}
	
	.toggle.collapse {
	  background: url(../core/lib/slickgrid/images/collapse.gif) no-repeat center center;
	}
	
</style>
<div class="row-fluid">
			<div class="span12">
                <section class="social-box">
                    <div class="header">
                        <link rel="stylesheet" href="../core/lib/slickgrid/slick.grid.css" type="text/css"/>
                        <link rel="stylesheet" href="../core/lib/slickgrid/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>
                        <!-- ref="examples/examples.css" type="text/css"/ -->
                        <div id="myGrid" style="width:100%;height:600px;"></div>
                    </div>
                </section>
            </div>
</div>


<?php 
//echo "<pre>"; echo "</pre>";
///$resjson = json_encode( $dados['model']['res'] );
//echo $resjson;
?>
<script src="../core/lib/slickgrid/lib/firebugx.js"></script>
<script src="../core/lib/slickgrid/lib/jquery.event.drag-2.2.js"></script>
<script src="../core/lib/slickgrid/lib/jquery.jsonp-2.4.min.js"></script>
<script src="../core/lib/slickgrid/slick.dataview.js"></script>
<script src="../core/lib/slickgrid/slick.editors.js"></script>
<script src="../core/lib/slickgrid/slick.formatters.js"></script>
<script src="../core/lib/slickgrid/slick.core.js"></script>
<script src="../core/lib/slickgrid/slick.grid.js"></script>
<script>
  // prepare the data
  /*
	$.getJSON( "http://backoffice.perfam.com.br/Rede/linearjson", function(res) {

	});
	*/


	/* CONSULTA AO BANCO DE DADOS VIA JSON E AJAX */
	
		host = location.host;
		url = 'http://'+host;
			
		var usuarios = false;
		usuarios = [];
		var res;
		$.ajax({
			url: url+'/Rede/linearjson',
			type: 'json',
			async: false,
			cache: false,
			success:function(data) {
				res = data;
			}
		});
	
	var arvore = [];
	
	
	
	//TRATAMENTO DO RETORNO
	
	
	//monta o meu recursivamente ordenando os níveis
	function montaArvore( usuariosFinal, arvore, menuTotal, idPai, count )
	{
			// itera o array de acordo com o idPai passado como parâmetro na função
			for( idMenu in menuTotal[idPai])
			{
					//alert( 'rec: '+count+' | '+menuTotal[idPai][idMenu]['usu_id']+' | '+menuTotal[idPai][idMenu]['usu_doc'] );
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']] 						= [];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['id'] 				= 0; 
					//alert(menuTotal[idPai][idMenu]['usu_doc']+' | '+count);
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['usu_id'] 			= menuTotal[idPai][idMenu]['usu_id'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['usu_doc'] 			= menuTotal[idPai][idMenu]['usu_doc'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['usu_usuario'] 		= menuTotal[idPai][idMenu]['usu_usuario'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['data_cadastro'] 	= menuTotal[idPai][idMenu]['data_cadastro'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['carreira'] 			= menuTotal[idPai][idMenu]['carreira'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['usu_email']			= menuTotal[idPai][idMenu]['usu_email'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['end_cidade']		= menuTotal[idPai][idMenu]['end_cidade'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['end_uf']	 		= menuTotal[idPai][idMenu]['end_uf'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['fone_fone']	 		= menuTotal[idPai][idMenu]['fone_fone'];
					usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['nivel'] 			= menuTotal[idPai][idMenu]['nivel'];
					if( menuTotal[idPai][idMenu]['pai'] > 0 ) {
						usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['pai'] 			= menuTotal[idPai][idMenu]['pai'];
					} else {	
						usuariosFinal[menuTotal[idPai][idMenu]['usu_doc']]['pai'] 			= 0;
					}
					
					count = count+1;
					// se o menu desta iteração tiver submenus, chama novamente a função
					if( typeof menuTotal[idMenu] !== 'undefined' ) montaArvore( usuariosFinal, arvore, menuTotal , idMenu, count);
			}
	}
	

		var res = jQuery.parseJSON( res ); //retorno json
		//tratamento do retorno JSON em array
		for (var i in res) {
			if( i > 0 ) {
				if( typeof usuarios[res[i]['parente']] === 'undefined' )  {
						usuarios[res[i]['parente']] = [];					
				} 
				if( typeof usuarios[res[i]['parente']][res[i]['usu_doc']] === 'undefined' )  {
					usuarios[res[i]['parente']][res[i]['usu_doc']] = [];				
				}
				//alert( res[i]['usu_doc']+' | '+i+' | '+res[i]['parente'] );
				usuarios[res[i]['parente']][res[i]['usu_doc']]['id'] 			= i; 
				usuarios[res[i]['parente']][res[i]['usu_doc']]['usu_id'] 		= res[i]['usu_id'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['usu_doc'] 		= res[i]['usu_doc'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['usu_usuario'] 	= res[i]['usu_usuario'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['data_cadastro']	= res[i]['datacadastro'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['carreira'] 		= res[i]['carreira'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['nivel'] 		= res[i]['nivel'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['usu_email'] 	= res[i]['usu_email'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['end_cidade'] 	= res[i]['end_cidade'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['end_uf'] 		= res[i]['end_uf'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['fone_fone'] 	= res[i]['fone_fone'];
				usuarios[res[i]['parente']][res[i]['usu_doc']]['pai'] 			= res[i]['parente'];
			} else {
				usuarios[0] 									= [];
				usuarios[0][res[i]['usu_doc']] 					= [];
				usuarios[0][res[i]['usu_doc']]['id'] 			= i; 
				usuarios[0][res[i]['usu_doc']]['usu_id'] 		= res[i]['usu_id'];
				usuarios[0][res[i]['usu_doc']]['usu_doc'] 		= res[i]['usu_doc'];
				usuarios[0][res[i]['usu_doc']]['usu_usuario'] 	= res[i]['usu_usuario'];
				usuarios[0][res[i]['usu_doc']]['data_cadastro']	= res[i]['datacadastro'];
				usuarios[0][res[i]['usu_doc']]['carreira'] 		= res[i]['carreira'];
				usuarios[0][res[i]['usu_doc']]['nivel'] 		= res[i]['nivel'];
				usuarios[0][res[i]['usu_doc']]['usu_email'] 	= res[i]['usu_email'];
				usuarios[0][res[i]['usu_doc']]['end_cidade'] 	= res[i]['end_cidade'];
				usuarios[0][res[i]['usu_doc']]['end_uf'] 		= res[i]['end_uf'];
				usuarios[0][res[i]['usu_doc']]['fone_fone'] 	= res[i]['fone_fone'];
				usuarios[0][res[i]['usu_doc']]['pai'] 			= 0;
			}
		}
		
	
		var usuariosFinal = [];
		montaArvore( usuariosFinal, arvore, usuarios, 0, 0);
		usuarios = usuariosFinal;

		//tratamento dos ID parent para o colpase (	 + / - )
		count = 0;
		for( var id in usuarios ) {
			usuarios[id]['id'] = count;
			if( usuarios[id]['pai'] > 0 ) {
				usuarios[id]['pai'] = usuarios[usuarios[id]['pai']]['id'];
			}
			count = count+1;
		}
	/* END - CONSULTA AO BANCO DE DADOS VIA JSON E AJAX */

function requiredFieldValidator(value) {
  if (value == null || value == undefined || !value.length) {
    return {valid: false, msg: "This is a required field"};
  } else {
    return {valid: true, msg: null};
  }
}


var TaskNameFormatter = function (row, cell, value, columnDef, dataContext) {
  value = value.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");
  var spacer = "<span style='display:inline-block;height:1px;width:" + (15 * dataContext["indent"]) + "px'></span>";
  var idx = dataView.getIdxById(dataContext.id);
  if (data[idx + 1] && data[idx + 1].indent > data[idx].indent) {
    if (dataContext._collapsed) {
      return spacer + " <span class='toggle expand'></span>&nbsp;" + value;
    } else {
      return spacer + " <span class='toggle collapse'></span>&nbsp;" + value;
    }
  } else {
    return spacer + " <span class='toggle'></span>&nbsp;" + value;
  }
};

var dataView;
var grid;
var data = [];
var columns = [
  {id: "usuario", name: "ID", field: "usuario", width: 250, cssClass: "cell-title", formatter: TaskNameFormatter, editor: Slick.Editors.Text, validator: requiredFieldValidator},
  {id: "nivel", name: "Nível", field: "nivel", width: 50}, 
  {id: "usu_email", name: "Email", field: "usu_email", width: 300},
  {id: "end_cidade", name: "Cidade", field: "end_cidade", width: 200},
  {id: "end_uf", name: "UF", field: "end_uf", width: 40},
  {id: "fone_fone", name: "Fone", field: "fone_fone", width: 130},
  {id: "data_cadastro", name: "Data Cadastro", field: "data_cadastro", width: 150},
  {id: "carreira", name: "Carreira", field: "carreira", width: 100} 
];

var options = {
  editable: false,
  enableAddRow: true,
  enableCellNavigation: true,
  asyncEditorLoading: false 
};

var percentCompleteThreshold = 0;
var searchString = "";

function myFilter(item) {
  if (item["percentComplete"] < percentCompleteThreshold) {
    return false;
  }

  if (searchString != "" && item["title"].indexOf(searchString) == -1) {
    return false;
  }

  if (item.parent != null) {
    var parent = data[item.parent];

    while (parent) {
      if (parent._collapsed || (parent["percentComplete"] < percentCompleteThreshold) || (searchString != "" && parent["title"].indexOf(searchString) == -1)) {
        return false;
      }

      parent = data[parent.parent];
    }
  }

  return true;
}

function percentCompleteSort(a, b) {
  return a["percentComplete"] - b["percentComplete"];
}

$(function () {
  var indent = 0;
  var parents = [];
  var count = 0;
  // prepare the data
  for (var i in usuarios ) {
    var d = (data[count] = {});
    var parent;

	indent = usuarios[i]['nivel'];
	if( count > 0 ) {
		//parent = usuarios[usuarios[i]['pai']]['id'];
		parent = usuarios[i]['pai'];
	} else {
		parent = null;	
	}
	//usuarios[res[i]['parente']][res[i]['usu_doc']]['usu_id']
	//alert( 'slick: '+count+' | '+i+' | '+parent+' | '+usuarios[i]['pai']+' | '+usuarios[i]['nivel']+' | '+usuarios[i]['usu_doc'] );
    d["id"] = "id_" + count;
    d["indent"] = indent;
    d["parent"] = parent;
    d["usuario"] = usuarios[i]['usu_usuario'];
    d["usu_email"] = usuarios[i]['usu_email'];
    d["end_cidade"] = usuarios[i]['end_cidade'];
    d["end_uf"] = usuarios[i]['end_uf'];
    d["fone_fone"] = usuarios[i]['fone_fone'];
    d["nivel"] = usuarios[i]['nivel'];
    d["data_cadastro"] = usuarios[i]['data_cadastro'];
    d["carreira"] = usuarios[i]['carreira'];
	count++;
  }


  // initialize the model
  dataView = new Slick.Data.DataView({ inlineFilters: true });
  dataView.beginUpdate();
  dataView.setItems(data);
  dataView.setFilter(myFilter);
  dataView.endUpdate();


  // initialize the grid
  grid = new Slick.Grid("#myGrid", dataView, columns, options);

  grid.onCellChange.subscribe(function (e, args) {
    dataView.updateItem(args.item.id, args.item);
  });

  grid.onAddNewRow.subscribe(function (e, args) {
    var item = {
      "id": "new_" + (Math.round(Math.random() * 10000)),
      "indent": 0,
      "title": "New task",
      "duration": "1 day",
      "percentComplete": 0,
      "start": "01/01/2009",
      "finish": "01/01/2009",
      "effortDriven": false};
    $.extend(item, args.item);
    dataView.addItem(item);
  });

  grid.onClick.subscribe(function (e, args) {
    if ($(e.target).hasClass("toggle")) {
      var item = dataView.getItem(args.row);
      if (item) {
        if (!item._collapsed) {
          item._collapsed = true;
        } else {
          item._collapsed = false;
        }

        dataView.updateItem(item.id, item);
      }
      e.stopImmediatePropagation();
    }
  });


  // wire up model events to drive the grid
  dataView.onRowCountChanged.subscribe(function (e, args) {
    grid.updateRowCount();
    grid.render();
  });

  dataView.onRowsChanged.subscribe(function (e, args) {
    grid.invalidateRows(args.rows);
    grid.render();
  });


  var h_runfilters = null;

  // wire up the slider to apply the filter to the model
  $("#pcSlider").slider({
    "range": "min",
    "slide": function (event, ui) {
      Slick.GlobalEditorLock.cancelCurrentEdit();

      if (percentCompleteThreshold != ui.value) {
        window.clearTimeout(h_runfilters);
        h_runfilters = window.setTimeout(dataView.refresh, 10);
        percentCompleteThreshold = ui.value;
      }
    }
  });


  // wire up the search textbox to apply the filter to the model
  $("#txtSearch").keyup(function (e) {
    Slick.GlobalEditorLock.cancelCurrentEdit();

    // clear on Esc
    if (e.which == 27) {
      this.value = "";
    }

    searchString = this.value;
    dataView.refresh();
  })
})
</script>