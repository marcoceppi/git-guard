<div class="left">
	<?= (isset($current_site)) ? "You are currently browseing $current_site. " : ""; ?><form action="index.php" method="post"><input type="hidden" name="mode" value="dashboard"><input type="hidden" name="action" value="switch">Switch to: <?= $sites_dropdown->build(); ?> <input type="submit" name="switch" value="Go"></form>
</div>
<p class="clear"></p>
<div class="content">
	<div>
	  <p></p>
	  
	</div>
</div>
