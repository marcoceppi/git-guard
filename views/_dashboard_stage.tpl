<?php
foreach($staged as $file)
{
	list($state, $path) = explode(" ", $file, 2);
	
	?>
<p class="simple content"><input type="checkbox" id="git-files" name="git-files"> <?= truncate($path, 50); ?></p> 
	<?php
}
?>
