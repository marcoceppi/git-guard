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

$sites = getSites($user['user_id']);
$html['sites_dropdown'] = new Dropdown("site_select");

foreach( $sites as $site )
{
	$html['sites_dropdown']->add($site['name'], $site['site_id']);
}

switch( $action )
{
	case 'switch':
		
	default:
		
		build_template("views/dashboard.tpl", "Dashboard");
	break;
}
