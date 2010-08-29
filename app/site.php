<?php

$submit = ( isset($_REQUEST['submit']) ) ? true : false;

switch( $action )
{
	case 'new':
		if( $submit )
		{
			$site_path = mysql_real_escape_string($_POST['site_path']);
			$site_name = mysql_real_escape_string($_POST['site_name']);
			
			if( is_writable($site_path) && !empty($site_path) )
			{
				if( !empty($site_name) )
				{
					$sql_check = "SELECT `id` FROM `sites` WHERE `path`='$site_path'";
					$db->sql_query($sql_check);
					
					$html['site_path'] = $site_path;
					$html['site_name'] = $site_name;
					
					if( $db->sql_numrows() > 0 )
					{
						$html['error'] = "A site with that path already exists.";
					}
					else
					{
						if( git_init($site_path) )
						{
							$sql = "INSERT INTO `sites` (`owner`, `name`, `path`) VALUES (" . $user['user_id'] . ", '" . addslashes($site_name) . "', '$site_path')";
							if( $db->sql_query($sql) )
							{
								$q = $db->sql_query("SELECT `site_id` FROM `sites` WHERE `path` = '$site_path'");
								$site_id = array_shift($db->sql_fetchrow($q));
								if( $site_id > 0 )
								{
									$sql = "INSERT INTO `users_sites` (`site_id`, `user_id`) VALUES ($site_id, " . $user['user_id'] . ")";
									if( $db->sql_query($sql) )
									{
										session_store('html', array('success' => "Successfully added $site_name"));
										header("Location: index.php");
									}
									else
									{
										$html['error'] = "Failed to attach you to your site!";
									}
								}
								else
								{
									$html['error'] = "Could not insert your site into our database!";
								}
							}
							else
							{
								$html['error'] = "Could not insert your site into our database!";
							}
						}
						else
						{
							$html['error'] = "Unable to instanciate a Git Repository at this path.";
						}
					}
					
					build_template("site_new", "Add new site", FALSE, TRUE);
				}
			}
		}
		else
		{
			build_template("site_new", "Add new site");
		}
	break;
	case 'add':
		
	break;
	case 'check_path':
		$path = $_REQUEST['path'];
		
		if( is_dir($path) )
		{
			if( is_writable($path) )
			{
				echo "<p class=\"small simple green\" style=\"display:inline;\">Ok!</p>";
			}
			else
			{
				echo "<p class=\"small simple red\" style=\"display:inline;\">Unwritable</p>";
			}
		}
		else
		{
			echo "<p class=\"small simple red\" style=\"display:inline;\">Invalid</p>";
		}
	break;
	default:
		echo "peekaboo";
	break;
}
?>
