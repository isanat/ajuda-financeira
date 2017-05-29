<?php

abstract class DataMapper
{

	final public function executar($sql)
     {

         $query = $this->conexao->query($sql);

         return $query->fetchAll(PDO::FETCH_ASSOC);

     }

	final public function listar($tabela, $campos, $condicao=null) 
    {
    	$query = "SELECT $campos FROM $tabela";
    	if($condicao) $query.= " WHERE $condicao";

        $rs = $this->conexao->query($query);

        return $rs->fetchAll(PDO::FETCH_ASSOC); 
    }

    final public function ver($tabela, $campos, $condicao)
    {

    	$rs = $this->conexao->query("SELECT $campos FROM $tabela WHERE $condicao");

    	return $rs->fetch(PDO::FETCH_ASSOC);
    }
    
    final public function ValidaRegistro($tabela, $campos, $condicao)
    {
    	$rs = $this->conexao->query("SELECT $campos FROM $tabela WHERE $condicao");
    	$res = $rs->fetch(PDO::FETCH_ASSOC);
    	//echo 'res: <pre>';var_dump($res);die;
    	
    if(!empty($res)){
    		//echo 'existe';die;
    			return true;
    		
    		}else{
    			//echo 'nao existe';die;
    			return false;
    		
    		}
    }

    final public function inserir($tabela, $dados, $seq=null)
    {
    	foreach($dados as $campo => $valor) {
    		$colunas[] = $campo;
    		$valores[] = $valor;
    		$holders[] = "?";
    	}
    	$colunas = implode(', ', $colunas);
    	$holders = implode(', ', $holders);
		$query = "INSERT INTO $tabela($colunas) VALUES ($holders)";
		//print_r($dados);die;

    	$res = $this->conexao->prepare($query);

		if($seq==null)
		 {
    		$res->execute($valores);
		 }else{

			 $res->execute($valores);
			 return $this->conexao->lastInsertId($seq);

		 }

    }

    final public function editar($tabela, $dados, $condicao)
    {
		try{

			foreach($dados as $campo => $valor) {
	    		$sets[]     = "$campo = ?";
	    		$valores[] = $valor;
	    	}
	    	$sets = implode(', ', $sets);
			
			$query = "UPDATE $tabela SET $sets WHERE $condicao";
//	echo $query;die;
	    	$res = $this->conexao->prepare($query);
	    	$res->execute($valores);
	    	return true;
    	
		} catch (PDOException $e){

			$msg = 'Erro ao atualizar Usuario: ' . $e->getMessage();
			$this->log($msg);
		}
    }

    final public function excluir($tabela, $condicao)
    {
    	$this->conexao->exec("DELETE FROM $tabela WHERE $condicao");
    }

	public function encoding($codificacao)
     {

         $query = "set client_encoding to '{$codificacao}';";

         $query = $this->conexao->exec(utf8_encode($query));

     }

     public function PtUs($data)
    {
        //10/05/2013 para 2013-05-10
        $ex = explode('/', $data);

        return $ex[2].'-'.$ex[1].'-'.$ex[0];
    }

    public function UsPt($data)

    {

        //2013-05-10 para 10/05/2013

        $ex = explode('-', $data);



        return $ex[2].'/'.$ex[1].'/'.$ex[0];

    }
    
    final public function ver_isset($tabela, $dados)
    {
   
    
    	try{
    
    		$condicao = '';
    		$valores[0] = 1;
    
    		foreach($dados as $campo => $valor) {
    			$condicao     .= " AND $campo = ?";
    			$valores[] = $valor;
    		}
    
    		$query = "SELECT * FROM $tabela WHERE 1 = ? $condicao";
    		//echo $query;die;
    		
    		$res = $this->conexao->prepare($query);
    		$res->execute($valores);
    
    		$ver = $res->fetch(PDO::FETCH_ASSOC);
    		
    		if(!empty($ver)){
    		
    			return true;
    		
    		}else{
    			
    			return false;
    		
    		}
    
    	}catch (PDOException $e){
    
    		$msg = $e->getMessage();
    
    		$this->log($msg);
    
    	}
    }
    
    public function log($msg){
    
    	$ip = Controller::$ip;
    	$browser = Controller::$browser;
    	$page = Controller::$page;
    	$referer = Controller::$referer;
//     	$redirect = Controller::$redirect;

    
    	$query = $this->conexao->query("INSERT INTO tb_logdb (log_ip,log_referer,log_browser,log_page,log_msg) VALUES ('{$ip}','{$referer}','{$browser}','{$page}','{$msg}')");
    
    	
    }
}