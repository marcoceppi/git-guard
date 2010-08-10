<?php

require_once("lib/common.php");

$mode = $_GET['mode'];
$action = $_GET['action'];

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
