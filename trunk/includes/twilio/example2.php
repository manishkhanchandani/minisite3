<?php
	/* Include the PHP TwilioRest library */
	require "twiliorest.php";
	createMessage($msg, $voice='woman') {
		$xml = "<?xml version='1.0' encoding='utf-8' ?>
<Response>
	<Say voice='$voice'>$msg</Say>
</Response>";
	}
	/* Twilio REST API version */
	$ApiVersion = "2008-08-01";
	
	/* Set our AccountSid and AuthToken */
	$AccountSid = "AC94b06e556ff5dc4047cf5599522ff470";
	$AuthToken = "4a11eb43a9ab1c1eeaa7d2db067daf73";

	/* Outgoing Caller ID you have previously validated with Twilio */
	$CallerID = '919-386-1678';
	
	/* Instantiate a new Twilio Rest Client */
	$client = new TwilioRestClient($AccountSid, $AuthToken);
	
	/* The main method of the TwilioRestClient object is the request method.  Here's it's signature:
	 * 		request($urlPath, $httpMethod = 'GET', $parameters = array())
	 * 			
	 * 			$urlPath: the REST URL path, everything after https://api.twilio.com/$ApiVersion
	 * 			$httpMethod: which HTTP method to use, defaults to GET.  Depending on the operation, may be GET, POST, PUT or DELETE
	 * 			$parameters: for PUT or POST methods, you'll often need to pass data to the resource via this associative array
	 */
	
	/****************************************************************************************
	 * Initiate a new outbound call
	 * 		Is a POST to the Calls resource
	 * 		Returns a TwilioRestResponse object
	 ****************************************************************************************/
	$response = $client->request("/$ApiVersion/Accounts/$AccountSid/Calls", "POST", array(
		"Caller" => $CallerID, 	// Outgoing Caller ID you have previously validated with Twilio
		"Called" => "919-386-1678",		// The phone number you wish to dial
		"Url" => "http://demo.twilio.com/welcome" 		// the URL of the web application on your server that will handle the call when it connects
	));
	
	// check response for success or error
	if($response->IsError)
		echo "Error starting phone call: {$response->ErrorMessage}\n";
	else
		echo "Started call: {$response->ResponseXml->Call->Sid}\n";
		
	echo "========================================================================\n";
	
	/****************************************************************************************
	 * Get Recent Calls
	 * 		Is a GET to the Calls resource
	 ****************************************************************************************/
	$response = $client->request("/$ApiVersion/Accounts/$AccountSid/Calls", "GET");
	
	if($response->IsError)
		echo "Error fetching recent calls: {$response->ErrorMessage}";
	else {
		
		// iterate over calls
		foreach($response->ResponseXml->Calls->Call AS $call)
			echo "Call from {$call->Caller} to {$call->Called} at {$call->StartTime} of length: {$call->Duration}\n";
	}

	echo "========================================================================\n";

	/****************************************************************************************
	 * Get Recent Developer Notifications
	 * 		Is a GET to the Notifications resource
	 ****************************************************************************************/
	$response = $client->request("/$ApiVersion/Accounts/$AccountSid/Notifications");
	
	if($response->IsError)
		echo "Error fetching recent notifications: {$response->ErrorMessage}";
	else {
		
		// iterate over notifications
		foreach($response->ResponseXml->Notifications->Notification AS $notification)
			echo "Log entry (level {$notification->Log}) on {$notification->MessageDate}: {$notification->MessageText}\n";
	}

	echo "========================================================================\n";

	/****************************************************************************************
	 * Get Recordings for a certain Call
	 * 		Is a GET to the Recordings resource with a query string URL parameter filter
	 ****************************************************************************************/
	$callSid = "CA123456789123456789";
	$response = $client->request("/$ApiVersion/Accounts/$AccountSid/Recordings", "GET", array("CallSid" => $callSid));

	if($response->IsError)
		echo "Error fetching recordings for call $callSid: {$response->ErrorMessage}";
	else {
		
		// iterate over recordings found
		foreach($response->ResponseXml->Recordings->Recording AS $recording)
			echo "Recording of duration {$recording->Duration} seconds made on {$recording->DateCreated} at URL: /Accounts/$AccountSid/Recordings/{$recording->Sid}\n";
	}

	echo "========================================================================\n";

	/****************************************************************************************
	 * Delete a Recording 
	 * 		Is a DELETE to a Recording resource 
	 ****************************************************************************************/
	$recordingSid = "RE12345678901234567890";
	$response = $client->request("/$ApiVersion/Accounts/$AccountSid/Recordings/$recordingSid", "DELETE");
	if($response->IsError)
		echo "Error deleting recording $recordingSid: {$response->ErrorMessage}\n";
	else
		echo "Successfully deleted recording $recordingSid\n";

?>