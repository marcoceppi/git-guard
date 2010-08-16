<?php

foreach($logs as $log)
{
	list($commit, $message) = explode(" ", $log, 2);
	?>
	<p class="simple small"><input type="checkbox" name="log" id="log"> <?= truncate($message, 50); ?></p>
	<?php
}
?>
<span class="small"><span class="smlink" onclick="update_logs(<?= $log_start + 15; ?>)">More</span></span>
