<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../../src/apiClient.php';
require_once '../../src/contrib/apiCalendarService.php';

session_start();

$client = new apiClient();
$client->setApplicationName("Google Calendar Application");
// Visit https://code.google.com/apis/console to generate your
//oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
$client->setClientId('253590999479.apps.googleusercontent.com');
$client->setClientSecret('CVS5ZM83ji-d3a5fCMzMEBSP');
$client->setRedirectUri('http://localhost/ivle/google-api-php-client-read-only/examples/plus/test.php');
$client->setDeveloperKey('AIzaSyDtRxIUq_D8Pp0usWQ9rzqZvKEYy02ubnY');


$apiClient = new apiClient();


$cal = new apiCalendarService($client);
if (isset($_GET['logout'])) {
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
  $event = new Event();
$event->setSummary('Appointment');
$event->setLocation('Somewhere');
$start = new EventDateTime();
$start->setDateTime('2012-05-03T10:00:00.000-07:00');
$event->setStart($start);
$end = new EventDateTime();
$end->setDateTime('2012-05-03T10:25:00.000-07:00');
$event->setEnd($end);

$createdEvent = $cal->events->insert('primary', $event);
echo "Event Created";

$_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Login</a>";
}















?>