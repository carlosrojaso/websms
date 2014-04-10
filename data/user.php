<?php
/**
 * user.php
 * 
 * Class User
 * Clase Usuario
 * @author Carlos A. Rojas <carlkant@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 18/07/2007
 * @license: 	
*/


class user{
	
	private $id;
	private $client_id;
	private $profile;
	private $login;
	private $pass;
	private $status;
	private $date_req;
	private $flag;
	private $date_in; 
	private $date_mod;
	private $date_out;
	private $out_reason;

	public function __construct($login)
    {
    	$_sql = "SELECT * FROM users WHERE user_login LIKE '$login' AND user_current_flag != 0";
		//echo $_sql.'<br>';
		$link = mysql_connect('localhost', 'sms', 'qmmF85Nv');
		if (!$link) {
		    die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('sms', $link) or die('Could not select database.');

		$result = mysql_query($_sql);

    	if($num_rows = mysql_num_rows($result))//encontrado
		{
			$row = mysql_fetch_assoc($result);
			
			$this->id = $row[id_user];
		    $this->client_id = $row[id_client];
	        $this->profile = $row[user_prof_cd];
	        $this->login = $row[user_login];
	        $this->pass = $row[user_pass];
	        $this->status = $row[user_status_cd];
	        $this->date_req = $row[user_date_req];
	        $this->flag = $row[user_current_flag];
	        $this->date_in = $row[user_date_in];
	        $this->date_mod = $row[user_date_mod];
	        $this->date_out = $row[user_date_out];
	        $this->out_reason = $row[user_out_reason];

		}
		else{ // no se encontro
			$this->id = -1;
		}
		mysql_close($link);

    }
	
	public function __destruct()
    {}
    
    
    public function setId($id){
    	$this->id = $id;
    }
    public function setClient_id($client_id){
    	$this->client_id = $client_id;
    }
    public function setProfile($profile){
    	$this->profile = $profile;
    }
    public function setLogin($login){
    	$this->login = $login;
    }
    public function setPass($pass){
    	$this->pass = $pass;
    }
    public function setStatus($status){
    	$this->status = $status;
    }
    public function setDate_req($date_req){
    	$this->date_req = $date_req;
    }
    public function setFlag($flag){
    	$this->flag = $flag;
    }
    
    public function setDate_in ($date_in){
    	$this->date_in = $date_in;
    }
    
    public function setDate_mod ($date_mod){
    	$this->date_mod = $date_mod;
    }
    
    public function setDate_out ($date_out){
    	$this->date_out = $date_out;
    }
    
    public function setOut_reason ($out_reason){
    	$this->out_reason = $out_reason;
    }
    
    public function getId(){
    	return $this->id;
    }
    public function getClient_id(){
    	return $this->client_id;
    }
    public function getProfile(){
    	return $this->profile;
    }
    public function getLogin(){
    	return $this->login;
    }
    public function getPass(){
    	return $this->pass;
    }
    public function getStatus(){
    	return $this->status;
    }
    public function getDate_req(){
    	return $this->date_req;
    }
    public function getFlag(){
    	return $this->flag;
    }
    
    public function getDate_in (){
    	return $this->date_in;
    }
    
    public function getDate_mod (){
    	return $this->date_mod;
    }
    
    public function getDate_out (){
    	return $this->date_out;
    }
    
    public function getOut_reason (){
    	return $this->out_reason;
    }
    
}
?>
