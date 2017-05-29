<div class="row-fluid">
    <div class="">        
        <a class="icon-btn span2 offset4" href="#">
        <div><strong><h3><?php echo $dados['model']['contacorrente']['numero']."-".$dados['model']['contacorrente']['dv'];?></h3></strong></div>
        <span class="badge label-info badge-right">conta</span>
        </a>
    </div>
</div>

<div class="row-fluid">
    <div class="social-box">
        <div class="header">
          <h4>Saldo Líquido (disponível para saques em R$)*</h4>
        </div>
        <div class="body">
            <div class="row-fluid">
                <a class="icon-btn icon-btn-blue span2 offset2" href="#">
                <div><strong><h3>R$ <?php echo $dados['model']['contacorrente']['saldo']['creditoReal'];?></h3></strong></div>
                <span class="badge label-info badge-right">crédito</span>
                </a>
                <a class="icon-btn icon-btn-orange span2" href="#">
                <div><strong><h3>R$ <?php echo $dados['model']['contacorrente']['saldo']['debitoReal'];?></h3></strong></div>
                <span class="badge  label-info badge-right">débito</span>
                </a>
                <a class="icon-btn icon-btn-green span2" href="#">
                <div><strong><h3>R$ <?php echo $dados['model']['contacorrente']['saldo']['disponivelReal'];?></h3></strong></div>
                <span class="badge label-info badge-right">disponível</span>
                </a>
            </div>
        </div>
    </div>
</div>

* (crédito) - (débito) = (disponível)<br>
<?php 
//echo "<pre>"; print_r( $dados ); echo "</pre>"; 
?>