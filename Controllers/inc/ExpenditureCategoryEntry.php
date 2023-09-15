<?php 
require_once('../../Controllers/classes/main_class.php');

function submitResult($data) {
	session_start();
	$main = new main();
	if (isset($data)) {
			$rowArr = (strstr($data,'|'))?explode('|',$data):array($data);
			foreach ($rowArr as $row) {
				$col = explode(',',$row);				
				
				$i=0;
				$id=$_SESSION['id'];
				$categoryItem = $_SESSION['category'];
				
				//QUERY FOR GETTING expenditure AMOUNT
				$sql = "SELECT * from `expenditure_category_amount_entry` WHERE `sub_categories`='".$col[0]."' AND date_added='".$col[2]."'";
				$query  = $main->query($sql);
				$num_rows = $main->num_rows($query);
				
				//QUERY FOR GETTING MONTHLY TABLE DETAILS
				$sql_month = "SELECT * from `monthly_expenditure` WHERE `sub_categories`='".$col[0]."' AND MONTH(date_added)=MONTH(now())";
				$query_month  = $main->query($sql_month);
				$num_rows_month = $main->num_rows($query_month );
				
				//QUERY FOR SUMMING MONTHLY SUMMARY expenditure AMOUNT
				$date = date('m', strtotime($col[2]));
				$year = date('Y', strtotime($col[2]));
				$d = date('Y-m', strtotime($col[2]));
				$sqlSumMonthCat = "SELECT SUM(amount) AS value_sum FROM `monthly_expenditure` WHERE MONTH(date_added)='".$date."' AND `sub_categories` = '".$col[0]."'";
				$querySumMonthCat = $main->query($sqlSumMonthCat);
				$rowSumMonthCat =  $main->fetch_array($querySumMonthCat);
				$sumMonthCat = $rowSumMonthCat['value_sum'];
				$sumMonthCatAll = $sumMonthCat + $col[1];
				
				//QUERY FOR SUMMING expenditure AMOUNT
				$sqlSumCat = "SELECT SUM(amount) AS value_sum FROM `expenditure_category_amount_entry` WHERE date_added='".$col[2]."'  AND `sub_categories` = '".$col[0]."'";
				$querySumCat = $main->query($sqlSumCat);
				$rowSumCat =  $main->fetch_array($querySumCat);
				$sum = $rowSumCat['value_sum'];
				$sumAll = $sum + $col[1];
				
				//QUERY FOR SELECTING FROM expenditure CATEGORIES ITEM
				$s = $sql = "SELECT * from `expenditure_categories` WHERE `id`='".$id."'";
				$q = $main->query($s);
				$f = $main->fetch_array($q);
				
				if($num_rows>0){
					$update = "UPDATE `expenditure_category_amount_entry` SET amount ='".$sumAll."' WHERE `categories_item`='".$categoryItem."' and `sub_categories`='".$col[0]."' AND DATE(date_added)='".$col[2]."'";
					$updateQuery = $main->query($update);
				}else{
					$sql2 = "INSERT INTO expenditure_category_amount_entry(categories_item,sub_categories,amount,date_added) VALUES ('".$f['categories_item']."','$col[0]', '$col[1]','".date($col[2])."')";
					$insert = $main->query($sql2);
					echo "1";
				}
				
				if($num_rows_month>0){
					$updateMonthSummary = "UPDATE `monthly_expenditure` SET amount ='".$sumMonthCatAll."' WHERE `categories_item`='".$categoryItem."' and `sub_categories`='".$col[0]."' AND MONTH(date_added)='".$date."' AND YEAR(date_added)='".$year."' ";
					$updateMonthQuery = $main->query($updateMonthSummary);
				}else{
						$insertIntoMonth = "INSERT INTO `monthly_expenditure` (categories_item,sub_categories,amount,date_added) VALUES ('".$f['categories_item']."','$col[0]', '$col[1]','".date($col[2])."')";
						$insertstmt = $main->query($insertIntoMonth);
						echo 2;
				}
				
			}
		
	}
}

echo submitResult($_POST['data']);
?>