<?php 
require_once('main_class.php');
class UserClass extends main{
	public function getCategories(){
		$fecth_row = $this->allfromdbtbl('income_categories');
		$count = $this->countrows('income_categories');
		if($count==0){
				echo $output='<option value="No Categories Yet">No Categories Yet</option>';
			}else{
				while ($row = $this->fetch_array($fecth_row)) {
					echo 
					'<option value='.htmlentities($row["categories_item"]).'>'.htmlentities($row["categories_item"]).'</option>';
				}
			}
	}
	
	public function getExpenditureCategories(){
		$fecth_row = $this->allfromdbtbl('expenditure_categories');
		$count = $this->countrows('expenditure_categories');
		if($count==0){
				echo $output='<option value="No Categories Yet">No Categories Yet</option>';
			}else{
				while ($row = $this->fetch_array($fecth_row)) {
					echo 
					'<option value='.htmlentities($row["categories_item"]).'>'.htmlentities($row["categories_item"]).'</option>';
				}
			}
	}
	public function getTotalUser(){
		$fecth_row = $this->allfromdbtbl('user');
		$count = $this->countrows('user');
		echo $count;
	}
	public function getTotalAdmin(){
		$fecth_row = $this->allfromdbtbl('admin');
		$count = $this->countrows('admin');
		echo $count;
	}
	public function getTotalIncomeCategory(){
		$fecth_row = $this->allfromdbtbl('income_categories');
		$count = $this->countrows('income_categories');
		echo $count;
	}
	public function getTotalExpenditureCategory(){
		$fecth_row = $this->allfromdbtbl('expenditure_categories');
		$count = $this->countrows('expenditure_categories');
		echo $count;
	}
	
	public function listIncomeCategories(){
		$fecth_row = $this->allfromdbtbl('income_categories');
		$count = $this->countrows('income_categories'); 
		$output= "";
			if($count==0){
				echo $output.='
                    <li><a><i class="fa fa-plus text-primary"></i> Empty!!!</a>
                    </li>';
			} else{
				$x=0;
				$x++; 
				$classColor = ($x%2 == 0)? 'whiteBackground': 'lightBlue';
				
				$i=1;
				while ($row = $this->fetch_array($fecth_row)) {
					$output.= 
						'<li><a href="javascript:;" onClick="sendData(\''.$row['id'].'\')" style="color:#fff; margin-top:10px;">'.$row['categories_item'].'</a>
                    </li>';
						$i++;
				}
				echo $output;
			}
	}
	public function listIncomeSubCategories(){
		$fecth_row = $this->allfromdbtbl('income_sub_categories');
		$count = $this->countrows('income_sub_categories'); 
		$output= "
			<caption>Total Number of Income Sub Category Availbale &nbsp;<span class='badge'>".$count."</span></caption>
			 <thead>
                <tr style='background:#036; color:#fff;'>
                    <th>S/N</th>
                    <th>Category</th>
					<th>Sub Category</th>
                    <th>Added By</th>
					<th>Time Added</th>
					<th>Action</th>
                </tr>
            </thead>
			<tbody>";
			if($count==0){
				echo $output.='<tr><td colspan="10"><b>No Income Sub Category Available Yet.</b></td></tr>';
			} else{
				$x=0;
				$x++; 
				$classColor = ($x%2 == 0)? 'whiteBackground': 'lightBlue';
				
				$i=1;
				while ($row = $this->fetch_array($fecth_row)) {
					$output.= 
						"<tr class='$classColor'>
							<td>{$i}</td>
							<td>".$row['categories_item']."</td>
							<td>".$row['sub_categories']."</td>
							<td>".$row['added_by']."</td>
							<td>".$row['date_time_added']."</td>
							<td width='100'>
								<button class='btn btn-danger btn-sm' title='Delete'
								onClick='delIncomeSubCategories(".$row['id'].")' data-toggle='modal' data-target='#delmodal'><i class='fa fa-trash'></i></button>
							 </td>
						</tr>\n";
						$i++;
				}
				echo $output;
			}
	}
	public function listExpenditureCategories(){
		$fecth_row = $this->allfromdbtbl('expenditure_categories');
		$count = $this->countrows('expenditure_categories'); 
		$output= "";
			if($count==0){
				echo $output.='<li><a><i class="fa text-primary"></i> Expenditure is Empty!!!</a>
                    </li>';
			} else{
				$x=0;
				$x++; 
				$classColor = ($x%2 == 0)? 'whiteBackground': 'lightBlue';
				
				$i=1;
				while ($row = $this->fetch_array($fecth_row)) {
					$output.= 
						'<li><a href="javascript:;" onClick="sendData2(\''.$row['id'].'\')" style="color:#fff; margin-top:10px;">'.$row['categories_item'].'</a>
                    </li>';
						$i++;
				}
				echo $output;
			}
	}
	
