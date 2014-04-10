<?php
/**
 * contact.php
 * 
 * Class contact
 * Clase contact
 * @author Victor Manuel Vallecilla Mira <vallecilla@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 01/08/2007
 * @license: 	
*/
class contact{

	private $id_number;
	private $first_name;
	private $last_name;
	private $address;
	private $phone;
	private $city;	
	private $cell_phone;
	private $email;
	private $birthday;
	private $town;

	public function __construct($phone,
								$city,
								$first_name,
								$last_name,
								$address,
								$cell_phone,
								$email,
								$birthday,
								$id_number,
								$town){

		$this->id_number=$id_number;
		$this->first_name=$first_name;
		$this->last_name=$last_name;
		$this->address=$address;
		$this->phone=$phone;
		$this->city=$city;
		$this->cell_phone=$cell_phone;
		$this->email=$email;
		$this->birthday=$birthday;
		$this->town=$town;

	}

	public function __destruct(){}

	public function setId_number($id_number){
    	$this->id_number = $id_number;
    }
	
    public function getId_number(){
    	return $this->id_number;
    }
	
	public function setPhone($phone){
		$this->login = $phone;
	}

	public function getPhone(){
		return $this->login;
	}

	public function setCity($city){
		$this->city = $city;
	}

	public function getPassword(){
		return $this->city;
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

	public function setAddress($address){
		$this->address = $address;
	}

	public function getAddress(){
		return $this->address;
	}

	public function setCell_Phone($cell_phone){
		$this->cell_phone = $cell_phone;
	}

	public function getCell_Phone(){
		return $this->cell_phone;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getEmail(){
		return $this->email;
	}
	
	public function setBirthday($birthday){
		$this->birthday = $birthday;
	}

	public function getBirthday(){
		return $this->birthday;
	}
	
	 public function setTown($town){
    	$this->town = $town;
    }
	
    public function getTown(){
    	return $this->town;
    }
}

?>