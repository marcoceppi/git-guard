	<p class="clear"></p>
	<div id="site_new" style="text-align:left;" class="content">
			<form action="index.php" method="POST">
			<input type="hidden" name="mode" id="mode" value="site">
			<input type="hidden" name="action" id="action" value="new">
			<table border="0" align="center">
				<tr style="">
					<td style="text-align:right;vertical-align:top;">Site Path<br><span class="small">The site path must be the absolute path to<br>the folder that requires tracking.</span></td>
					<td style="vertical-align:top;"><input type="text" name="site_path" id="site_path" onChange="check_path()" value="<?= $site_path; ?>"><span id="path_check" style="display:inline;"></span></td>
				</tr>
				<tr>
					<td style="text-align:right;vertical-align:top;">Site Name<br><span class="small">This will be the public name applied to<br>this site.</span></td>
					<td style="vertical-align:top;"><input type="text" name="site_name" id="site_name" onChange="name_entered=true;" value="<?= $site_name; ?>"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;"><input type="submit" id="submit" name="submit" value="Add Site"></td>
				</tr>
			</table>
	  </div>
	  <br class="clear">
	</div>
