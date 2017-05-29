<?php

include_once( '../Model/ContaCorrente.php' );

$contaCorrente = new ContaCorrente();

$numeroConta = $contaCorrente->gerarNovaContaCorrente();

echo "<pre>"; print_r( $numeroConta ); echo "</pre>";