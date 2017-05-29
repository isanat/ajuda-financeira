<?php
	include_once( '../../../core/config/DataMapper.php' );
	include_once( '../../../core/config/Banco.php' );
	include_once( '../../../core/app/Model/Pedido.php' );

	$dir = opendir( '../../../module/' );
	$log = "//*******  ".date('d/m/Y H:i:s')." *******/<br><br>";
	if ($dir) {
		while (false !== ($read = readdir($dir))) {
			if ($read != "." && $read != "..") {
				$ext = explode( '.', $read );
				if( !isset( $ext[1] ) ) {
					$log .= "Executando cliente <strong>".$read."</strong><br>";
					if( file_exists( '../../../config/config_'.$read.'.php' ) ) {
						include_once( '../../../config/config_'.$read.'.php' );
						$log .= ' - incluindo de configuração <strong>config/config_'.$read.'.php</strong><br>';
						
						$array_dados = array(
										'nome_cliente' => $read 
										);
						try {
							$pedido = new Pedido($array_db['db']);
							$ret = $pedido->admGetProcessarArquivo($array_dados);
							if( $ret ) {
								foreach( $ret AS $retorno ) {
									if( file_exists( '../../../'.$retorno['ret_path'].$retorno['ret_file_name'] ) ) {
										$log .= ' - processando arquivo '.$retorno['ret_file_name'].' em '.$retorno['ret_path'].' - ( '.$retorno['ret_total_linhas'].' linhas )<br>';
										$fileRet = fopen( '../../../'.$retorno['ret_path'].$retorno['ret_file_name'], 'r' );
										$count = 0;
										while(!feof($fileRet)) {
											usleep(2000);
											$linha = fgets($fileRet, 1024);
											$count++;
											$log .= ' - processando linha:'.$count.' '.$linha."<br>";
											$mod = ( $count % 100 );
											if( $mod == 0 ) {
												$pedido->gravaProcessamentoBoleto($retorno['ret_id'],$count);
											}
										}
										$pedido->gravaProcessamentoBoleto($retorno['ret_id'],$count);
										fclose( $fileRet );
									} else {
										$log .= ' - arquivo '.$retorno['ret_path'].$retorno['ret_file_name'].' não encontrado<br>';	
									}
								}
								$log .= '<br><hr noshade>';
							}
						} catch(Exception $e) {
							$log .= ' - não foi possível processar na base de dados <strong>'.$read.'</strong> ('.$e->getMessage().')<br>';
						}
					} else {
						$log .= ' - arquivo de configuração <strong>config/config_'.$read.'.php</strong> NÃO encontrado<br>';
					}
				}
				$pedido->desconecta();
				$log .= "<br>";
			}
		}
		closedir($dir);
	}
	$log .= "//****  END - ".date('d/m/Y H:i:s')." ****/<br>";
	
	$logBR = nl2br( $log );
	echo $logBR;