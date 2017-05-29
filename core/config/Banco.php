<?php
 ini_set('display_erros',0);
//include_once('DataMapper.php');

class Banco extends DataMapper
{
     private static $db;
     public static $pgsql;
     public $conexao;

     public static function conecta($banco,$db)
     {

         self::$db = $db;
         if(!self::$$banco)
         {
             $metodo = 'conecta_'.$banco;

             self::$$banco = new Banco();
             self::$$banco->$metodo();
		 }
		 
         return self::$$banco;
     }

     public function conecta_pgsql()
     {
    
    global $array_db;
    
    $username = $array_db['username'];
    $password = $array_db['password'];
    $hostname = $array_db['hostname'];
    $port	  = $array_db['port'];
    $db = self::$db;

             $options = array('CharacterSet ' => 'UTF-8');

	try{

             $this->conexao = new PDO("pgsql:dbname=".$db.";host=".$hostname."; port=".$port."", $username, $password, $options);
             $this->conexao->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            //echo 'Pgsql';
         }
         catch( PDOException $e )
         {
             $this->conexao = null;
             echo "Conexao Falhou";
             die;
         }
     }
	 
	 public function desconecta_pgsql() {
		$this->conexao = null;
		self::$pgsql = null;
	 }

}
