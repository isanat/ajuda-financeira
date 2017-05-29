<?php 

class Senha extends TbUsuarios
{
	
	public $usu_doc;
	
	public function alterar_senha(){	
	 
	 $this->usu_doc = strip_tags(trim($_SESSION['usuario']['cd_doc']));
	 
	 if(isset($_POST['confirmar']) == "ok"){
	 
	   
	   $senha =  strip_tags(trim($this->Password($_POST['senha'])));
	
	   $query = $this->banco->executar("
	    SELECT cd_nome, cd_doc, cd_senha FROM cd.tb_cd WHERE cd_doc = '{$this->usu_doc}' AND cd_senha = '{$senha}'");

	   if( !empty($query) ){	      
		  return array("template"=>"null", "retorno"=>"sim");	   
	   }else{
	      return array("template"=>"null", "retorno"=>"nao");
	   }  	   
	 }
  }
  
  
  public function update_senha_cd(){
	 if(isset($_POST['acao']) == "alterar"){		
	 
		$this->usu_doc = strip_tags(trim($_SESSION['usuario']['cd_doc']));
		
		$campo  = array( 'cd_senha'=>strip_tags(trim($this->Password($_POST['psw_nova_c']))));	

		$this->banco->editar('cd.tb_cd', $campo, "cd_doc = '{$this->usu_doc}'");
		
        return array("template"=>"null", "retorno"=>"sim");
		
	}else{
				
	    return array("template"=>"null", "retorno"=>"nao");	
		
	}   
  }
  
  
			
}