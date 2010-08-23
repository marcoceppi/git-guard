<?php

require_once("lib/common.php");

$sql = "SELECT s.name, s.path, u.name as username, u.email FROM `sites` as s LEFT JOIN `users` as u on s.owner = u.user_id WHERE `site_id` > 0";
$users = $db->sql_fetchrowset($db->sql_query($sql));

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
echo "<pre>";
foreach( $users as $user )
{
	$results = git_files($user['path'], GIT_ALL);

	if( is_array($results) )
	{
		foreach( $results as $status )
		{
			list($msg, $file) = explode(" ", $status, 2);
			echo $user['name'] . " " . get_code($msg) . " - $check_path/$file\n";
			
		}
	}
}
echo "</pre>";
?>
