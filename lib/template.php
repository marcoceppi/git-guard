<?php

if( !is_simple() && !$is_simple )
{
	?>
<html>
<head>
<title>Git Guardian<?php echo (!is_null($page_title)) ? " - " . $page_title : ""; ?></title>
<link rel="stylesheet" type="text/css" href="assets/main.css">
<?php if( is_file($config['server']['path'] . "views/_$mode.js.tpl") )  { include($config['server']['path'] . "views/_$mode.js.tpl"); } ?>
<?php if( is_file($config['server']['path'] . "views/_$mode.css.tpl") ) { include($config['server']['path'] . "views/_$mode.css.tpl"); } ?>
</head>
<body>
<div id="loader" style="display:none;position:absolute;width:1px;height:1px;background-color:#000000;opacity:0.50;"><div id="loader-img" style="position:relative;margin:auto;padding:auto;top:50%;margin-top:-10px;"><img src="assets/loader.gif"></div></div>
<div id="user_nav" class="small" style="width:800px;text-align:right;top:0;margin-top:0;">
<?php
if( isset($_SESSION['user']) )
{
	?>
	<a href="index.php?mode=site&action=new" alt="Add new site" title="Add new site"><img src="assets/shield_add.png" alt="Add new site" title="Add new site"></a> | 
	<?php
	if( $site['owner'] == $user['user_id'] )
	{
		?>
		<a href="index.php?mode=logout" alt="Manage Users" title="Manage Users"><img src="assets/vcard.png" alt="Manage Users" title="Manage Users"></a> | 
		<?php
	}
	?>
	<a href="index.php?mode=logout" alt="Logout" title="Logout"><img src="assets/user_go.png" alt="Logout" title="Logout"></a>
	<?php
}
?>
</div>
<div id="head"></div>
<div id="container">
	<div id="main">
		<?php if( isset($msg) )     { print "<div class=\"alert\">$msg</div>"; } ?>
		<?php if( isset($error) )   { print "<div class=\"error\">$error</div>"; } ?>
		<?php if( isset($success) ) { print "<div class=\"success\">$success</div>"; } ?>
		<p></p>
		<?php include($view_file); ?>
	</div>
</div>
</body>
</html>
	<?php
}
else
{
	?>
		<?php if( isset($msg) )     { print "<div class=\"alert\">$msg</div>"; } ?>
		<?php if( isset($error) )   { print "<div class=\"error\">$error</div>"; } ?>
		<?php if( isset($success) ) { print "<div class=\"success\">$success</div>"; } ?>
		<?php include($view_file); ?>
	<?php
}
?>
