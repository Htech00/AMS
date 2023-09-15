<?php 
class DatabaseConnect{
	
	private $connection; 
	
	public function __construct(){
		$this->Connect();
	}
	
	public function Connect(){
		$this->connection = @mysqli_connect('localhost','root','','ams');
		if(!$this->connection) {
			echo '<h2>Connection to Website/Server Failed</h2>'.mysqli_connect_errno();;
			die;
		} else {
			return true;
		}
	}
	
	
	/* Not Clear about Closing Database yet */
	public function Close_connection(){
		if(isset($this->connection)){
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}
	/* Not Clear about Closing Database yet */
	
	public function query($sql){
		$result = mysqli_query($this->connection,$sql);
		//$this->confirm_query($result);
		return $result; 
	}
	
	/* private function confirm_query($result){
		if(!$result){
			die('Database Query Failed');
		}
	} */
	
	public function escape_value($string){
		$escape_string = mysqli_real_escape_string($this->connection,$string);
		return $escape_string;
	}
	
	/* DataBase neutral Function */####################################
	public function fetch_array($result_set){
		return mysqli_fetch_array($result_set);
	}
	
	public function num_rows($rsult_set){
		return mysqli_num_rows($rsult_set);
	}
	
	public function insert_id(){
		return mysqli_insert_id($this->connection);
	}
	
	public function affected_rows(){
		return mysqli_affected_rows($this->connection);
	}
	
	/* DataBase neutral Function ends here */####################################
	
}

$connection = new DatabaseConnect();
?>