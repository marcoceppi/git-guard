<div class="content">
	<div id="verify-form">
	  <p></p>
	  <form method="post" action="<?php getWebRoot(true); ?>">
		OpenID URL:
		<input type="hidden" name="action" value="try" />
		<input type="hidden" name="mode" value="login" />
		<input type="text" name="openid_identifier" value="http://core.theo.danya.com/" />
		<br />
		<input type="submit" value="Login" />
	  </form>
	</div>
</div>
