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
	case 'files':
		$site = session_get('site');
		$type = $_REQUEST['type'];
		
		switch( $type )
		{
			case 'del':
				$file_mode = GIT_DELETED;
			break;
			case 'new':
				$file_mode = GIT_ADDED;
			break;
			case 'mod':
				$file_mode = GIT_MODIFIED;
			break;
			default:
				$file_mode = GIT_ALL;
			break;
		}
		
		$html['files'] = git_files($site['path'], $file_mode);
		build_template("_list_files", NULL, TRUE);
	break;
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
