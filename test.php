<?php
include 'constants.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'apiClient.php';
require_once 'apiCalendarService.php';

session_start();
echo "<pre>";print_r($_SESSION);echo "</pre>";exit; 
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
echo "<pre>";print_r($_SESSION);echo "</pre>"; 
if ($client->getAccessToken()) {
  foreach($_SESSION['modules'] as $module)
  {
  	$event = new Event();
		$event->setSummary($module['module_code']." ".$module['ltype']);
		$event->setLocation($module['venue']);
		$start = new EventDateTime();
		$start->setDateTime('2012-05-03T10:00:00.000+08:00');
		$start->setTimeZone('Asia/Singapore');
		$event->setStart($start);
		$end = new EventDateTime();
		$end->setDateTime('2012-05-03T10:25:00.000+08:00');
		$end->setTimeZone('Asia/Singapore');
		$event->setEnd($end);
		$event->setRecurrence(array('RRULE:FREQ=WEEKLY;UNTIL=20120525T000000Z;'));
		$createdEvent = $cal->events->insert('primary', $event);
		echo "Event Created";
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