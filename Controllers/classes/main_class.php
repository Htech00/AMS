<?php
require_once('db_class.php');
class main extends DatabaseConnect{
	
		public function Getpage(){
		if(!isset($_GET['p'])){
			require_once("dashboard.php");
		} else {
			switch($_GET['p']){
				case 'index':
					require_once("dashboard.php");
					break;
				case 'income-daily-summary':
					require_once("list-daily-income.php");
					break;
				case 'add-sub-categories':
					require_once("add-sub-categories.php");
					break;
				case 'expediture-add-categories':
					require_once("add expenditure categories.php");
					break;
				case 'expediture-add-sub-categories':
					require_once("add-expenditure-sub-categories.php");
					break;
				case 'add-admin':
					require_once("add-admin.php");
					break;
				case 'list-admin':
					require_once("list-admin.php");
					break;
				case 'add-user':
					require_once("add-user.php");
					break;
				case 'list-user':
					require_once("list-user.php");
					break;
				case 'list-categories':
					require_once("list-income-categories.php");
					break;
				case 'list-sub-categories':
					require_once("list-income-sub-categories.php");
					break;
				case 'list-expenditure-categories':
					require_once("list-expenditure-categories.php");
					break;
				case 'list-expenditure-sub-categories':
					require_once("list-expenditure-sub-categories.php");
					break;
				case 'change-password':
					require_once("change-password.php");
					break;
				
			}
		}
	}
	public function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return $this->escape_value($str);
	}
		
	public function countrows($tbl_name){
		$sql = "SELECT * FROM `$tbl_name`";
		$sql_run = $this->query($sql);
		$count = $this->num_rows($sql_run);
		return $count;
	}
	
	public function getwith($tbl_name,$rowwhere,$action,$field){
		$sql = "SELECT * FROM `$tbl_name` WHERE `$rowwhere` = '$action'";
		$q_run = $this->query($sql);
		$rows = $this->num_rows($q_run);
		if($rows==1){	
			while($fetch = $this->fetch_array($q_run)){
				return $fetch[$field];
			}
		}
	}
	
	public function allfromdbtbl($tbl_name){
		$sql = "SELECT * FROM `$tbl_name` ORDER BY `id` ASC";
		$sql_run = $this->query($sql);
		if($this->num_rows($sql_run) > 0){
			return $sql_run;
		} else{
			return false;
		}
	}
	
	public function checkID($tbl_name,$checkID){
		$sql = "SELECT `id` FROM `$tbl_name` WHERE `id` = '$checkID'";
		$sql_run = $this->query($sql);
		$rows = $this->num_rows($sql_run);
		return $rows;
	}
	

	
	
	//function to truncate text and show read more link 
	private  function truncate($mytext,$link,$var,$id) {  
		//Number of characters to show  
		$chars = 160;  
		$mytext = substr($mytext,0,$chars);  
		$mytext = substr($mytext,0,strrpos($mytext,' '));  
		$mytext = $mytext." <a href=$link?$var=$id class='read_mre'><button class='btn btn-primary btn-sm'>Read more</button></a>";  
		return $mytext;  
	}  
		
	public function sessionFieldGet($field){
		return $this->getwith('users','username',"".$_SESSION['username']."",$field);
	}
	public function sessionFieldGetEmail($field){
		return $this->getwith('users','email',"".$_SESSION['username']."",$field);
	}
	public function Deletedata($obj,$tbl_name,$where){
		$sql = "DELETE FROM `$tbl_name` WHERE `$where` = $obj";
		$sql_run = $this->query($sql);
		if($this->affected_rows()==1){
			echo 1;
		} else {
			echo 0;
		}
	}
	
}
///=========================views ends here ====================//////
$main = new main;
?>