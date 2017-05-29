<?php $banco = Banco::conecta('pgsql','mmn'); ?>
    <link rel="stylesheet" href="../lib/rede/css/jquery.jOrgChart.css"/>
    <link rel="stylesheet" href="../lib/rede/css/custom.css"/>
    <link href="../css/prettify.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="../lib/rede/prettify.js"></script>




    <script src="../lib/rede/jquery.jOrgChart.js"></script>

    <script>
    jQuery(document).ready(function() {
        $("#org").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : false
        });

        $('.primeiro').click(function(){

            var valor = $(this).html();
            alert(valor)

        });
    });
    </script>
  </head>

  <body onload="prettyPrint();">
<ul id="org" style="display:none">
    <li class="primeiro">
    <?php $nome = explode(' ',$_SESSION['usuario']['usu_nome']); echo $nome[0]?>
        <ul>

        <?php $primeiro = $banco->executar("SELECT * FROM tb_usuarios WHERE fk_usu = '".$_SESSION['usuario']['usu_cpf']."' limit 5");
        foreach($primeiro as $valor_p)
        {
			echo '<li class="primeiro">'.$valor_p['usu_nome'];
			$segundo = $banco->executar("SELECT * FROM tb_usuarios WHERE fk_usu = '".$valor_p['usu_cpf']."' limit 5");
			if(!empty($segundo[0])){echo '<ul>';
				foreach($segundo as $valor_s)
				{
					echo '<li>'.$valor_s['usu_nome'];
					$terceiro = $banco->executar("SELECT * FROM tb_usuarios WHERE fk_usu = '".$valor_s['usu_cpf']."' limit 5");
					if(!empty($terceiro[0])){echo '<ul>';
					foreach($terceiro as $valor_t)
					{
						echo '<li>'.$valor_t['usu_nome'];

						$quarto = $banco->executar("SELECT * FROM tb_usuarios WHERE fk_usu = '".$valor_t['usu_cpf']."' limit 5");
						if(!empty($quarto[0])){echo '<ul>';
						foreach($quarto as $valor_q)
						{
							echo '<li>'.$valor_q['usu_nome'];



								$quinto = $banco->executar("SELECT * FROM tb_usuarios WHERE fk_usu = '".$valor_q['usu_cpf']."' limit 5");
								if(!empty($quinto[0])){echo '<ul>';
								foreach($quinto as $valor_qu)
								{
									echo '<li>'.$valor_qu['usu_nome'].'</li>';
								}
								echo '</ul></li>';}else{echo '</li>';}



						}
						echo '</ul></li>';}else{echo '</li>';}

					}
					echo '</ul></li>';}else{echo '</li>';}
				}
			echo '</ul></li>';}else{echo '</li>';}
        }


        ?>
        </ul>
    </li>
</ul>

    <div id="chart" class="orgChart"></div>

    <script>
        jQuery(document).ready(function() {

            /* Custom jQuery for the example */
            $("#show-list").click(function(e){
                e.preventDefault();

                $('#list-html').toggle('fast', function(){
                    if($(this).is(':visible')){
                        $('#show-list').text('Hide underlying list.');
                        $(".topbar").fadeTo('fast',0.9);
                    }else{
                        $('#show-list').text('Show underlying list.');
                        $(".topbar").fadeTo('fast',1);
                    }
                });
            });

            $('#list-html').text($('#org').html());

            $("#org").bind("DOMSubtreeModified", function() {
                $('#list-html').text('');

                $('#list-html').text($('#org').html());

                prettyPrint();
            });
        });
    </script>