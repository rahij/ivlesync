<?php
include 'constants.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'apiClient.php';
require_once 'apiCalendarService.php';

session_start();
 
$client = new apiClient();
$client->setApplicationName("NUS Timetable Sync");
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri('http://localhost/ivle/test.php');
$client->setDeveloperKey($developerKey);


$apiClient = new apiClient();


$cal = new apiCalendarService($client);
if (isset($_SESSION['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  foreach($_SESSION['modules'] as $module)
  {
  	$event = new Event();
		$event->setSummary($module['module_code']." ".$module['ltype']);
		$event->setLocation($module['venue']);
		$start = new EventDateTime();
		
		$start_date_reference=array("Monday"=> 13,"Tuesday"=>14,"Wednesday"=>15,"Thursday"=>16,"Friday"=>17,"Saturday"=>18,"Sunday"=>19);
		$start_string='2012-08-'.$start_date_reference[$module['day_text']].'T'.$module['startTime'][0].$module['startTime'][1].':'.$module['startTime'][2].$module['startTime'][3].':00.000+08:00';
		
		$start->setDateTime($start_string);
		
		$start->setTimeZone('Asia/Singapore');
		$event->setStart($start);
		
		$end = new EventDateTime();
		$end_string='2012-08-'.$start_date_reference[$module['day_text']].'T'.$module['endTime'][0].$module['endTime'][1].':'.$module['endTime'][2].$module['endTime'][3].':00.000+08:00';
		$end->setDateTime($end_string);
		$end->setTimeZone('Asia/Singapore');
		$event->setEnd($end);
		$event->setRecurrence(array('RRULE:FREQ=WEEKLY;UNTIL=20121117T000000Z;'));
		$createdEvent = $cal->events->insert('primary', $event);
	}
unset($_SESSION['module']);
unset($_SESSION['lessons_counter']);
$_SESSION['token'] = $client->getAccessToken();
} 

else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Login</a>";
}















?>