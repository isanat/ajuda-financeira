
<div class="row-fluid">

	<div class="span12">
	<div class="social-box">
          <div class="header">
              <h4>Centro de Distribuição</h4>
          </div>
          <div class="body" style="text-align:center">

           <img src="http://<?php echo $dados['host'];?>/module/cd/View/img/cd.png" width="800" />

          </div>
		</div>

	</div>
	
</div>




<!--<div class="row-fluid">
	
	<div class="span12">
	<div class="social-box">
          <div class="header">
              <h4>Faturamento Produtos</h4>
          </div>
          <div class="body">

            <table class="table table-hover">
              <tbody>
                
                <tr>
                  <th>Produto</th>
                  <th>QTD</th>
                  <th>Pontos</th>
                  <th> Valor R$</th>
                </tr>
               </tbody>
                <?php
				$total = 0;
				$qtd = 0;
				$pontos = 0;
				
                foreach($dados['model']['produtos'] as $fornecedor){
                $total += $fornecedor['subtotal'];
                $qtd += $fornecedor['qtd'];
                $pontos += $fornecedor['pontos'];
                ?>
                <tr>
                  <td><?php echo $fornecedor['pro_nome']?></td>
                  <td><?php echo $fornecedor['qtd']?></td>
                  <td><?php echo $fornecedor['pontos']?></td>
                  <td><?php echo number_format($fornecedor['subtotal'], 2, ',', '.')?></td>
                </tr>
                <?php }?>
                <tr class="success">
                  <td>Total R$</td>
                  <td><?php echo $qtd ?></td>
                  <td><?php echo $pontos ?></td>
                  <td><?php echo number_format($total, 2, ',', '.')?></td>
                </tr>
              
            </table>

          </div>
		</div>

	</div>
</div>

<div class="row-fluid">

	<div class="span12">
	<div class="social-box">
          <div class="header">
              <h4>Faturamento Fornecedor</h4>
          </div>
          <div class="body">

            <table class="table table-hover">
              <tbody>
                
                <tr>
                  <th>Fornecedor</th>
                  <th> Valor R$</th>
                  <th> Custo  R$</th>
                  <th> Liquido  R$</th>
                </tr>
               </tbody>
                <?php
				
				$total = 0;
				$custo = 0;
				$liqui = 0;
				
                foreach($dados['model']['fornecedor'] as $fornecedor){
                $total += $fornecedor['subtotal'];
				$custo += $fornecedor['custototal'];
				$liqui += $fornecedor['liquido'];
                ?>
                <tr>
                  <td><?php echo $fornecedor['fn_nome']?></td>
                  <td><?php echo number_format($fornecedor['subtotal'], 2, ',', '.')?></td>
                  <td><?php echo number_format($fornecedor['custototal'], 2, ',', '.')?></td>
                  <td><?php echo number_format($fornecedor['liquido'], 2, ',', '.')?></td>
                </tr>
                <?php }?>
                <tr class="success">
                  <td>Total R$</td>
                  <td><?php echo number_format($total, 2, ',', '.')?></td>
                  <td><?php echo number_format($custo, 2, ',', '.')?></td>
                  <td><?php echo number_format($liqui, 2, ',', '.')?></td>
                </tr>
              
            </table>

          </div>
		</div>

	</div>
	
</div>


<div class="row-fluid">

	<div class="span12">

<div class="span4">
	<div class="social-box">
          <div class="header">
              <h4>Destino Faturamento</h4>
          </div>
          <div class="body">

            <table class="table table-hover">
              <tbody>
                
                <tr>
                  <th>Destino</th>
                  <th></i> Valor R$</th>
                </tr>
               </tbody>
                <tr>
                  <td>Impostos</td>
                  <td><?php echo number_format($dados['model']['destino'][0]['impostos'], 2, ',', '.')?></td>
                </tr>
                <tr>
                  <td>TI</td>
                  <td><?php echo number_format($dados['model']['destino'][0]['ti'], 2, ',', '.')?></td>
                </tr>
                <tr>
                  <td>Bônus Rede</td>
                  <td><?php echo number_format($dados['model']['destino'][0]['bonus'], 2, ',', '.')?></td>
                </tr>
                <tr>
                  <td>Total R$: </td>
                  <td><?php echo number_format($dados['model']['destino'][0]['impostos']+$dados['model']['destino'][0]['ti']+$dados['model']['destino'][0]['bonus'], 2, ',', '.')?></td>
                </tr>
              
            </table>

          </div>
		</div>

	</div>
</div>
</div>
</div>
  -->