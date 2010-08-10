<?php

session_start();

if( !isset($_SESSION['user_id']) )
{
	require_once("login.php");
}

$simple = $_REQUEST['simple'];

switch( $action )
{
	default:
		
