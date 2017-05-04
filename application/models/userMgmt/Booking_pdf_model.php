<?php
include('application/libraries/Set_default_time_zone.php');
class Booking_pdf_model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
			
        }
		
	public function get_booking_data($booking_id){
		$this->db->select('bok.*,user.*,r_offer.*,track.*');
		$this->db->from('booking bok');
		$this->db->where("booking_id",$booking_id);
		$this->db->join("racetrackusers user","bok.userId=user.userId ","inner");
		$this->db->join("racetrack_offer r_offer","r_offer.rt_offer_id=bok.rt_offer_id ","inner");
		$this->db->join("track","track.track_id=r_offer.track_id ","inner");
		return $this->db->get()->result_array();
	}
	
	public function get_offrer_data($rt_offer_id){
		$this->db->select('user.*');
		$this->db->from('racetrack_offer rc_offrer');
		$this->db->where("rc_offrer.rt_offer_id",$rt_offer_id);
		$this->db->join("racetrackusers user","rc_offrer.userId=user.userId ","inner");
		
		return $this->db->get()->result_array();
	}
	public function get_offrer_offer_count($offrer_userid){
		$this->db->select('rc_offrer.*');
		$this->db->from('racetrack_offer rc_offrer');
		$this->db->where("rc_offrer.userId",$offrer_userid);
		$this->db->join("booking bok","rc_offrer.rt_offer_id=bok.rt_offer_id ","inner");
		
		return $this->db->get()->result_array();
	}
		
		

}	
		?>