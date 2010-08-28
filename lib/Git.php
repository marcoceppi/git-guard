<?php

define(GIT_MODIFIED, " --modified");
define(GIT_STAGED, " --cached");
define(GIT_DELETED, " --deleted --killed");
define(GIT_ADDED, " --others");
define(GIT_ALL, GIT_MODIFIED . GIT_ADDED . GIT_DELETED);

function git_files( $path, $modes = NULL )
{
	global $config;
	
	if( !is_null($modes) )
	{
		if( is_array($modes) )
		{
			$mode = implode("", $modes);
		}
		else
		{
			$mode = $modes;
		}
	}
	else
	{
		$mode = "";
	}
	
	exec("cd $path && " . $config['server']['git'] . " ls-files -t " . $mode, $files);
	
	return ( is_array($files) ) ? $files : FALSE;
}

function git_cached( $path )
{
	global $config;
	
	exec("cd $path && " . $config['server']['git'] . " diff --cached --name-status " . $mode, $files);
	
	return $files;
}

function git_log( $path )
{
	global $config;
	
	exec("cd $path && " . $config['server']['git'] . " log --abbrev-commit --pretty=oneline", $log);
	
	return ( is_array($log) ) ? $log : FALSE;
}

function git_stage( $path, $files )
{
	global $config;
	
	if( is_array($files) )
	{
		$files = implode(" ", $files);
	}
	
	exec("cd $path && " . $config['server']['git'] . " add $files");
}

function git_commit( $path, $files, $message )
{
	global $config;
	
	if( is_array($files) )
	{
		$files = implode(" ", $files);
	}
	
	git_stage( $path, $files );
	
	exec('cd ' . $path . ';HOME=/home/4218/users/.home/ ' . $config['server']['git'] . ' commit -m "' . $message . '" --author="Git Guardian <guardian@seacrow.org>" -- ' . $files);
}

function git_checkout( $path, $files )
{
	global $config;
	
	if( is_array($files) )
	{
		$files = implode(" ", $files);
	}
	
	exec("cd $path && " . $config['server']['git'] . " checkout -- $files");
}

function git_diff( $path, $files )
{
	global $config;
	
	if( is_array($files) )
	{
		$files = implode(" ", $files);
	}
	
	exec("cd $path && " . $config['server']['git'] . " diff -- $files", $output);
	
	return $output;
}
