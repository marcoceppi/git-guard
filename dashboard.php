<?php

session_start();

/*
if( !isset($_SESSION['user']) )
{
	require_once("login.php");
}
else
{
	$user = $_SESSION['user'];
}

print_r($user);
*/

$sites = getUserSites($user['user_id']);
$html['sites_dropdown'] = new Dropdown("site_select");

foreach( $sites as $site )
{
	$html['sites_dropdown']->add($site['name'], $site['site_id']);
}

switch( $action )
{
	case 'switch':
		$site_id = $_REQUEST['site_select'];
		$site = getSite($site_id);
		session_store('site', $site);
	default:
		if( $site = session_get('site') )
		{
			$html['site'] = $site;
			$html['files'] = git_files($site['path'], GIT_ALL);
		}
		
		build_template("dashboard", "Dashboard");
	break;
}
