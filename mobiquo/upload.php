<?php

error_reporting(E_ALL & ~E_NOTICE);
if(isset($_GET['checkAccess']))
{
    echo "yes";
	exit;
}
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	showTestScreen();
}
include './mobiquo.php';

function showTestScreen()
{
	echo "Attachment Upload Interface for Tapatalk Application<br>";
	echo "<br>
For more details, please visit <a href=\"https://www.tapatalk.com\" target=\"_blank\">https://www.tapatalk.com</a>";
	exit;
}