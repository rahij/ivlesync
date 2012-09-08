<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'google-api-php-client-read-only/src/apiClient.php';
require_once 'google-api-php-client-read-only/src/contrib/apiCalendarService.php';
$service = new CalendarService();
$calendarList = $service->calendarList->listCalendarList();

while(true) {
  foreach ($calendarList->getItems() as $calendarListEntry) {
    echo $calendarListEntry->getSummary();
  }
  $pageToken = $calendarList->getNextPageToken();
  if ($pageToken) {
    $optParams = array('pageToken' => $pageToken);
    $calendarList = $service->calendarList->listCalendarList($optParams);
  } else {
    break;
  }
}
?>