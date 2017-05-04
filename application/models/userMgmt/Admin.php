<?php
include('application/libraries/Set_default_time_zone.php');
class Admin_model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();		
				
        }
		

		public function saveTrack($getinfo,$create_length,$create_version,$create_image)
		{
		$arr=array('length1'=>$create_length[0],
		'length2'=>$create_length[1],
		'length3'=>$create_length[2],
		'length4'=>$create_length[3],
		'length5'=>$create_length[4],
		'length6'=>$create_length[5],
		'version1'=>$create_version[0],
		'version2'=>$create_version[1],
		'version3'=>$create_version[2],
		'version4'=>$create_version[3],
		'version5'=>$create_version[4],
		'version6'=>$create_version[5],
		'length1'=>$create_image[0],
		'length1'=>$create_image[2],'length1'=>$create_image[2],'length1'=>$create_image[3],
		'length1'=>$create_image[4],'length1'=>$create_image[5],);
		
		return $this->db->insert('track',$arr);
		//return $this->db->inseret('Track',$getinfo);
		
		
		}
		
	
	}	
		?>