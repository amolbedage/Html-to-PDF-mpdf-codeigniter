<?php
include('application/libraries/Set_default_time_zone.php');
class Admin_model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();		
				
        }
		

		public function saveTrack($getinfo)
		{
	
		return $this->db->insert('track',$getinfo);
		
		
		}
		
	
	}	
		?>