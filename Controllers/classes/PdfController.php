<?php 
require_once('../../fpdf/fpdf.php');
require_once('../Controllers/classes/db_class.php');
require_once('../Controllers/classes/main_class.php'); 
require_once('../Controllers/classes/result_class.php');

$result = new Result; 

$class  = $mainClass->clean(@$_GET['class']);
$class_arm = $mainClass->pregGetNL(@$_GET['class_arm']);
$stdID = $mainClass->pregGetNL(@$_GET['stdID']);
$examNo = $mainClass->pregGetNL(@$_GET['examNo']);
$category = $mainClass->clean(@$_GET['category']);
$session = $mainClass->clean(@$_GET['session']);
$term = $mainClass->clean(@$_GET['term']);

$mainClass->URLCheck('class_name','class','class_name',$class,'404_2.php');
$mainClass->URLCheck('arm','class','arm',$class_arm,'404_2.php');
$mainClass->URLCheck('stdID','students','stdID',$stdID,'404_2.php');
$mainClass->URLCheck('Exam_no','students','Exam_no',$examNo,'404_2.php');
$mainClass->URLCheck('category','students','category',$category,'404_2.php');
$mainClass->URLCheck('session','session_term','session',$session,'404_2.php');
$mainClass->URLCheck('term','session_term','term',$term,'404_2.php');

$name1 = $mainClass->getwith('students','stdID',$stdID,'Surname');
$name2 = $mainClass->getwith('students','stdID',$stdID,'fname');
$name3 = $mainClass->getwith('students','stdID',$stdID,'oname');

//No in class
$noIn_class = $mainClass->countrowsWhere('students','class_arm',$class_arm);


$result->AddPage();
$result->SetFont('Arial','B',13);

$result->SetTitle($name1." ".$name2."'s (".$term."/".$session.") Result");

$result->header2($name1,$name2,$name3,$noIn_class,$class_arm,$examNo,$session,$term);

$result->mainResult($examNo,$stdID,$session,$term,$category);
	
$result->SecondResultPanel($category,$examNo,$stdID,$session,$term);

$result->Output();

?>