	public function listExpenditureSubCategories(){
		$fecth_row = $this->allfromdbtbl('expenditure_sub_categories');
		$count = $this->countrows('expenditure_sub_categories'); 
		$output= "
			<caption>Total Number of Expenditure Sub Category Availbale &nbsp;<span class='badge'>".$count."</span></caption>
			 <thead>
                <tr style='background:#036; color:#fff;'>
                    <th>S/N</th>
                    <th>Category</th>
					<th>Sub Category</th>
                    <th>Added By</th>
					<th>Time Added</th>
					<th>Action</th>
                </tr>
            </thead>
			<tbody>";
			if($count==0){
				echo $output.='<tr><td colspan="10"><b>No Expenditure Sub Category Available Yet.</b></td></tr>';
			} else{
				$x=0;
				$x++; 
				$classColor = ($x%2 == 0)? 'whiteBackground': 'lightBlue';
				
				$i=1;
				while ($row = $this->fetch_array($fecth_row)) {
					$output.= 
						"<tr class='$classColor'>
							<td>{$i}</td>
							<td>".$row['categories_item']."</td>
							<td>".$row['sub_categories']."</td>
							<td>".$row['added_by']."</td>
							<td>".$row['date_time_added']."</td>
							<td width='100'>
								<button class='btn btn-danger btn-sm' title='Delete'
								onClick='delExpenditureSubCategories(".$row['id'].")' data-toggle='modal' data-target='#delmodal'><i class='fa fa-trash'></i></button>
							 </td>
						</tr>\n";
						$i++;
				}
				echo $output;
			}
	}
	
	public function listAdmin(){
		$fecth_row = $this->allfromdbtbl('admin');
		$count = $this->countrows('admin'); 
		$output= "
			<caption>Total Number of Admin Availbale &nbsp;<span class='badge'>".$count."</span></caption>
			 <thead>
                <tr style='background:#036; color:#fff;'>
                    <th>S/N</th>
                    <th>Username</th>
					<th>Password</th>
					<th>Action</th>
                </tr>
            </thead>
			<tbody>";
			if($count==0){
				echo $output.='<tr><td colspan="10"><b>No Admin Available Yet.</b></td></tr>';
			} else{
				$x=0;
				$x++; 
				$classColor = ($x%2 == 0)? 'whiteBackground': 'lightBlue';
				
				$i=1;
				while ($row = $this->fetch_array($fecth_row)) {
					$output.= 
						"<tr class='$classColor'>
							<td>{$i}</td>
							<td>".$row['username']."</td>
							<td>".$row['password']."</td>
							<td width='100'>
								<button class='btn btn-danger btn-sm' title='Delete Admin'
								onClick='delAdmin(".$row['id'].")' data-toggle='modal' data-target='#delmodal'><i class='fa fa-trash'></i></button>
							 </td>
						</tr>\n";
						$i++;
				}
				echo $output;
			}
	}
	
	public function listUser(){
		$fecth_row = $this->allfromdbtbl('user');
		$count = $this->countrows('user'); 
		$output= "
			<caption>Total Number of User Availbale &nbsp;<span class='badge'>".$count."</span></caption>
			 <thead>
                <tr style='background:#036; color:#fff;'>
                    <th>S/N</th>
                    <th>Username</th>
					<th>Password</th>
					<th>Action</th>
                </tr>
            </thead>
			<tbody>";
			if($count==0){
				echo $output.='<tr><td colspan="10"><b>No User Available Yet.</b></td></tr>';
			} else{
				$x=0;
				$x++; 
				$classColor = ($x%2 == 0)? 'whiteBackground': 'lightBlue';
				
				$i=1;
				while ($row = $this->fetch_array($fecth_row)) {
					$output.= 
						"<tr class='$classColor'>
							<td>{$i}</td>
							<td>".$row['username']."</td>
							<td>".$row['password']."</td>
							<td width='100'>
								<button class='btn btn-danger btn-sm' title='Delete User'
								onClick='delUser(".$row['id'].")' data-toggle='modal' data-target='#delmodal'><i class='fa fa-trash'></i></button>
							 </td>
						</tr>\n";
						$i++;
				}
				echo $output;
			}
	}
	public function getTotalIncomeDaily(){
		$today = date('Y-m-d');
		$sql = 'SELECT SUM(amount) AS value_sum FROM `income_category_amount_entry` WHERE DATE(date_added)=CURDATE()';
		$query = $this->query($sql);
		$row =  $this->fetch_array($query); 
		$sum = $row['value_sum'];
		if($row['value_sum']==0){
			echo 0;
		}else{
			echo $sum;
		}
		
	}
	public function getTotalExpenditureDaily(){
		$today = date('Y-m-d');
		$sql = 'SELECT SUM(amount) AS value_sum FROM `expenditure_category_amount_entry` WHERE DATE(date_added)=CURDATE()';
		$query = $this->query($sql);
		$row =  $this->fetch_array($query); 
		$sum = $row['value_sum'];
		if($row['value_sum']==0){
			echo 0;
		}else{
			echo $sum;
		}
		
	}
	
	
}
$user = new UserClass();
?>