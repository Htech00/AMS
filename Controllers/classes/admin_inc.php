<?php 
require_once('../classes/db_class.php');
require_once('../classes/user_class.php');
require_once('../classes/main_class.php');



if(isset($_GET['action']) && $_GET['action']!== ""){
	switch($_GET['action']){
		case "updateDailyIncome":
			$amount =$_POST['amount'];
			$id = $_POST['id'];
			$user->updateDailyIncome($amount,$id);
			break;
		case "delDailyIncome":
			$delDailyIncome = $main->clean($_POST['value']);
			$main->Deletedata($delDailyIncome,'income_category_amount_entry','id');
			break;
		case "getDailyIncome":
			$user->list_daily_income();
			break;
		case "updateDailyExpenditure":
			$amount =$_POST['amount'];
			$id = $_POST['id'];
			$user->updateDailyExpenditure($amount,$id);
			break;
		case "delDailyExpenditure":
			$delDailyExpenditure = $main->clean($_POST['value']);
			$main->Deletedata($delDailyExpenditure,'expenditure_category_amount_entry','id');
			break;
		case "getDailyExpenditure":
			$user->list_daily_expenditure();
			break;
	}
} else {
	return false;
} 
	
?>
