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

define(GIT_MODIFIED, " --modified");
define(GIT_STAGED, " --cached");
define(GIT_DELETED, " --deleted --killed");
define(GIT_ADDED, " --others");
define(GIT_ALL, GIT_MODIFIED . GIT_ADDED . GIT_DELETED);

$db = connect_db();
$html = $_SESSION['html'];

function connect_db()
{
	global $config;
	
	$db = new sql_db($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], false);
	
	return $db;
}

function build_template( $view_file, $page_title = NULL, $simple = FALSE, $kill = FALSE )
{
	global $html;

	if( is_array($html) )
	{
		foreach( $html as $var => $val )
		{
			$$var = $val;
		}
	}
	
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

function session_store($key, $value, $overwrite = true)
{
	global $_SESSION;
	
	if( $overwrite )
	{
		$_SESSION[$key] = $value;
	}
	else
	{
		if( is_array($_SESSION[$key]) )
		{
			if( is_array($value) )
			{
				foreach( $value as $subkey => $val )
				{
					$_SESSION[$key][$subkey] = $val;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	return true;			
}

function session_get($key)
{
	global $_SESSION;
	
	return ( isset($_SESSION[$key]) ) ? $_SESSION[$key] : FALSE;
}

function truncate($input, $max = 25, $separator = "...")
{
	$strlength = strlen($input);
	
	if( $strlength >= $max )
	{
		$separatorlength = strlen($separator) ;
		$maxlength = $max - $separatorlength;
		$start = $maxlength / 2 ;
		$trunc =  $strlength - $maxlength;
		
		return substr_replace($input, $separator, $start, $trunc);
	}

	return $input;
}

function getUserSites( $user_id )
{
	global $db;
	
	$sql = "SELECT * FROM `sites` WHERE `owner` = $user_id";
	$results = $db->sql_fetchrowset($db->sql_query($sql));
	
	return $results;
}

function getSite( $site_id )
{
	global $db;
	
	$sql = "SELECT * FROM `sites` WHERE `site_id` = $site_id";
	$result = $db->sql_fetchrow($db->sql_query($sql));
	
	return $result;
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
