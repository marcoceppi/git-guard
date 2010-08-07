<?php

// This needs to come from the db - whenever that gets implemented
$guardians = array();
$guardians[] = "/home/marco/guardme";

function get_code( $key )
{
	switch( $key )
	{
		case "C":
			return "MODIFIED";
		break;
		case "?":
			return "NEW";
		break;
		case "D":
			return "DELETED";
		break;
		default:
			return "UNKNOWN";
		break;
	}
}

foreach( $guardians as $check_path )
{
	exec("cd $check_path && git ls-files --modified --others --deleted -t", $results);

	if( is_array($results) )
	{
		foreach( $results as $status )
		{
			list($msg, $file) = explode(" ", $status, 2);
			echo get_code($msg) . " - $check_path/$file\n";
		}
	}
}

?>
