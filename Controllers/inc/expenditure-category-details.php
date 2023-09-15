<?php 
require_once('../../Controllers/classes/main_class.php');
require_once('../../Controllers/classes/user_class.php'); 

function sendResult($id){
	session_start();
	$main=new main;
	$user = new UserClass;
	$id=$_POST['id'];
		$sql = "SELECT * from `expenditure_categories` WHERE `id` ='".$id."'";
		$query = $main->query($sql);
		$row=$main->fetch_array($query);
		$category = $main->clean($row['id']);
		$categoryItem = $main->clean($row['categories_item']);
		$sql1 = "SELECT * from expenditure_sub_categories WHERE categories_item='".$id."'";
		$getName = $main->query($sql1);
		$sql2 = "SELECT * from expenditure_categories WHERE id='".$category."'";
		$getName2 = $main->query($sql2);
		
		$sql3 = "SELECT * from expenditure_sub_categories WHERE categories_item='".$category."'";
		$getName3 = $main->query($sql3);
		/*$getRow = $main->fetch_array($sql1);*/
		$count = $main->num_rows($getName);
		$count1 = $main->num_rows($getName2);
		
		$sqlSumCat = 'SELECT SUM(amount) AS value_sum FROM `expenditure_category_amount_entry` WHERE DATE(date_added)=CURDATE()  and `categories_item` = "'.$row['categories_item'].'"';
		$querySumCat = $main->query($sqlSumCat);
		$rowSumCat =  $main->fetch_array($querySumCat);
		$sum = $rowSumCat['value_sum'];
		
			if($count==0 and $count1==0 ){
				echo $output = 'No expenditure Category Item Available';
			}else{
				if($rowSumCat['value_sum']==""){
					echo "<tr><td class='col-sm-12 col-xs-12 col-md-12 col-lg-12'><div class='col-sm-12 col-xs-12 col-md-12 col-lg-12' style='margin-bottom:10px;font-weight:bold;font-size:16px;'>".$row['categories_item']."<span class='text-danger'> Total expenditure = # 0.00</span></div></td>
					</tr>";
				}else{
					echo "<tr><td class='col-sm-12 col-xs-12 col-md-12 col-lg-12'><div class='col-sm-12 col-xs-12 col-md-12 col-lg-12' style='margin-bottom:10px;font-weight:bold;font-size:16px;'>".$row['categories_item']."<span class='text-danger'> Total expenditure = # ".$sum."</span></div></td>
					</tr>";
				}
				
				 while ($getRow = $main->fetch_array($getName) and $getRow1 = $main->fetch_array($getName3) ) {
					$i=0;
					if($getRow>0){
					echo  
						"<tr class='tbl_row'>
							<td>".ucwords($getRow['sub_categories'])."</td>
							<td><input type='number' class='resultInput test form-control'></td>
							</tr>";
						$i++;
				}
				 }
				if($getRow[2]==$getRow1[2]){
					echo  
						"<tr class='tbl_row'>
							<td>".ucwords($categoryItem)."</td>
							<td><input type='number' class='resultInput test form-control'></td>
							</tr>";
				
				 }
			'</tbody>';
            
		//echo $output;
		echo	"
					<td><div class='row'>
							<div class='col-sm-4 col-xs-4 col-md-4 col-lg-4 form-group'>
                            	<label for='date'>expenditure Date:</label>
                            </div>
                            <div class='col-sm-4 col-xs-4 col-md-4 col-lg-4 form-group cal'>
                            	<input type='text' id='date' placeholder='yyyy-mm-dd' class='date form-control input-sm'/>
                            </div>
                            <div class='col-sm-4 col-xs-4 col-md-4 col-lg-4 form-group'>
                            	<label for='date'><i class='fa fa-calendar fa-2x'></i></label>
                            </div>
                        </div></td>
						
					<td><button class='btn btn-info btn-lg col-sm-12 col-xs-12 col-md-12 col-lg-12' onClick='submitResult2()' id='submitResult' title='Submit Result'><i class='fa fa-sign-in'></i> Submit</button>&nbsp;&nbsp;</td>";
					
					$_SESSION['id']=$category;
					$_SESSION['category']=$categoryItem;

	}
}
	
		
	sendResult($_POST['id']);
	
	
?>
<script type="text/javascript">
var d = new Date();
var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
	$('.date').datepicker({
		rtl: true,
		enableOnReadonly: true,
		showOnFocus: true,
		minViewMode: 0,
		startDate: -Infinity,
		maxViewMode: 4,
		container: 'body',
		calendarWeeks: false,
		format: 'yyyy-mm-dd'
  });
  $('.date').val(strDate);
	</script>