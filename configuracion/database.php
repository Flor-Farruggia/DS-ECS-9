<?php
class DataBase{
    public $db;   // handle of the db connexion
    private static $dns = "mysql:host=localhost;dbname=[nombreDB]";
    private static $user = "root";
    private static $pass = "";
    private static $instance;

    public function __construct ()
    {
        $this->db = new PDO(self::$dns,self::$user,self::$pass);
        //seteo atributos para q me devuelva excepcion ante errores
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        //si la db no esta instanciada
        if(!isset(self::$instance))
        {
            $object= __CLASS__;
            //instancio la clase
            self::$instance=new $object;
        }
        //retorno la instancia de la clase
        return self::$instance;
    }
}