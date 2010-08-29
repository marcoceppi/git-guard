<?php

session_start();

require_once("lib/common.php");

$mode = ( !isset($_REQUEST['mode']) ) ? "dashboard" : $_REQUEST['mode'];
$action = ( isset($_REQUEST['action']) ) ? $_REQUEST['action'] : NULL;
$html = session_get('html');
session_store('html', array());

if( !isset($_SESSION['user']) && $mode != "login" )
{
	$mode = "login";
}
else
{
	$user = $_SESSION['user'];
}

if( !is_null($mode) )
{
	if( is_file("app/$mode.php") )
	{
		$html['mode'] = $mode;
		$html['action'] = $mode;
		$html['config'] = $config;
		
		require_once("app/$mode.php");
	}
	else
	{
		header("Location: index.php");
	}
}

?>
