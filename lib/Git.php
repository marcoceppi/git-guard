<?php

define(GIT_MODIFIED, " --modified");
define(GIT_STAGED, " --cached");
define(GIT_DELETED, " --deleted --killed");
define(GIT_ADDED, " --others");
define(GIT_ALL, GIT_MODIFIED . GIT_ADDED . GIT_DELETED);

function git_init( $path )
{
	global $config;
	
	if( is_writable($path) )
	{
		exec("cd $path; " . $config['server']['git'] . " init");
		
		return ( is_dir($path . "/.git") ) ? true : false;
	}
	
	return false;
}		

function git_files( $path, $modes = NULL, $files = NULL )
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
	
	if( !is_null($files) )
	{
		if( is_array($files) )
		{
			$files = implode(" ", $files);
		}
	}
	else
	{
		$files = "";
	}
	
	exec("cd $path && " . $config['server']['git'] . " ls-files -t " . $mode . " " . $files, $list);
	
	return ( is_array($list) ) ? $list : FALSE;
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
	
	$file_list = git_files($path, GIT_ALL, $files);
	
	if( is_array($file_list) )
	{
		foreach( $file_list as $file_info )
		{
			list($key, $file_path) = explode(" ", $file_info, 2);
			
			$state = git_state($key);
			
			switch( $state )
			{
				case 'deleted':
					exec("cd $path && " . $config['server']['git'] . " rm $file_path");
				break;
				default:
					exec("cd $path && " . $config['server']['git'] . " add $file_path");
				break;
			}
		}
	}
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
	
	exec("cd $path;HOME=/home/4218/users/.home/ " . $config['server']['git'] . " checkout -- $files");
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

function git_state($key)
{
	switch( $key )
	{
		case '?':
		case 'N':
			$state = "new";
		break;
		case 'M':
		case 'C':
			$state = "modified";
		break;
		case 'D':
		case 'R':
			$state = "deleted";
		break;
		default:
			$state = "unknown";
		break;
	}
	
	return $state;
}
