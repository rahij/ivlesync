<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once "google-api-php-client-read-only/src/apiClient.php";
require_once "google-api-php-client-read-only/src/contrib/apiCalendarService.php";


foreach ($_GET as $param)
{
	$index=(array_keys($_GET,$param, true));
	$details[$index[0]]=$param;
}

echo "<pre>";print_r($details);echo "</pre>";


?>