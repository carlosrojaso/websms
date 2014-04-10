<?php
/**
 * bill.php
 * 
 * Class bill
 * Clase bill
 * @author Victor Manuel Vallecilla Mira <vallecilla@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 01/08/2007
 * @license: 	
*/
class bill{
	
	private $id_number;
	private $code;
	private $value;
	private $value_vat;
	private $value_vat;
	private $total_value;
	private $pay_date;
	
	
	public function __construct($id_number,
								$code,
								$value,
								$value_vat,
								$total_value,
								$pay_date){
		
		$this->id_number=$id_number;
		$this->code=$code;
		$this->value=$value;
		$this->value_vat=$value_vat;
		$this->total_value=$total_value;
		$this->pay_date=$pay_date;		
		
	}
	
	public function __destruct(){
		
	}
	
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
    
    public function setValue($value){
    	$this->value = $value;
    }
	
    public function getValue(){
    	return $this->value;
    }
    
    public function setValue_vat($value_vat){
    	$this->value_vat = $value_vat;
    }
	
    public function getValue_vat(){
    	return $this->value_vat;
    }
    
    public function setTotal_value($total_value){
    	$this->total_value = $total_value;
    }
	
    public function getTotal_value(){
    	return $this->total_value;
    }
    
    public function setPay_date($pay_date){
    	$this->pay_date = $pay_date;
    }
	
    public function getPay_date(){
    	return $this->pay_date;
    }
    
}

?>