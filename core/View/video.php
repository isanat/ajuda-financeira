<?php if(!empty($dados['model']['inativo'][0])){ ?>
<div class="alert alert-error">
<strong>ATENÇÃO!</strong> 
Você tem até o dia <strong><?php echo $dados['model']['inativo'][0]['ped_data_expira']; ?></strong> para efetuar sua 1º doação.</div>
<?php } ?>

<div class="social-box">
  <div class="header">
      <h4>Víde de Apresentação</h4>
  </div>
  <div class="body" style="text-align:center">         
     
     
     
     <iframe width="560" height="315" src="https://www.youtube.com/embed/yr4lK-lj-30" frameborder="0" allowfullscreen></iframe>
    
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/jquery.media.js"></script>
        <script type="text/javascript">    $(function() {
                $('a.media').media({width:700, height:500});
            });
        </script>        
        <div id="main"><a class="media" href="http://<?php echo $dados['host'];?>/core/View/slides/Livro PHP e MySQL.pdf"></a></div>-->        
 </div>
</div>