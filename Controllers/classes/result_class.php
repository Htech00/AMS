<?php 
require_once('rotateWatermak.php');

class Result extends PDF_Rotate{
	private function EAN13($x, $y, $barcode, $h=16, $w=.35){
   		$this->Barcode($x,$y,$barcode,$h,$w,13);
	}

	private function UPC_A($x, $y, $barcode, $h=16, $w=.35){
		$this->Barcode($x,$y,$barcode,$h,$w,12);
	}

	private function GetCheckDigit($barcode){
		//Compute the check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		$r=$sum%10;
		if($r>0)
			$r=10-$r;
		return $r;
	}

	private function TestCheckDigit($barcode){
		//Test validity of check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		return ($sum+$barcode[12])%10==0;
	}

	private function Barcode($x, $y, $barcode, $h, $w, $len){
		//Padding
		$barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
		if($len==12)
			$barcode='0'.$barcode;
		//Add or control the check digit
		if(strlen($barcode)==12)
			$barcode.=$this->GetCheckDigit($barcode);
		elseif(!$this->TestCheckDigit($barcode))
			$this->Error('Incorrect check digit');
		//Convert digits to bars
		$codes=array(
			'A'=>array(
				'0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
				'5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
			'B'=>array(
				'0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
				'5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
			'C'=>array(
				'0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
				'5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
			);
		$parities=array(
			'0'=>array('A','A','A','A','A','A'),
			'1'=>array('A','A','B','A','B','B'),
			'2'=>array('A','A','B','B','A','B'),
			'3'=>array('A','A','B','B','B','A'),
			'4'=>array('A','B','A','A','B','B'),
			'5'=>array('A','B','B','A','A','B'),
			'6'=>array('A','B','B','B','A','A'),
			'7'=>array('A','B','A','B','A','B'),
			'8'=>array('A','B','A','B','B','A'),
			'9'=>array('A','B','B','A','B','A')
			);
		$code='101';
		$p=$parities[$barcode[0]];
		for($i=1;$i<=6;$i++)
			$code.=$codes[$p[$i-1]][$barcode[$i]];
		$code.='01010';
		for($i=7;$i<=12;$i++)
			$code.=$codes['C'][$barcode[$i]];
		$code.='101';
		//Draw bars
		for($i=0;$i<strlen($code);$i++)
		{
			if($code[$i]=='1')
				$this->Rect($x+$i*$w,$y,$w,$h,'F');
		}
		//Print text uder barcode
		$this->SetFont('Arial','',12);
		$this->Text($x,$y+$h+11/$this->k,substr($barcode,-$len));
	}	
	
	
	public function Header() {
		$this->SetFont('Arial','',14);
		$this->SetDrawColor(180,0,0); //Change the border color to red
		// Make a space
		$this->Cell(0,2,"",0,1);
		$this->Cell(27,18,"");
		$this->Cell(17,1,"Catholic Girls' Secondary School",0,1);
		// Title
		$this->SetFont('Arial','B',16);
		$this->SetTextColor(123,127,193);
		$this->Cell(27,15,"");
		$this->Cell(0,15,"MARY QUEEN OF ANGELS, AKURE",0,1,'L');
		// Arial italic 10
		$this->setfont('Arial','I',10);
		// Sub title
		$this->Cell(27,15,"");
		$this->SetTextColor(102,102,102);
		$this->Cell(15,0,"P.M.B 3441, Akure, Ondo State",0,1,'M');
		$this->Cell(20,7,"",0,1);
		$this->Cell(0,0.2,"","TB",1);
		$this->SetTextColor(0,0,0);
		$this->SetDrawColor(0,0,0); //Change the border color to red
		
		//WaterMark
		//$this->RotatedImage("../images/Logo2watermark.png",25,65,150,180,0,0,0,0);

		
	}
	
	
	public function RotatedText($x,$y,$txt,$angle){
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}

	public function RotatedImage($file,$x,$y,$w,$h,$angle){
		//Image rotated around its upper-left corner
		$this->Rotate($angle,$x,$y);
		$this->Image($file,$x,$y,$w,$h);
		$this->Rotate(0);
	}
	
	public function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetTextColor(0,0,0);
		$this->SetY(-25);
		$this->SetDrawColor(180,0,0); //Change the border color to red
		// Set font
		$this->SetFont('Arial',"B",'7');
		// Draw line with date printed
		$this->Ln(3);
		$this->Cell(60,5,"Powered By: Salesians Centre for ICT - Nigeria","TR");
		$date = date("d-m-".date('Y').", H:m:s");
		$this->Cell(130,5,"Date Printed: $date","B",1,"R");
		// Arial italic 8
		$this->SetFont('Arial','I',9);
		// Footer informations
		$this->Cell(100,10,date('Y')." (c) Mary Queen of Angels, Akure.",0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(90,10,"Page ".$this->PageNo(),0,0,"R");
	}
	
	public function header2($name1,$name2,$name3,$noIn_class,$class_arm,$examNo,$session,$term){
		$name1 = strtoupper($name1);
		$name2 = strtoupper($name2);
		$name3 = strtoupper($name3);
		$term = strtoupper($term);
		$this->SetY(40);
		$this->SetFont('helvetica','B',10);
		$this->Cell(95,2,"$name1 $name2 $name3",0,0);
		$this->Cell(95,2,"$class_arm",0,2,'L');
		$this->Ln(0);
		$this->SetFont('helvetica','',8);
		$this->Cell(95,10,"HOUSE: ST. FRANCIS",0,0);
		$this->Cell(95,10,"POSITION: ",0,0);
		$this->Ln(0);
		$this->Cell(95,17,"NO. IN CLASS: $noIn_class",0,0);
		$this->Cell(95,17,"EXAM NO: $examNo ",0,0);
		$this->Ln(0);
		$this->Cell(95,24,"NEXT TERM BEGINS: $noIn_class",0,0);
		$this->Cell(95,24,"NEXT TERM ENDS: $examNo ",0,0);
		$this->Ln(4);
		$this->SetFont('helvetica','B',10);
		$this->Cell(180,36,"$session $term ACADEMIC REPORT",0,0,"C");
	}
	
	private function setColorValue($value){
		if($value<=49){
			$this->SetTextColor(246,8,32);
		} else {
			$this->SetTextColor(8,246,32);
		}
	}
	
	public function mainResult($examNo,$stdID,$session,$term,$category){
		
		if($category == "Junior Students"){
			$categoryTbl = "junior_result";
		} else if($category == "Senior Students"){
			$categoryTbl = "senior_result";
		}
		//Gray color filling each Field Name box
		//Bold Font for Field Name
		$this->SetFillColor(179,230,217);
		$this->SetFont('Arial','B',7);
		$this->SetY(70);
		$this->SetX(6);
		$this->Cell(5,6,'S/N',1,0,"C",true);
		$this->Cell(60,6,'SUBJECT',1,0,"L",true);
		$this->Cell(10,6,"CA1",1,0,"C",true);
		$this->Cell(10,6,'CA2',1,0,"C",true);
		$this->Cell(10,6,'CA3',1,0,"C",true);
		$this->Cell(10,6,'AVG',1,0,"C",true);
		$this->Cell(10,6,'EXAM',1,0,"C",true);
		$this->Cell(10,6,'TOT',1,0,"C",true);
		$this->Cell(10,6,'CUMM',1,0,"C",true); 
		$this->Cell(10,6,'GRADE',1,0,"C",true);
		$this->Cell(15,6,'ClASS AVG',1,0,"C",true);
		$this->Cell(14,6,'SUB. POS.',1,0,"C",true);
		$this->Cell(22,6,'T.REMS',1,0,"C",true);
		$this->Ln(6);
		
		global $connection;
		$sql = "SELECT * FROM `$categoryTbl` WHERE `Exam_no` = '$examNo' AND `stdID` = '$stdID' AND `session` = '$session' AND `term` = '$term'";
		$sql_run = $connection->query($sql);
				
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
		
		$this->SetFont("helvetica","",8); // Change the font style
		$no = 0;
		
		$fetches = array();
		while($fetch = $connection->fetch_array($sql_run)){
			$fetches[] = $fetch;
		}
		foreach ($fetches as $fetch => $value){
			$no = $no+1;
			$this->SetX(6);
			$this->Cell(5,7,$no.".","LRB");
			$this->Cell(60,7,$value['subject'],"LRB");
			$this->Cell(10,7,$value[$db_1st],"LRB",0,"C");
			$this->Cell(10,7,$value[$db_2nd],"LRB",0,"C");
			$this->Cell(10,7,$value[$db_3rd],"LRB",0,"C");
			$this->Cell(10,7,round($value[$db_4th]),"LRB",0,"C");
			$this->Cell(10,7,$value[$db_5th],"LRB",0,"C");
			$this->Cell(10,7,round($value[$db_6th]),"LRB",0,"C");
			$this->Cell(10,7,round($value[$db_7th]),"LRB",0,"C");
			$this->Cell(10,7,$value[$db_8th],"LRB",0,"C");
			$this->Cell(15,7,round($value[$db_9th]),"LRB",0,"C");
			$this->Cell(14,7,$this->ordinal($value[$db_10th]),"LRB",0,"C");
			$this->Cell(22,7,$value[$db_11th],"LRB",0,"C");
			$this->Ln(7);
			if ($value <=49) $this->SetTextColor(255,0,0);
		}
				
	}
	
	private function BehaviouralTraits($examNo,$stdID,$session,$term,$field){
		global $connection;
		$sql = "SELECT * FROM `behaviouraltraits` WHERE `Exam_no` = '$examNo' AND `stdID` = '$stdID' AND `session` = '$session' AND `term` = '$term'";
		$sql_run = $connection->query($sql);
		$row = $connection->fetch_array($sql_run);
		return $row[$field];
	}
	
	private function CommentsRemarks($examNo,$stdID,$session,$term,$field){
		global $connection;
		$sql = "SELECT * FROM `commentremarks` WHERE `Exam_no` = '$examNo' AND `stdID` = '$stdID' AND `session` = '$session' AND `term` = '$term'";
		$sql_run = $connection->query($sql);
		$row = $connection->fetch_array($sql_run);
		return $row[$field];
	}
	
	private function SetKeyGrades($category){
		if($category == "Junior Students"){
			$this->Ln(6);
			$this->SetFont('helvetica','',8);
			$this->SetX(6);
			$this->Cell(200,6,"A:70% and Above, B:60%-69%, C:50%-59%, P:40%-49%, F:Below 40%",1,0);
		} else if($category == "Senior Students"){
			$this->Ln(6);
			$this->SetFont('helvetica','',8);
			$this->SetX(6);
			$this->Cell(200,6,"A1:75% and ABOVE, B2:70%-74%, B3:65%-69%, C4:60%-64%, C5:55%-59%, C6:50%-54%, D7:45%-49%, E8:40%-44%, F9:Below 39%",1,0);
		}
	}
	
	public function SecondResultPanel($category,$examNo,$stdID,$session,$term){
		global $resultMain;
		if($category == "Junior Students"){
			$categoryTbl = "junior_result";
		} else if($category == "Senior Students"){
			$categoryTbl = "senior_result";
		}
		$this->SetX(6);
		$this->SetFont('times','B',10);
		$this->Cell(5,7,"AVERAGE SCORE:".$resultMain->GetAverageScore($categoryTbl,$examNo,$stdID,$session,$term));
		$this->Ln(12);
		$this->SetX(6);
		$this->Cell(200,6,"BEHAVIOURAL TRAITS / PSYCHOMOTOR",1,0,"C",true);
		$this->Ln(6);
		$this->SetFont('helvetica','',8);
		$this->SetX(6);
		$this->Cell(90,5,"Neatness:","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'neatness'),"BR");
		$this->Cell(90,5,"Punctuality: ","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'punctuality'),"BR");
		$this->Ln(5);
		$this->SetX(6);
		$this->Cell(90,5,"Obidience:","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'obidience'),"BR");
		$this->Cell(90,5,"Relationship with students: ","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'relationship'),"BR");
		$this->Ln(5);
		$this->SetX(6);
		$this->Cell(90,5,"Reliability: ","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'realiability'),"BR");
		$this->Cell(90,5,"Atentiveness: ","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'attentiveness'),"BR");
		$this->Ln(5);
		$this->SetX(6);
		$this->Cell(90,5,"Initiative: ","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'initiative'),"BR");
		$this->Cell(90,5,"Self Control: ","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'initiative'),"BR");
		$this->Ln(5);
		$this->SetX(6);
		$this->Cell(90,5,"Responsibility: ","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'responsibility'),"BR");
		$this->Cell(90,5,"Cooperation: ","LB",0);
		$this->Cell(10,5,$this->BehaviouralTraits($examNo,$stdID,$session,$term,'cooperation'),"BR");
		
		// REMARKS AND COMMENTS AREA
		$this->SetY(193);
		$this->SetX(6);
		$this->SetFont('times','B',10);
		$this->Cell(200,6,"REMARKS / COMMENTS",1,0,"C",true);
		$this->Ln(6);
		$this->SetFont('helvetica','',8);
		$this->SetX(6);
		$this->Cell(100,5,"House Master/Mistress Remarks:","LBR",0);
		$this->Cell(100,5,$this->CommentsRemarks($examNo,$stdID,$session,$term,'HMcomments'),"LBR",0);
		$this->Ln(5);
		$this->SetX(6);
		$this->Cell(100,5,"Form Teacher's Remarks :","LBR",0);
		$this->Cell(100,5,$this->CommentsRemarks($examNo,$stdID,$session,$term,'FTcomments'),"LBR",0);
		$this->Ln(5);
		$this->SetX(6);
		$this->Cell(100,5,"Principal's Remarks:","LBR",0);
		$this->Cell(100,5,$this->CommentsRemarks($examNo,$stdID,$session,$term,'Pcomments'),"LBR",0);
		
		//KEY TO GRADES
		$this->SetY(220);
		$this->SetX(6);
		$this->SetFont('times','B',10);
		$this->Cell(200,6,"KEY TO GRADE",1,0,"C",true);
		$this->SetKeyGrades($category);
		
		//KEY TO BEHAVIUORAL TRAITS
		$this->SetY(235);
		$this->SetX(6);
		$this->SetFont('times','B',10);
		$this->Cell(200,6,"KEY TO BEHAVIOURAL TRAITS / PSYCHOMOTOR",1,0,"C",true);
		$this->Ln(6);
		$this->SetFont('helvetica','',8);
		$this->SetX(6);
		$this->Cell(200,6,"A - Exellent show of traits, B - High level exhibition of traits, C - Fair exhibition of traits, D - Minimal exhibition of traits, E - No regard for traits",1,0);
		
		//Signature Area
		$this->SetX(6);
		$this->Image("../images/signature.png",11,250,30,10);
		
		//BARCODE AREA
		$this->SetX(6);
		$this->setY(260);
		$this->SetFont('Arial','IUB',10);
		$this->Cell(30,6,"Princaipal's Signature",0,0);
		
		//Remove First 2 Letters From Exam No
		$this->SetFillColor(209,39,86);
		$this->SetTextColor(42,22,111);
		$examNoStr = $examNo;
		$examNoStr2 = substr($examNoStr,3);
		$this->EAN13(170,250,$examNoStr2,15);
		
		//NOTE
		$this->Ln(5);
		$this->SetX(6);
		$this->SetFont('Arial','IB',8);
		$this->SetTextColor(233,57,82);
		$this->Cell(30,6,"NOTE: CA1, CA2, CA3, AVG, EXAM, TOT, CUMM, CLASS AVG AND AVERAGE SCORE ARE CACULATED IN 100%",0,0);
		
	}
	
	private function ordinal($number) {
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if ((($number % 100) >= 11) && (($number%100) <= 13))
			return $number. 'th';
		else
			return $number. $ends[$number % 10];
	}
	
	
	public function mainResultBody($regNo,$sess,$term){		
		/* global $connection;
		$sql = "SELECT * FROM result_upload WHERE registrationNO='".$regNo."' AND session='".$sess."' AND term='".$term."'";
		$query = $connection->query($sql);
				
		$db_1st = "subject";
		$db_2nd = "ca1";
		$db_3rd = "ca2";
		$db_3rd = "test";
		$db_4th = "exam";
		$db_5th = "average";
		$db_6th = "position";
		
		$this->SetFont("helvetica","",8); // Change the font style
		$no = 0;
		
		$fetches = array();
		while($fetch = $connection->fetch_array($query)){
			$fetches[] = $fetch;
		}
		foreach ($fetches as $fetch => $value){
			$no = $no+1;
			$this->SetY(73);
			$this->Cell(50,20,$value['subject'],1,0,"L");
			$this->Cell(14,20,"",1,0,"C");
			$this->Cell(14,20,"",1,0,"C");
			$this->Cell(14,20,"",1,0,"C");
			$this->Cell(14,20,"",1,0,"C");
			$this->Cell(14,20,"",1,0,"C");
			$this->Cell(14,20,"",1,0,"L");
			$this->Cell(14,20,"",1,0,"C");
			$this->Cell(14,20,"",1,0,"C");
			$this->Cell(14,20,"",1,0,"C");
			$this->Cell(16,20,"",1,0,"C");
		} */
		
		$this->Cell(16,20,$regNo,1,0,"C");
				
	}
	
}
$slip = new Result();
?>