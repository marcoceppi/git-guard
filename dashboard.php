<?php

$sites = getUserSites($user['user_id']);
$site = session_get('site');

$html['sites_dropdown'] = new Dropdown("site_select");

foreach( $sites as $avail_site )
{
	$html['sites_dropdown']->add($avail_site['name'], $avail_site['site_id']);
}

switch( $action )
{
	case 'files':
		$type = $_REQUEST['type'];
		$container = ( isset($_REQUEST['container']) ) ? $_REQUEST['container'] : "files";
		
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
			case 'staged':
				$file_mode = GIT_STAGED;
				$html['staged'] = git_cached($site['path']);
			break;
			default:
				$file_mode = GIT_ALL;
			break;
		}
		
		$html['files'] = git_files($site['path'], $file_mode);
		build_template("_dashboard_$container", NULL, TRUE);
	break;
	case 'execute':
		$command = $_REQUEST['cmd'];
		$files = explode(",", $_REQUEST['file_list']);
		
		switch( $command )
		{
			case 'commitall':
				function _cleanFiles(&$path, $key)
				{
					list($meh, $path) = explode("\t", $path, 2);
				}
				
				$files = git_cached($site['path']);
				array_walk($files, '_cleanFiles');

				git_commit($site['path'], $files, date('Y/m/d-G:i') . " Approved by: " . $user['name']);
			break;
			case 'commit':
				git_commit($site['path'], $files, date('Y/m/d-G:i') . " Approved by: " . $user['name']);
			break;
			case 'stage':
				git_stage($site['path'], $files);
			break;
			case 'diff':
				git_diff($site['path'], $files);
			break;
			case 'checkout':
				git_checkout($site['path'], $files);
			break;
			default:
			break;
		}
	break;
	case 'log':
		$start = ( is_numeric($_REQUEST['start']) ) ? $_REQUEST['start'] : 0;
		
		$html['logs'] = array_slice(git_log($site['path']), $start, 15);
		build_template("_dashboard_logs", NULL, TRUE);
	break;
	case 'switch':
		$site_id = $_REQUEST['site_select'];
		$site = getSite($site_id);
		session_store('site', $site);
	default:
		if( $site !== FALSE )
		{
			$html['site'] = $site;
			$html['files'] = git_files($site['path'], GIT_ALL);
			$html['logs'] = array_slice(git_log($site['path']), 0, 15);
			$html['log_start'] = 0;
			$html['staged'] = git_cached($site['path']);
		}
		
		build_template("dashboard", "Dashboard");
	break;
}
