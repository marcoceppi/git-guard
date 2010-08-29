<?php
foreach($files as $file)
{
	list($state, $path) = explode(" ", $file, 2);
	switch( $state )
	{
		case '?':
			$class = "green";
		break;
		case 'C':
			$class = "orange";
		break;
		case 'D':
		case 'R':
			$class = "red";
		break;
		default:
			$class = "";
		break;
	}
	
	?>
<p class="simple <?= $class; ?>"><input type="checkbox" id="git-files[]" name="git-files[]" value="<?= $path; ?>"> <?= truncate($path, 45); ?></p> 
	<?php
}
?>
