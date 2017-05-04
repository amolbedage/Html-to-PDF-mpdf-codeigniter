<?php
include('application/libraries/Set_default_time_zone.php');
class Track_model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();		
				
        }
		

		
		public function CheckTrackName($nm)
		{
			$this->db->select('*');
			$this->db->from('track');
			$this->db->where('circuit_name',$nm);
			$query = $this->db->get()->result_array();
			return $query;			
		}
		
		public function saveTrack($getinfo)
		{
	
		return $this->db->insert('track',$getinfo);
		
		
		}
		
			public function delete_track($getinfo)
		{
			
			$getinfo=$_GET['info'];
		    $data=$this->db->select('track_id')->from('racetrack_offer')->where('track_id',$getinfo)->get()->result();
		   
		   if(empty($data)){
		    $this->db->where('track_id', $getinfo);
			 $this->db->delete('track');
			 
			 $this->db->select('*');
			 $this->db->from('track');
			 $query = $this->db->get()->result_array();
			return $query;
		   }else{
			return "Offer exists!!!";
		   }	
		}
		
		public function edittrack($getinfo)
		{
			$this->db->select("*");
			$this->db->from('track');
			$this->db->where('track_id',$getinfo);
			$query = $this->db->get()->result_array();
			return $query;
		}
		 
		public function search_track($getinfo)
		{
			$this->db->select('*');
			$this->db->from('track');
			$this->db->where('circuit_name like "%'.$getinfo.'%"' );
			$this->db->or_where('State like "%'.$getinfo.'%"' );
			$this->db->or_where('City like "%'.$getinfo.'%"' );
			$this->db->or_where('Country like "%'.$getinfo.'%"' );
			$query = $this->db->get()->result_array();
			return $query;
		
		}	 
		public function search_track1($getinfo)
		{
			$this->db->select('*');
			$this->db->from('racetrack_offer');
			$this->db->join('track','racetrack_offer.track_id=track.track_id');
			$this->db->where('offer_name like "%'.$getinfo.'%"' );
		//	$this->db->where('circuit_name like "%'.$getinfo.'%"' );
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function get_version_count($track_id)
		{
			$this->db->select('version_count');
			$this->db->from('track');
			$this->db->where('track_id',$track_id );
			return $this->db->get()->result_array();
		}
		public function delete_citcuit_version_data($track_id,$update_data)
		{
			$this->db->where('track_id',$track_id);
          return  $this->db->update('track',$update_data);
					
		}
		
		public function upadate_edit_track($my_data,$track_id)
		{
			$this->db->where('track_id',$track_id);
          return  $this->db->update('track',$my_data);
		}
		
	
	}	
		?>