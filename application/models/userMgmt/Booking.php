<?php
include('application/libraries/Set_default_time_zone.php');
class Booking extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
			
        }
		public function save_transation_id($booking_id,$data){
			$this->db->where('booking_id',$booking_id);
			$this->db->update('booking',$data);
			
			$query='SELECT racetrackusers.userEmail,racetrack_offer.offer_name from racetrackusers,booking,racetrack_offer where racetrack_offer.userId=racetrackusers.userId and racetrack_offer.rt_offer_id=booking.rt_offer_id and booking.booking_id='.$booking_id;
			
			return $this->db->query($query)->result_array();
		}
		
		public function setNotification($data)
		{
		$this->db->select('*');
		$this->db->from('racetrackusers');
		$this->db->where('userEmail',$data);
		$uid=$this->db->get()->result_array()[0]['userId'];
		
		}
		
		public function get_offline_booked_data(){
			 $userId=$this->session->userdata('userid');
			$this->db->select("*");
			$this->db->from("booking b");
			$this->db->join("racetrack_offer r","r.rt_offer_id=b.rt_offer_id","inner");
			$this->db->join("track t","t.track_id=r.track_id","inner");
			$this->db->where("b.userId",$userId);
			$this->db->where("b.isOfflinePayment",1);
			$this->db->order_by("b.booking_id", "desc");
		    return $this->db->get()->result_array();
			
		}
		
		public function pay_offline_teack_save_data($data){
			//return $data;
			$this->db->insert("booking",$data);
			if($this->db->affected_rows() > 0){
				  $userId=$this->session->userdata('userid');
					$id=$this->db->insert_id();
				   //$querystr='SELECT track.circuit_name,racetrackusers.userEmail,racetrackusers.userFname,racetrackusers.userLname,track.AddressLine1,track.TownArea,track.City,track.State,track.ZipCode,racetrack_offer.rt_currency,track.Country,racetrack_offer.rt_version,racetrack_offer.versionName,racetrack_offer.iscar,racetrack_offer.ismotorbike,racetrack_offer.isracecar, racetrack_offer.istouring,racetrack_offer.isformula,racetrack_offer.isgtcar,racetrack_offer.isstreet,booking.extras_details,booking.extras_price,booking.total_days,booking.total_days_price,booking.pit_details,booking.grand_total,booking.offer_dates,booking.No_of_vehicles,booking.tot_vehicle_price,booking.booking_date,booking.Transaction_id from booking,racetrack_offer,racetrackusers,track where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.userId='.$userId.' and booking.userId=racetrackusers.userId and racetrack_offer.track_id=track.track_id and booking.booking_id='.$id;
				   //$querystr='SELECT track.circuit_name,racetrackusers.userEmail,racetrackusers.userFname,racetrackusers.userLname,track.AddressLine1,track.TownArea,track.City,track.State,track.ZipCode,racetrack_offer.rt_currency,track.Country,racetrack_offer.rt_version,racetrack_offer.versionName,racetrack_offer.iscar,racetrack_offer.ismotorbike,racetrack_offer.isracecar, racetrack_offer.istouring,racetrack_offer.isformula,racetrack_offer.isgtcar,racetrack_offer.isstreet,booking.extras_details,booking.extras_price,booking.total_days,booking.total_days_price,booking.pit_details,booking.grand_total,booking.offer_dates,booking.No_of_vehicles,booking.tot_vehicle_price,booking.booking_date,booking.Transaction_id from booking,racetrack_offer,racetrackusers,track where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.userId='.$userId.' and booking.userId=racetrackusers.userId and racetrack_offer.track_id=track.track_id and booking.booking_id='.$id;
				   $querystr='SELECT track.*,racetrackusers.*,racetrack_offer.*,booking.* from booking,racetrack_offer,racetrackusers,track where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.userId='.$userId.' and booking.userId=racetrackusers.userId and racetrack_offer.track_id=track.track_id and booking.booking_id="'.$id.'"';
				  $query = $this->db->query($querystr)->result_array();
				  return $query;
			}
			 
			
		}
		public function get_offline_payment_account_info($offer_id){// and get email id who are offer created 
			$this->db->select('userId');
			$this->db->from('racetrack_offer');
			$this->db->where('rt_offer_id',$offer_id);
			$res=$this->db->get()->result_array();
			$res[0]['userId'];
			
			$this->db->select('userEmail,account_no,account_type,bank_name,holder_name,ifsc_code');
			$this->db->from('racetrackusers');
			$this->db->where('userId',$res[0]['userId']);
			return $this->db->get()->result_array();
			
			
		}
		public function addBooking($data)
		{
		$this->db->insert('booking', $data);
		$id=$this->db->insert_id();
		$querystr='SELECT booking.booking_date,track.circuit_name,racetrackusers.userEmail,racetrackusers.userFname,racetrackusers.userLname,track.AddressLine1,track.TownArea,track.City,track.State,track.ZipCode,racetrack_offer.rt_currency,track.Country,racetrack_offer.rt_version,racetrack_offer.versionName,racetrack_offer.iscar,racetrack_offer.ismotorbike,racetrack_offer.isracecar, racetrack_offer.istouring,racetrack_offer.isformula,racetrack_offer.isgtcar,racetrack_offer.isstreet,booking.extras_details,booking.extras_price,booking.total_days,booking.total_days_price,booking.pit_details,booking.grand_total,booking.offer_dates,booking.No_of_vehicles,booking.tot_vehicle_price,booking.Transaction_id from booking,racetrack_offer,racetrackusers,track where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.userId='.$data['userId'].' and booking.userId=racetrackusers.userId and racetrack_offer.track_id=track.track_id and booking.booking_id='.$id;
		$query = $this->db->query($querystr)->result_array();
		return $query;
		}
		
		public function getBookedDates($data)
		{
			$this->db->select('offer_dates');
			$this->db->from('booking');
			$this->db->where('rt_offer_id',$data);
			$query = $this->db->get()->result_array();
		return $query;
		}
		
		public function getBookedDatesWithVeh($data)
		{
		$this->db->select('offer_dates,No_of_vehicles');
		$this->db->from('booking');
		$this->db->where('rt_offer_id',$data);
		$query = $this->db->get()->result_array();
		return $query;
		}
		
		public function show_my_bookings($id)
		{
		$this->db->select('*');
		$this->db->from('booking b');
		$this->db->where('b.userId',$id);
		$this->db->join('racetrack_offer r','r.rt_offer_id=b.rt_offer_id','inner');
		
		$query = $this->db->get()->result_array();
		return $query;
		}
		
		public function getuserid($offer_id)
		{
			$this->db->select('userId');
			$this->db->from('racetrack_offer');
			$this->db->where('rt_offer_id',$offer_id);
			$query = $this->db->get()->result_array();
		return $query;

		}
		
		public function getsessionemail($u_sessionid)
		{
			$this->db->select('userEmail');
			$this->db->from('racetrackusers');
			$this->db->where('userId',$u_sessionid);
			$query = $this->db->get()->result_array();
			return $query;
			
			
		}
		public function getemail($user_id)
		{
			$this->db->select('userEmail');
			$this->db->from('racetrackusers');
			$this->db->where('userId',$user_id);
			$query = $this->db->get()->result_array();
			return $query;
		}
		public function save_booking_data($bookdata,$userId,$Transaction_id){
			if($Transaction_id)
			{
				$this->db->select("*");
				$this->db->from('booking');
				$this->db->where('Transaction_id',$Transaction_id);
				$query = $this->db->get()->result_array();
			 }
			 
			 $count_booking=count($query);
			 if($count_booking==0)
			 {
				$this->db->insert('booking',$bookdata); 
				 if(isset($_SESSION['bookingDataAmol']))
				{
				unset($_SESSION['bookingDataAmol']);
				}
			 }
		   
	    	//$id=$this->db->insert_id();
			$id=$Transaction_id;
		  // $querystr='SELECT track.circuit_name,racetrackusers.userEmail,racetrackusers.userFname,racetrackusers.userLname,track.AddressLine1,track.TownArea,track.City,track.State,track.ZipCode,racetrack_offer.rt_currency,track.Country,racetrack_offer.rt_version,racetrack_offer.versionName,racetrack_offer.iscar,racetrack_offer.ismotorbike,racetrack_offer.isracecar, racetrack_offer.istouring,racetrack_offer.isformula,racetrack_offer.isgtcar,racetrack_offer.isstreet,booking.extras_details,booking.extras_price,booking.total_days,booking.total_days_price,booking.pit_details,booking.grand_total,booking.offer_dates,booking.track_booking_date,booking.No_of_vehicles,booking.tot_vehicle_price,booking.booking_date,booking.Transaction_id from booking,racetrack_offer,racetrackusers,track where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.userId='.$userId.' and booking.userId=racetrackusers.userId and racetrack_offer.track_id=track.track_id and booking.Transaction_id="'.$id.'"';
		  $querystr='SELECT track.*,racetrackusers.*,racetrack_offer.*,booking.* from booking,racetrack_offer,racetrackusers,track where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.userId='.$userId.' and booking.userId=racetrackusers.userId and racetrack_offer.track_id=track.track_id and booking.Transaction_id="'.$id.'"';
		  $query = $this->db->query($querystr)->result_array();
		  return $query;
		}
		
		
	public function show_offerer_ac_info($userId){
		
		$this->db->select('userLname,userFname,holder_name,bank_name,account_no,account_type,ifsc_code,userEmail');
	 $this->db->from('racetrackusers');
	 $this->db->where('userId',$userId);
	 return $this->db->get()->result_array();
	 

	}
		
	
	}	
		?>