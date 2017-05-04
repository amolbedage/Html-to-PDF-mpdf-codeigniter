<?php
// Include required library files.
require_once('config.php');
require_once('../autoload.php');


// Create PayPal object.
$PayPalConfig = array(
					  'Sandbox' => true,
					  'DeveloperAccountEmail' => 'kirant-facilitator@theaxontech.com',
					  'ApplicationID' => 'APP-80W284485P519543T',
					  'DeviceID' => '',
					  'IPAddress' => $_SERVER['REMOTE_ADDR'],
					  'APIUsername' => 'kirant-facilitator_api1.theaxontech.com',
					  'APIPassword' => 'RYGQRRVD593Y9LUS',
					  'APISignature' => "AFcWxV21C7fd0v3bYYYRCpSSRl31A0-ZLPQiHONE565PhfQA.pHXprKl",                   
					);

$PayPal = new angelleye\PayPal\Adaptive($PayPalConfig);

// Prepare request arrays
$PaymentDetailsFields = array(
							'PayKey' => 'AP-7FG47238E5557812F', 							// The pay key that identifies the payment for which you want to retrieve details.  
							'TransactionID' => '1BM714721N413291D', 						// The PayPal transaction ID associated with the payment.  
							'TrackingID' => ''							// The tracking ID that was specified for this payment in the PayRequest message.  127 char max.
							);
							
$PayPalRequestData = array('PaymentDetailsFields' => $PaymentDetailsFields);


// Pass data into class for processing with PayPal and load the response array into $PayPalResult
$PayPalResult = $PayPal->PaymentDetails($PayPalRequestData);

// Write the contents of the response array to the screen for demo purposes.
echo '<pre />';
print_r($PayPalResult);
?>