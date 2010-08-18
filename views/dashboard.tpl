<div>
	<div style="float:left"><?= (isset($site['site_id'])) ? "You are currently browsing <i>" . $site['name'] . "</i> " : ""; ?></div><div class="right"><form action="index.php" method="post"><input type="hidden" name="mode" value="dashboard"><input type="hidden" name="action" value="switch">Switch to: <?= $sites_dropdown->build(); ?> <input type="submit" name="switch" value="Go"></form></div>
	<p class="clear"></p>
</div>
<p class="clear"></p>
	<div>
	  <div id="history_content" style="text-align:left; width:350px;" class="right content">
			<?php if(!empty($logs)) { include('views/_dashboard_logs.tpl'); } ?> &nbsp;
	  </div>
	  <div style="float:left;width:370px;" id="files_content" class="left content">
			<?php if(!empty($files)) { include('views/_dashboard_files.tpl'); } ?> &nbsp;
	  </div>
	  <div style="float:left;width:370px;" id="stage_content" class="left content">
			<?php if(!empty($staged)) { include('views/_dashboard_stage.tpl'); } else { echo "<p class=\"small\">There are no staged files</p>"; } ?> &nbsp;
	  </div>

	  <br class="clear">
	</div>
