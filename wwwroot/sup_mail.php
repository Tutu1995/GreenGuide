<?php

function sup_mail($company, $address, $city, $review, $lng, $lat, $rating, $water, $air, $waste, $land, $living, $other, $news) {

	$url = 'https://api.sendgrid.com/';
	$user = 'azure_f92ef4ded444b595be806608868c3738@azure.com';
	$pass = '2g6JXZNf0h83bac';

	$params = array(
		'api_user' => $user,
		'api_key' => $pass,
		'to' => 'yiruli09@gmail.com',
		'subject' => 'Green Guide Supplier Community Review Notice',

		'html' => 	 'Company: '.$company.'<br/>'.
		'Address: '.$address.'<br/>'.
		'City: '.$city.'<br/>'.
		'Rating: '.$rating.'<br/>'.
		'Reviews: '.$review. '<br/>'.
		'Environment Type: '.$water.' '.$air.' '.$waste.' '.$land.' '.$living.' '.$other.'<br/>'.
		'Related News, Videos, or links: '.$news.'<br/>',

		'text' => 'Company: '.$company,
		'from' => 'yiruli09@gmail.com',
	);

	$request = $url.'api/mail.send.json';

	// Generate curl request
	$session = curl_init($request);

	// Tell curl to use HTTP POST
	curl_setopt ($session, CURLOPT_POST, true);

	// Tell curl that this is the body of the POST
	curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

	// Tell curl not to return headers, but do return the response
	curl_setopt($session, CURLOPT_HEADER, false);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);

	// obtain response
	$response = curl_exec($session);
	curl_close($session);



}


?>
