<?php

require_once("lib/common.php");

$mode = ( !isset($_REQUEST['mode']) ) ? "dashboard" : $_REQUEST['mode'];
$action = ( isset($_REQUEST['action']) ) ? $_REQUEST['action'] : NULL;

if( !is_null($mode) )
{
	if( is_file("$mode.php") )
	{
		require_once("$mode.php");
	}
	else
	{
		header("Location: index.php");
	}
}
else
{
	echo "This is the default page";
}

?>
