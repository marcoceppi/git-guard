<?php

if( !is_simple() && !$simple )
{
	?>
<html>
<head>
<title>Git Guardian<?php echo (!is_null($page_title)) ? " : " . $page_title : ""; ?></title>
<link rel="stylesheet" type="text/css" href="<?php getWebRoot(true); ?>assets/css/main.css">
</head>
<body>
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
		<p></p>
		<?php include($view_file); ?>
	<?php
}
?>
