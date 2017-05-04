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
$GetVerifiedStatusFields = array(
								'EmailAddress' => 'sagartpandit@gmail.com', 					// Required.  The email address of the PayPal account holder.
								'FirstName' => 'Sagar', 						// The first name of the PayPal account holder.  Required if MatchCriteria is NAME
								'LastName' => 'Pandit', 						// The last name of the PayPal account holder.  Required if MatchCriteria is NAME
								'MatchCriteria' => 'NAME'					// Required.  The criteria must be matched in addition to EmailAddress.  Currently, only NAME is supported.  Values:  NAME, NONE   To use NONE you have to be granted advanced permissions
								);

$PayPalRequestData = array('GetVerifiedStatusFields' => $GetVerifiedStatusFields);

// Pass data into class for processing with PayPal and load the response array into $PayPalResult
$PayPalResult = $PayPal->GetVerifiedStatus($PayPalRequestData);

// Write the contents of the response array to the screen for demo purposes.
echo '<pre />';
print_r($PayPalResult);
?>