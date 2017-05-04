<?php
//date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') OR exit('No direct script access allowed');
include('application/libraries/Set_default_time_zone.php');
class CEmail {

        public function configEmail()
        {
		$config=array();
		$config['useragent'] = 'CodeIgniter';
		/* $config['protocol'] = 'smtp';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		$config['smtp_host'] = 'smtp.1und1.de';
		$config['smtp_user'] = 'racetrackinfo@racetrackbooking.com';
		$config['smtp_pass'] = 'Racetrack@2017#';
		$config['smtp_port'] =587; 
		$config['smtp_timeout'] = 100; */
		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = FALSE;
		$config['priority'] = 3;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['bcc_batch_mode'] = FALSE;
		$config['bcc_batch_size'] = 200;   

 

        //$config['protocol']    = 'smtp';
       // $config['smtp_host']    = 'ssl://smtp.gmail.com';
        ///$config['smtp_port']    = '465';
       // $config['smtp_timeout'] = '7';
        //$config['smtp_user']    = 'amolbedage1008@gmail.com';
      //  $config['smtp_pass']    = 'amolamol12';
       
		
		return $config;
       // print_r($config);
        }
}