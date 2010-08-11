<?php

session_start();

if( !isset($_SESSION['user']) )
{
	require_once("login.php");
}
else
{
	$user = $_SESSION['user'];
}

print_r($user);

$simple = $_REQUEST['simple'];

switch( $action )
{
	default:
		
	break;
}
