<?php
foreach($files as $file)
{
	list($key, $path) = explode(" ", $file, 2);
	
	$state = git_state($key);
	
	switch( $state )
	{
		case 'new':
			$class = "green";
		break;
		case 'modified':
			$class = "orange";
			
			if( in_array($path, $del) )
			{
				continue 2;
			}
		break;
		case 'deleted':
			$class = "red";
			
			$del[] = $path;
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
