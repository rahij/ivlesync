<?php
session_start();
if(!isset($_SESSION['lessons_counter']))
	$_SESSION['lessons_counter']=0;

$_SESSION['modules'][$_SESSION['lessons_counter']]['module_code']=$_GET['code'];
$_SESSION['modules'][$_SESSION['lessons_counter']]['ltype']=$_GET['ltype'];
$_SESSION['modules'][$_SESSION['lessons_counter']]['venue']=$_GET['venue'];
$_SESSION['modules'][$_SESSION['lessons_counter']]['day_text']=$_GET['day'];
$_SESSION['modules'][$_SESSION['lessons_counter']]['startTime']=$_GET['startTime'];
$_SESSION['modules'][$_SESSION['lessons_counter']]['endTime']=$_GET['endTime'];
++$_SESSION['lessons_counter'];
?>