<div>
	<div style="float:left"><?= (isset($site['site_id'])) ? "You are currently browsing <i>" . $site['name'] . "</i> " : ""; ?></div><div class="right"><form action="index.php" method="post"><input type="hidden" name="mode" value="dashboard"><input type="hidden" name="action" value="switch">Switch to: <?= $sites_dropdown->build(); ?> <input type="submit" name="switch" value="Go"></form></div>
	<p class="clear"></p>
</div>
<p class="clear"></p>
	<div>
	  <div style="float:left;width:370px;" id="file_content" class="left content">
			<?php if(!empty($files)) { include("views/_dashboard_files.tpl"); } ?> &nbsp;
	  </div>
	  <div id="history_content" style="text-align:left; width:350px;" class="right content">
		<span class="small"><span style="small_link">New</span> | <span style="small_link">Modified</span> | <span style="small_link">Deleted</span> | <span style="small_link">All</span></span><br>
		3a6eaef... Marco Ceppi signed off<br>
		a29c77e... Marco Ceppi<br>
		6927403... Initial Commit<br>
	  </div>
	  <br class="clear">
	</div>
