<?php
include('application/libraries/Set_default_time_zone.php');
class Send_invoice_on_mail_Model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
			
        }
		public function get_offer_userid(){
			
            $this->db->distinct();
			$this->db->select("userid");
			$this->db->from("racetrack_offer");
			return $this->db->get()->result_array();
			
		}
		public function get_racetrack_offer_id($user_id){
			
            //$this->db->distinct();
			$this->db->select("rt_offer_id,userid");
			$this->db->from("racetrack_offer");
			$this->db->where("userid",$user_id);
			return $this->db->get()->result_array();
			
		}
		
		public function get_count_particluer_offer_booked($offer_id_list){
			
		   $newdata=array();	
		
			for($i=0; $i<count($offer_id_list);$i++){
  
		  //print_r($offer_id_list[0][$i]['rt_offer_id']);
		   for($j=0;$j<count($offer_id_list[$i]);$j++)
			   {
			  
			$this->db->select("*");
			$this->db->from("booking b");
			$this->db->join("racetrack_offer rf","rf.rt_offer_id=b.rt_offer_id",'inner');
			$this->db->join("track t","rf.track_id=t.track_id",'inner');
			$this->db->where("b.rt_offer_id",$offer_id_list[$i][$j]['rt_offer_id']);
			$da=$this->db->get()->result_array();
		
				  
				array_push($newdata,$da);

			   }
			   }
           print_r($newdata);
		}
		
				
		
	}	
		?>