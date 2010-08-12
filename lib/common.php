<?php

// Just a little smoke and mirrors.
ini_set('include_path', dirname(dirname(__FILE__)) . PATH_SEPARATOR . ini_get('include_path'));

require_once("Auth/OpenID/Consumer.php");
require_once("Auth/OpenID/FileStore.php");
require_once("Auth/OpenID/SReg.php");
require_once("Auth/OpenID/PAPE.php");
require_once("Database.php");
require_once("HTML.php");
include_once("inc/site.conf.inc");

$db = connect_db();

function connect_db()
{
	global $config;
	
	$db = new sql_db($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], false);
	
	return $db;
}

function build_template( $view_file, $page_title = NULL, $simple = FALSE, $kill = FALSE )
{
	global $error, $msg, $success;

	require_once("lib/template.php");
	
	if( $kill )
	{
		die();
	}
}

function is_simple()
{
	global $_REQUEST;
	
	return ( isset($_REQUEST['simple']) && $_REQUEST['simple'] == true ) ? true : false;
}

function session_store($key, $value)
{
	global $_SESSION;
	
	$_SESSION[$key] = $value;
}

function getSites( $user_id )
{
	global $db;
	
	$sql = "SELECT * FROM `sites` WHERE `owner` = $user_id";
	$results = $db->sql_fetchrowset($db->sql_query($sql));
	
	return $results;
}

function getWebRoot( $echo = false )
{
	if( $echo )
	{
		echo str_replace("index.php", "", $_SERVER['PHP_SELF']);
	}
	else
	{
		return str_replace("index.php", "", $_SERVER['PHP_SELF']);
	}
}

function &getStore()
{
	global $config;

	$store_path = $config['server']['tmp'] . "_php_consumer";

	if( !file_exists($store_path) && !mkdir($store_path) )
	{
		print "Could not create the FileStore directory '$store_path'. Please check the effective permissions.";
		exit(0);
	}
	
	$r = new Auth_OpenID_FileStore($store_path);

	return $r;
}

function &getConsumer()
{
	$store = getStore();
	$r = new Auth_OpenID_Consumer($store);
	
	return $r;
}

function getReturnTo()
{
	global $config;

	return $config['web']['url'] . $config['web']['path'] . "index.php?mode=login&action=finish";
}

function getTrustRoot()
{
	global $config;
	
	return $config['web']['url'];
}

function getOpenIDURL()
{
	return ( !empty($_REQUEST['openid_identifier']) ) ? $_REQUEST['openid_identifier'] : FALSE;
}

function escape($thing)
{
	return htmlentities($thing);
}

?>
