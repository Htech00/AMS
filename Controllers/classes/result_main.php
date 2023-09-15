<?php 
require_once('db_class.php');

class ResultMainClass extends DatabaseConnect{
	public function CardVerification($stdID,$examNo,$session,$term,$class_arm,$classes,$category,$serial,$pin){
		$sql = "SELECT * FROM `cards` WHERE `serial` = '$serial' AND `pin` = '$pin'";
		$sql_run = $this->query($sql);
		$count = $this->num_rows($sql_run);
		if($count == 0){
			echo 0;
		} else {
			echo 1;
		}
		
		
	}
	
	public function CheckforReleasedResult($category,$examNo,$stdID,$class,$class_arm,$term,$session){
		$sql = "SELECT * FROM `$category` WHERE `Exam_no` = '$examNo' AND `stdID` = '$stdID' AND `session` = '$session' AND `term` = '$term'";
		$sql_run = $this->query($sql);
		$row = $this->fetch_array($sql_run) ;
		$releaseStatus = $row['releasedStatus'];
		return $releaseStatus;
	}
	
	public function ReportSheet($category,$examNo,$stdID,$class,$class_arm,$term,$session){
		$sql = "SELECT * FROM `$category` WHERE `Exam_no` = '$examNo' AND `stdID` = '$stdID' AND `session` = '$session' AND `term` = '$term'";
		$sql_run = $this->query($sql);
		$count = $this->num_rows($sql_run);
		
		
		$db_1st = "1stTest";
		$db_2nd = "2ndTest";
		$db_3rd = "3rdTest";
		$db_4th = "average";
		$db_5th = "exam";
		$db_6th = "total";
		$db_7th = "cum";
		$db_8th = "grade";
		$db_9th = "classAv";
		$db_10th = "subPosi";
		$db_11th = "Tremarks";
		
		$output= '
			<tr class="success" align="center">
				<th>#</th>
				<th width="20%">Subjects</th>
				<th>CA1 (100%)</th>
				<th>CA2 (100%)</th>
				<th>CA3 (100%)</th>
				<th>AVG (100%)</th>
				<th>EXAM (100%)</th>
				<th>TOTAL (100%)</th>
				<th>CUMM (100%)</th>
				<th>GRADE</th>
				<th width="10%">CLASS AVG (100%)</th>
				<th>SUB POS.</th>
				<th width="10%">T. REMARKS</th>
			</tr>
			<tbody>';
			if($count==0){
				echo $output.='<tr><td colspan="14"><b>No Result Available Yet.</b></td></tr>';
			} else{
				$x=0;
				$x++; 
				$classColor = ($x%2 == 0)? 'whiteBackground': 'graybackground';
				
				$i=1;
				while ($row = $this->fetch_array($sql_run)) {
					$output.= 
						"<tr class='$classColor'>
							<td>".$i."</td>
							<th>".$row['subject']."</th>
							<th>".$row[$db_1st]."</th>
							<th>".$row[$db_2nd]."</th>
							<th>".$row[$db_3rd]."</th>
							<th>".round($row[$db_4th])."</th>
							<th>".$row[$db_5th]."</th>
							<th>".round($row[$db_6th])."</th>
							<th>".round($row[$db_7th])."</th>
							<th>".$row[$db_8th]."</th>
							<th>".round($row[$db_9th])."</th>
							<th>".$this->ordinal($row[$db_10th])."</th>
							<th>".$row[$db_11th]."</th>
						</tr>";
						$i++;
				}
				$output.="
					
				";
				
				echo $output;
			} 
	} 
	
	public function GetAverageScore($category,$examNo,$stdID,$session,$term){
	$sql = "SELECT `average_score` FROM `$category` WHERE `Exam_no` = '$examNo' AND `stdID` = '$stdID' AND `session` = '$session' AND `term` = '$term'";
		$sql_run = $this->query($sql);
		$fetch = $this->fetch_array($sql_run);
		return  $avscore = $fetch['average_score']."%";
	}
	
	public function BehaviouralTrait($examNo,$stdID,$class,$class_arm,$term,$session){
		$sql = "SELECT * FROM `behaviouraltraits` WHERE `Exam_no` = '$examNo' AND `stdID` = '$stdID' AND `session` = '$session' AND `term` = '$term'";
		$sql_run = $this->query($sql);
		$count = $this->num_rows($sql_run);
		
		$output= '
			<tr class="success">
				<th colspan="2">BEHAVIOURAL TRAITS / PSYCHOMOTOR</th>
			</tr>
			<tbody>';
			if($count==0){
				echo $output.='<tr><td colspan="14"><b>No BEHAVIOURAL TRAITS / PSYCHOMOTOR Yet.</b></td></tr>';
			} else{
				while ($row = $this->fetch_array($sql_run)) {
					$output.= 
						"<tr class='default'>
							<td>Neatness: <span class='pull-right'>".$row['neatness']."</span></td>
							<td>Punctuality: <span class='pull-right'>".$row['punctuality']."</span></td>
						</tr>
						<tr class='default'>
							<td>Obidience: <span class='pull-right'>".$row['obidience']."</span></td>
							<td>Relationship with students: <span class='pull-right'>".$row['relationship']."</span></td>
						</tr>
						<tr class='default'>
							<td>Reliability: <span class='pull-right'>".$row['realiability']."</span></td>
							<td>Attentiveness: <span class='pull-right'>".$row['attentiveness']."</span></td>
						</tr>
						<tr class='default'>
							<td>Initiative: <span class='pull-right'>".$row['initiative']."</span></td>
							<td>Responsiblity: <span class='pull-right'>".$row['responsibility']."</span></td>
						</tr>
						<tr class='default'>
							<td>Self Control: <span class='pull-right'>".$row['self_control']."</span></td>
							<td>Cooperation: <span class='pull-right'>".$row['cooperation']."</span></td>
						</tr>
						";
				}
				echo $output;
			} 
	} 
	
	public function ReComments($examNo,$stdID,$class,$class_arm,$term,$session){
		$sql = "SELECT * FROM `commentremarks` WHERE `Exam_no` = '$examNo' AND `stdID` = '$stdID' AND `session` = '$session' AND `term` = '$term'";
		$sql_run = $this->query($sql);
		$count = $this->num_rows($sql_run);
		
		$output= '
			<tr class="success">
				<th colspan="2">REMARKS / COMMENTS</th>
			</tr>
			<tbody>';
			if($count==0){
				echo $output.='<tr><td colspan="14"><b>No REMARKS / COMMENTS Yet.</b></td></tr>';
			} else{
				while ($row = $this->fetch_array($sql_run)) {
					$output.= 
						"<tr class='default'>
							<td>House Master/Mistress Remarks:</td>
							<td>".$row['HMcomments']."</td>
						</tr>
						<tr class='default'>
							<td>Form Teacher's Remarks:</td>
							<td>".$row['FTcomments']."</td>
						</tr>
						<tr class='default'>
							<td>Principal's Remarks:</td>
							<td>".$row['Pcomments']."</td>
						</tr>
						";
				}
				echo $output;
			} 
	} 
	
	private function ordinal($number) {
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if ((($number % 100) >= 11) && (($number%100) <= 13))
			return $number. 'th';
		else
			return $number. $ends[$number % 10];
	}
	
	
}

$resultMain = new ResultMainClass;
?>