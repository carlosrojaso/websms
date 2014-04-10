<?php
/**
 * purchase.php
 * 
 * Class purchase
 * Clase purchase
 * @author Victor Manuel Vallecilla Mira <vallecilla@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 01/08/2007
 * @license: 	
*/
class purchase{
	
	private $id_number;
	private $date;
	
	public function __construct($id_number,$date){
		
		$this->id_number=$id_number;
		$this->date=$date;
		
	}
	
	public function __destruct(){
		
	}
	
	public function setId_number($id_number){
    	$this->id_number = $id_number;
    }
	
    public function getId_number(){
    	return $this->id_number;
    }
    
    public function setDate($date){
    	$this->date = $date;
    }
	
    public function getDate(){
    	return $this->date;
    }
}

?>
