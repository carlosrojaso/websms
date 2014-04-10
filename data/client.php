<?php
/**
 * client.php
 * 
 * Class client
 * Clase client
 * @author Victor Manuel Vallecilla Mira <vallecilla@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 01/08/2007
 * @license: 	
*/
class client{
	private $id_number;
	private $code;
	private $first_name;
	private $last_name;
	private $birthday;
	private $comp_name;
	private $phone1;
	private $phone2;
	private $fax;
	private $cellphone;
	private $email;
	private $address;
	private $town;
	private $postal_cod;	
	
	public function __construct($id_number,
							 	$code,
							 	$first_name,
							 	$last_name,
							 	$birthday,
							 	$comp_name,
							 	$phone1,
							 	$phone2,
							 	$fax,
							 	$cellphone,
							 	$email,
							 	$address,
							 	$town,
							 	$postal_cod){
		
		$this->id_number=$id_number;
		$this->code=$code;
		$this->first_name=$first_name;
		$this->last_name=$last_name;
		$this->birthday=$birthday;
		$this->comp_name=$comp_name;
		$this->phone1=$phone1;
		$this->phone2=$phone2;
		$this->fax=$fax;
		$this->cellphone=$cellphone;
		$this->email=$email;
		$this->address=$address;
		$this->town=$town;
		$this->postal_cod=$postal_cod;
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
    
    public function setFirst_Name($first_name){
    	$this->first_name = $first_name;
    }
	
    public function getFirst_Name(){
    	return $this->first_name;
    }
    
    public function setLast_name($last_name){
    	$this->last_name = $last_name;
    }
	
    public function getLast_name(){
    	return $this->last_name;
    }
    
    public function setBirthday($birthday){
    	$this->birthday = $birthday;
    }
	
    public function getBirhtday(){
    	return $this->birthday;
    }
    
    
    public function setComp_name($comp_name){
    	$this->comp_name = $comp_name;
    }
	
    public function getComp_name(){
    	return $this->comp_name;
    }
    
    public function setPhone1($phone1){
    	$this->phone1 = $phone1;
    }
	
    public function getPhone1(){
    	return $this->phone1;
    }
    
    public function setPhone2($phone2){
    	$this->phone2 = $phone2;
    }
	
    public function getPhone2(){
    	return $this->phone2;
    }
    
    public function setFax($fax){
    	$this->fax = $fax;
    }
	
    public function getFax(){
    	return $this->fax;
    }
    
    public function setCellphone($cellphone){
    	$this->cellphone = $cellphone;
    }
	
    public function getCellphone(){
    	return $this->cellphone;
    }
    
    public function setEmail($email){
    	$this->email = $email;
    }
	
    public function getEmail(){
    	return $this->email;
    }
    
    public function setAddress($address){
    	$this->address = $address;
    }
	
    public function getAddress(){
    	return $this->address;
    }
    
    public function setTown($town){
    	$this->town = $town;
    }
	
    public function getTown(){
    	return $this->town;
    }
    
    public function setPostal_cod($postal_cod){
    	$this->postal_cod = $postal_cod;
    }
	
    public function getPostal_cod(){
    	return $this->postal_cod;
    }
}

?>