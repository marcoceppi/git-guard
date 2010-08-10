<?php

$path_extra = dirname(dirname(dirname(__FILE__)));
$path = ini_get('include_path');
$path = $path_extra . PATH_SEPARATOR . $path;
ini_set('include_path', $path);

require_once("Auth/OpenID/Consumer.php");
require_once("Auth/OpenID/FileStore.php");
require_once("Auth/OpenID/SReg.php");
require_once("Auth/OpenID/PAPE.php");
require_once("Database.php");

$db = new sql_db("localhost", "root", "!adasara0", "virtual_review", false);

function getWebRoot( $echo = false )
{
	if( $echo )
	{
		echo str_replace("route.php", "", $_SERVER['PHP_SELF']);
	}
	else
	{
		return str_replace("route.php", "", $_SERVER['PHP_SELF']);
	}
}

function &getStore()
{
	/**
	 * This is where the example will store its OpenID information.
	 * You should change this path if you want the example store to be
	 * created elsewhere.  After you're done playing with the example
	 * script, you'll have to remove this directory manually.
	 */
	$store_path = "/tmp/_php_consumer_test";

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
	/**
	 * Create a consumer object using the store object created
	 * earlier.
	 */
	$store = getStore();
	$r = new Auth_OpenID_Consumer($store);
	
	return $r;
}

function getScheme()
{
	$scheme = 'http';
	
	if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
	{
		$scheme .= 's';
	}
	
	return $scheme;
}

function getReturnTo()
{
	/*return sprintf(
		"%s://%s:%s%s/finish_auth.php",
		getScheme(),
		$_SERVER['SERVER_NAME'],
		$_SERVER['SERVER_PORT'],
		dirname($_SERVER['PHP_SELF'])
	);*/
	//return getScheme() . "://" . $_SERVER['SERVER_NAME'] . getWebRoot() . "index.php?mode=login&action=finish";
	return "http://localhost/git-guard/index.php?mode=login&action=finish";
}

function getTrustRoot()
{
	/*return sprintf(
		"%s://%s/%s",
		getScheme(), $_SERVER['SERVER_NAME'],
		//$_SERVER['SERVER_PORT'],
		str_replace("/", "", getWebRoot())
	);*/
	return "http://localhost/";
}

function getOpenIDURL()
{
	// Render a default page if we got a submission without an openid
	// value.
	if( empty($_GET['openid_identifier']) )
	{
		$error = "Expected an OpenID URL.";
		include 'index.php';
		exit(0);
	}
	
	return ( !empty($_GET['openid_identifier']) ) ? $_GET['openid_identifier'] : FALSE;
}

function escape($thing)
{
	return htmlentities($thing);
}

?>
