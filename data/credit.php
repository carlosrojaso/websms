<?php
/**
 * credit.php
 * 
 * Class credit
 * Clase credit
 * @author Victor Manuel Vallecilla Mira <vallecilla@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 01/08/2007
 * @license: 	
*/
class credit{
	
	private $id_number;
	private $code;
	private $name;
	private $desc;
	private $price;
	private $begin_date;
	private $end_date;
	
	

	public function __construct($id_number,
								$code,
								$name,
								$desc,
								$price,
								$begin_date,
								$end_date){
		
		$this->id_number=$id_number;
		$this->code=$code;
		$this->name=$name;
		$this->desc=$desc;
		$this->price=$price;
		$this->begin_date=$begin_date;
		$this->end_date=$end_date;
	}

	public function __destruct(){}

	public function setId_number($id_number){
    	$this->id_number = $id_number;
    }
	
    public function getId_number(){
    	return $this->id_number;
    }
    
    public function setCode($code){
    	$this->code = $code;
    }
	
    public function getCode(){
    	return $this->code;
    }
	
	public function setName($name){
    	$this->name = $name;
    }
	
    public function getName(){
    	return $this->name;
    }
    
    public function setDesc($desc){
    	$this->desc = $desc;
    }
	
    public function getDesc(){
    	return $this->desc;
    }
    
    public function setPrice($price){
    	$this->price = $price;
    }
	
    public function getPrice(){
    	return $this->price;
    }
    
    public function setBegin_date($begin_date){
    	$this->begin_date = $begin_date;
    }
	
    public function getBegin_date(){
    	return $this->begin_date;
    }
    
     public function setEnd_date($end_date){
    	$this->end_date = $end_date;
    }
	
    public function getEnd_date(){
    	return $this->end_date;
    }
          
}

?>