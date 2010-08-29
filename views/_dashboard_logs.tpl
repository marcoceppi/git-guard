<?php

foreach($logs as $log)
{
	list($commit, $message) = explode(" ", $log, 2);
	?>
	<p class="simple small"><input type="checkbox" name="log" id="log"> <?= truncate($message, 50); ?></p>
	<?php
}
?>
<span class="small">
<?php
if( $logs_start > 0 )
{
	$new_start = ( ($logs_start - 15) <= 0 ) ? 0 : ($logs_start - 15);
	?>
	<span class="smlink" onclick="update_logs(<?= $new_start; ?>)">Newer</span>
	<?php
}

if( $logs_more )
{
	?>
	<span class="smlink" onclick="update_logs(<?= $logs_start + 15; ?>)">Older</span>
	<?php
}
?>
</span>
