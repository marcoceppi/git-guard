<?php

switch( $action )
{
	case "try":
		$openid = getOpenIDURL();
		$consumer = getConsumer();
		
		if( !$openid )
		{
			$html['error'] = "Expected an OpenID URL.";
			build_template("login", "Login Failed", false, true);
		}

		// Begin the OpenID authentication process.
		$auth_request = $consumer->begin($openid);

		// No auth request means we can't begin OpenID.
		if( !$auth_request )
		{
			$html['error'] = 'Authentication Error - not a valid OpenID.';
			build_template("login", "Login Failed", false, true);
		}

		$sreg_request = Auth_OpenID_SRegRequest::build( array('nickname', 'email'), array('fullname', 'dob') );

		if( $sreg_request )
		{
			$auth_request->addExtension($sreg_request);
		}
		
		$attributes[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/email', 1, 1, 'email');
		$attributes[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/first', 1, 1, 'firstname');
		$attributes[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/last', 1, 1, 'lastname');

		// Create AX fetch request
		$ax = new Auth_OpenID_AX_FetchRequest;

		// Add attributes to AX fetch request
		foreach($attributes as $attribute)
		{
				$ax->add($attribute);
		}
		
		$auth_request->addExtension($ax);
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
				$html['error'] = "Could not redirect to server: " . $redirect_url->message;
				build_template("login", "Login Failed", false, true);
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
				$html['error'] = "Could not redirect to server: " . $form_html->message;
				build_template("login", "Login Failed",  false, true);
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
			$html['error'] = 'Verification cancelled.';
		}
		elseif( $response->status == Auth_OpenID_FAILURE )
		{
			// Authentication failed; display the error message.
			$html['error'] = "OpenID authentication failed: " . $response->message;
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
				$ax_resp = Auth_OpenID_AX_FetchResponse::fromSuccessResponse($response);
				
				if( $ax_resp )
				{
					$name = $ax_resp->data['http://axschema.org/namePerson/first'][0] . " " . $ax_resp->data['http://axschema.org/namePerson/last'][0];
					$email = $ax_resp->data['http://axschema.org/contact/email'][0];
				}
				else
				{
					$sreg = $sreg_resp->contents();
					$name = $sreg['fullname'];
					$email = $sreg['email'];
				}
				
				$sql = "INSERT INTO `users` (`username`, `email`, `name`, `identity_url`) VALUES ('" . $sreg['nickname'] . "', '" . $email . "', '" . $name . "', '$esc_identity')";
				
				if( !$db->sql_query($sql) )
				{
					$html['error'] = "Unable to dump your data into my base.";
				}
				else
				{
					$success = "Thanks for registering $name";
					$sql = "SELECT * FROM `users` WHERE `identity_url`='$esc_identity'";
					$user = $db->sql_fetchrow($db->sql_query($sql));
				}
			}		
		}
		
		if( isset($html['error']) || !is_null($html['error']) )
		{
			build_template("login", "Login Error", false, true);
		}
		else
		{
			session_store('html', array('success' => $success, 'msg' => $msg ));
			session_store('user', $user);
			header("Location: index.php");
		}

	break;
	default:
		build_template("login", "Login");
	break;
}

?>
