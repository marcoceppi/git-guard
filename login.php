<?php

session_start();

switch( $action )
{
	case "try":
		$openid = getOpenIDURL();
		$consumer = getConsumer();

		// Begin the OpenID authentication process.
		$auth_request = $consumer->begin($openid);

		// No auth request means we can't begin OpenID.
		if( !$auth_request )
		{
			$error = 'Authentication Error - not a valid OpenID.';
			build_template("views/login.tpl", "Login Failed", false, true);
		}

		$sreg_request = Auth_OpenID_SRegRequest::build( array('nickname', 'email'), array('fullname', 'dob') );

		if( $sreg_request )
		{
			$auth_request->addExtension($sreg_request);
		}

		// Redirect the user to the OpenID server for authentication.
		// Store the token for this authentication so we can verify the
		// response.

		// For OpenID 1, send a redirect.  For OpenID 2, use a Javascript
		// form to send a POST request to the server.
		if ($auth_request->shouldSendRedirect())
		{
			$redirect_url = $auth_request->redirectURL(getTrustRoot(), getReturnTo());

			// If the redirect URL can't be built, display an error message.
			if( Auth_OpenID::isFailure($redirect_url) )
			{
				$error = "Could not redirect to server: " . $redirect_url->message;
				build_template("views/login.tpl", "Login Failed", false, true);
			}
			else
			{
				// Send redirect.
				header("Location: " . $redirect_url);
			}
		}
		else
		{
			// Generate form markup and render it.
			$form_id = 'openid_message';
			$form_html = $auth_request->htmlMarkup(getTrustRoot(), getReturnTo(), false, array('id' => $form_id));

			// Display an error if the form markup couldn't be generated;
			// otherwise, render the HTML.
			if (Auth_OpenID::isFailure($form_html))
			{
				$error = "Could not redirect to server: " . $form_html->message;
				build_template("views/login.tpl", "Login Failed",  false, true);
			}
			else
			{
				print $form_html;
			}
		}
	break;
	case "finish":
		$consumer = getConsumer();

		// Complete the authentication process using the server's response.
		$return_to = getReturnTo();
		$response = $consumer->complete($return_to);

		// Check the response status.
		if( $response->status == Auth_OpenID_CANCEL )
		{
			// This means the authentication was cancelled.
			$msg = 'Verification cancelled.';
		}
		elseif( $response->status == Auth_OpenID_FAILURE )
		{
			// Authentication failed; display the error message.
			$error = "OpenID authentication failed: " . $response->message;
		}
		elseif( $response->status == Auth_OpenID_SUCCESS )
		{
			// This means the authentication succeeded; extract the
			// identity URL and Simple Registration data (if it was returned).
			$openid = $response->getDisplayIdentifier();
			$esc_identity = escape($openid);

			$sql = "SELECT * FROM `users` WHERE `identity_url`='$esc_identity'";
			$user = $db->sql_fetchrow($db->sql_query($sql));
			
			// There is a user already in the database
			if( $db->sql_numrows() > 0 )
			{
				// Create session data
				$success = "Welcome back " . $user['name'] . "!";
			}
			else
			{
				$sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
				$sreg = $sreg_resp->contents();
				$sql = "INSERT INTO `users` (`username`, `email`, `name`, `identity_url`) VALUES ('" . $sreg['nickname'] . "', '" . $sreg['email'] . "', '" . $sreg['fullname'] . "', '$esc_identity')";
				
				if( !$db->sql_query($sql) )
				{
					$error = "Unable to dump your data into my base.";
				}
				else
				{
					$success = "We've done what you wanted all your base is belonged to mai data.";
				}
			}		
		}
		
		if( isset($error) || !is_null($error) )
		{
			build_template("views/login.tpl", "Login Error", false, true);
		}
		else
		{
			session_store('success', (( isset($success) ) ? $success : NULL));
			session_store('message', (( isset($msg) ) ? $msg : NULL));
			session_store('user', $user);
			header("Location: index.php");
		}

	break;
	default:
		build_template("views/login.tpl", "Login");
	break;
}

?>
