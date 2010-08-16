<?php

foreach($logs as $log)
{
	list($commit, $message) = explode(" ", $log, 2);
	?>
	<p class="simple small"><input type="checkbox" name="log" id="log"> <?= truncate($message, 50); ?></p>
	<?php
}
?>
<span class="small"><span style="smlink">More</span> | <span style="smlink">More?</span></span><br>
