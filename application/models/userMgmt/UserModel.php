<?php
include('application/libraries/Set_default_time_zone.php');
class UserModel extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
			
        }
		
		
		public function getFirstAndLastName($uid)
		{
		$this->db->select('*');
		$this->db->from('racetrackusers');
		$this->db->where('userId',$uid);
		$query = $this->db->get()->result_array();
		return $query;
		}
		
		public function create_admin()
		{
				$this->db->select('*');
				$this->db->from('racetrackusers');
				$this->db->where('userRole','admin');
				$query = $this->db->get()->result_array();
				if(count($query)==0)
				{
					$sql = "INSERT INTO `racetrackusers` (`userId`, `userRole`, `userName`, `userEmail`, `userFname`, `userLname`, `userDob`, `isCompany`, `userPassword`, `userVerification`, `country`, `addemail`, `cell`, `address`, `vat`, `compname`, `compadd`, `compcont`, `account_no`, `account_type`, `bank_name`, `holder_name`, `ifsc_code`, `baned_user`) VALUES (NULL, 'admin', 'admin', 'admin@admin.com', 'admin', 'admin', '', '', '123','100', '', '', '', '','', '', '', '', NULL, NULL, NULL, NULL, NULL, '')";
					$this->db->query($sql);
					//	echo "Ok";
				}
		}
		
		public function get_user_email_id_fromOffer($ofid)
		{
		$this->db->select('racetrackusers.paypalemail');
		$this->db->from('racetrackusers');
		$this->db->join('racetrack_offer','racetrackusers.userId=racetrack_offer.userId','inner');
		$this->db->where('racetrack_offer.rt_offer_id',$ofid);
		$query = $this->db->get()->result_array();
		return $query;
		}
		
		public function get_user_email_id($email_id)
		{
		$this->db->select('userId');
		$this->db->from('racetrackusers');
		$this->db->where('userEmail',$email_id);
		$query = $this->db->get()->result_array();
		return $query;
		}
		public function get_userIdFromEmail($email)
		{
		$this->db->select('*');
		$this->db->from('racetrackusers');
		$this->db->where('userEmail',$email);
		$query = $this->db->get()->result_array();
		return $query;
		}
		
		public function update_password($p,$u)
		{
		$data=Array('userPassword' => $p);
		$this->db->where('userId',$u);
        echo $this->db->update('racetrackusers', $data);
		}
		//get all tracks
		public function get_all_tracks()
		{
		$this->db->from('track');
		$query = $this->db->get()->result_array();
		return $query;
		}
		
		//registration
		public function registerNewUser($data)
		{
		//print_r($data);
		$this->db->insert('racetrackusers', $data);
		return $this->db->insert_id();
		}
		
		//verify email users
		public function verifyEmailUser($user_id)
		{
		$data=Array('userVerification' => '50');
		$this->db->where('userId',$user_id);
        $this->db->update('racetrackusers', $data);
		$this->db->select('userFname');
		$this->db->from('racetrackusers');
		$this->db->where('userId', $user_id ); 
		$query = $this->db->get()->result_array();
		return $query;
		}
		
		//get ranges
		public function get_ranges($ofid)
		{
			$this->db->select('*');
			$this->db->from('racetrack_offer');
			$this->db->where('rt_offer_id',$ofid);
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		
		public function get_ranges_for_all($trid,$trvr)
		{
			$this->db->select('dateRanges');
			$this->db->from('racetrack_offer');
			$this->db->where('track_id',$trid);
			$this->db->where('rt_version',$trvr);
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function get_ranges_for_all_test($trid,$trvr,$id)
		{
			$this->db->select('booking.offer_dates');
			$this->db->from('booking');
			$this->db->join('racetrack_offer','racetrack_offer.rt_offer_id=booking.rt_offer_id');
			$this->db->where('racetrack_offer.track_id',$trid);
			$this->db->where('racetrack_offer.rt_version',$trvr);
			$this->db->where('booking.No_of_vehicles',null);
			$this->db->where('booking.userId',$id);
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function get_ranges_for_all_test1($trid,$trvr,$id)
		{
			$this->db->select('dateRanges');
			$this->db->from('racetrack_offer');
			$this->db->where('track_id',$trid);
			$this->db->where('rt_version',$trvr);
			$this->db->where('userId',$id);
			$this->db->where('rt_shared','1');
			//$this->db->where('racetrack_offer.rt_shared','1');
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		
		public function userCompany($userid)
		{
			$this->db->select('userVerification');
			$this->db->from('racetrackusers');
			$this->db->where('userId',$userid);
			$query = $this->db->get()->result_array();
			return $query;
		}
		//update information
		public function updateinfo($getinfo,$userid)
		{
			//print_r($getinfo);
			
			$this->db->where('userId', $userid);
			$this->db->update('racetrackusers', $getinfo);
			$data=Array('userVerification' => '100');
			$this->db->where('userId',$userid);
			return $this->db->update('racetrackusers', $data);
		}
		
		public function add_ranges($range,$offid,$id)
		{
			$arr=array('dateRanges'=>$range);
			$this->db->where('rt_offer_id', $offid);
			return $this->db->update('racetrack_offer', $arr);

		}
		public function add_ranges_select($id)
		{
			$this->db->select('account_no');
			$this->db->from('racetrackusers');
			$this->db->where('userId', $id);
			$query = $this->db->get()->result_array();
			return $query;
		}
		//view offers
		public function view_offers($id)
		{
			$this->db->select('*');
			$this->db->from('racetrack_offer');
			$this->db->join('track','racetrack_offer.track_id=track.track_id');
			$this->db->where('userId',$id);
			$this->db->order_by('rt_offer_id', 'DESC');
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		//search circuit name
		
		public function search_cirnm($getinfo)
		{
			//return $this->db->query("SELECT * FROM track WHERE track.circuit_name LIKE '%$getinfo%'"); 
			
			$this->db->select('*');
			$this->db->from('track');
			$this->db->where('track.circuit_name like "'.$getinfo.'%"' );
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function racetrack_offer($getinfo)
		{
			//return $getinfo;
		 $this->db->insert('racetrack_offer', $getinfo);
		 return $this->db->insert_id();
		}
		public function edit_profile($id)
		{
			$this->db->select('*');
			$this->db->from('racetrackusers');
			$this->db->where('userId',$id);
			$query = $this->db->get()->result_array();
			return $query;
		}
		public function save_profile($getinfo,$userid)
		{
			$this->db->where('userId', $userid);
			return $this->db->update('racetrackusers', $getinfo);
		
		}
		
		public function editoffer($getinfo)
		{
			$this->db->select("racetrack_offer.*,track.*");
			$this->db->from('racetrack_offer');
			$this->db->join('track','racetrack_offer.track_id=track.track_id');			
			$this->db->where('rt_offer_id',$getinfo);
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		
		public function save_offer($getinfo,$offer_id)
		{
			$this->db->where('rt_offer_id', $offer_id);
			return $this->db->update('racetrack_offer', $getinfo);
		}
		
		public function payment_info($data,$id)
		{
			$this->db->where('userId', $id);
			return $this->db->update('racetrackusers', $data);
		}
		
		public function addFav($getinfo ,$id)
		{
			$arr=array('userId'=>$id,'rt_offer_id'=>$getinfo);
			return $this->db->insert('fav_track',$arr);
			
		}
		public function removeFav($getinfo ,$id)
		{
			$this->db->where('userId', $id);
			$this->db->where('rt_offer_id', $getinfo);
			 $this->db->delete('fav_track');
		}
		public function check_fav($getinfo ,$id)
		{
			$this->db->select('*');
			$this->db->from('fav_track');
			$this->db->where('userId',$id);
			$this->db->where('rt_offer_id', $getinfo);
			$query = $this->db->get()->result_array();
			return $query;
		}
		public function getversion($getinfo)
		{
			$this->db->select('*');
			$this->db->from('track');
			$this->db->where('track_id',$getinfo);
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		public function search_offer($getinfo,$id)
		{
		if(!$getinfo)
		{	
		$this->db->select('*');
		$this->db->from('racetrack_offer');
		$this->db->join('track','racetrack_offer.track_id=track.track_id');
		$this->db->where('userId',$id);
		$query = $this->db->get()->result_array();
		return $query;
		}
		else
		{
		$this->db->select('*');
		$this->db->from('racetrack_offer');
		$this->db->join('track','racetrack_offer.track_id=track.track_id');
		//$this->db->where('userId',$id);
		$this->db->where('racetrack_offer.offer_name like "%'.$getinfo.'%"and racetrack_offer.userId='.$id  );
		$this->db->or_where('racetrack_offer.rt_length like "%'.$getinfo.'%" and racetrack_offer.userId='.$id  );
		$this->db->or_where('track.circuit_name like "'.$getinfo.'%" and racetrack_offer.userId='.$id );
		$query = $this->db->get()->result_array();
		return $query;
		// $this->db->where('racetrack_offer.offer_name like "%'.$getinfo.'%"' );
		// $this->db->or_where('racetrack_offer.rt_length like "'.$getinfo.'%" and racetrack_offer.userId='.$id);
		// $this->db->or_where('track.circuit_name like "'.$getinfo.'%" and racetrack_offer.userId='.$id );
		// $this->db->or_where('track.vehical_qty like "'.$getinfo.'%" and vehical_qty.userId='.$id );
		// $query = $this->db->get()->result_array();	
		// return $query;
		}
			
		}
		
		public function check_offname($getinfo)
		{
		$this->db->select('*');
		$this->db->from('racetrack_offer');
		$this->db->where('offer_name',$getinfo);
		$query = $this->db->get()->result_array();
		return $query;
		}
		
		
		public function latest_track()
		{
			$this->db->select('circuit_name');
			$this->db->from('track');
			$this->db->order_by('track_id', 'DESC');
			$this->db->limit('8');
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		
		//save password
		
		public function save_pass($getinfo,$id)
		{
			$data=Array('userPassword' => $getinfo);
			$this->db->where('userId', $id);
			return $this->db->update('racetrackusers', $data);
			
		}
		
		//chk password
		public function chk_pass($getinfo,$id)
		{
			$this->db->select("*");
			$this->db->from("racetrackusers");
			$this->db->where('userPassword',$getinfo);
			$this->db->where('userId',$id);
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function testFullBooking($offerid)
		{
			$this->db->select("offer_dates");
			$this->db->from("booking");
			$this->db->where("rt_offer_id",$offerid);
			$query = $this->db->get()->result_array();
			return $query;
		}
		public function testFullBooking1($offerid)
		{	
			$this->db->select("dateRanges,rt_shared");
			$this->db->from("racetrack_offer");
			$this->db->where("rt_offer_id",$offerid);
			$query = $this->db->get()->result_array();
			return $query;
		}
		public function testFullBooking2($offerid)
		{	
			$this->db->select("dateRanges");
			$this->db->from("racetrack_offer");
			$this->db->where("rt_offer_id",$offerid);
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function chkbooked($id)
		{
			$data=Array('isBooked' => "1");
			$this->db->where('rt_offer_id', $id);
			return $this->db->update('racetrack_offer', $data);
		
		}
		public function chkbookedsh($idsh)
		{
			$data=Array('isBooked' => "1");
			$this->db->where('rt_offer_id', $idsh);
			return $this->db->update('racetrack_offer', $data);
			
		}
		
		public function getAllOfferIds()
		{
			$this->db->select("rt_offer_id,vehical_qty");
			$this->db->from("racetrack_offer");
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function vehqty($ids)
		{
			
			//return $ids;
			$this->db->select("No_of_vehicles,total_days");
			$this->db->from("booking");
			$this->db->where("rt_offer_id",$ids);
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		
		public function view_status()
		{
			$this->db->select("rt_offer_id,vehical_qty");
			$this->db->from("racetrack_offer");
			$query = $this->db->get()->result_array();
			return $query;
		}
		//notification
		public function notification($off_id,$userid,$usernm)
		{
			$this->db->select("userId");
			$this->db->from("racetrack_offer");
			$this->db->where("rt_offer_id",$off_id);
			$query = $this->db->get()->result_array();
			//return $query;
			$dt=Array('Noti_touserid' => $query[0]['userId'],
						'Noti_content' => $usernm." Has Booked Your Offer",
						'usernm' => $usernm, 
						'notifor' => "booked");
						
			$this->db->insert("notifications",$dt);
			return $this->db->affected_rows() > 0;
			
			
		}
		
		public function filter_offlinebooking($off)
		{
		
			 $userId=$this->session->userdata('userid');
			$this->db->select("*");
			$this->db->from("booking b");
			$this->db->join("racetrack_offer r","r.rt_offer_id=b.rt_offer_id","inner");
			$this->db->join("track t","t.track_id=r.track_id","inner");
			$this->db->where('r.offer_name like "%'.$off.'%"' );
			$this->db->where("b.userId",$userId);
			$this->db->where("b.isOfflinePayment",1);
			$this->db->order_by("b.booking_id", "desc");
		    return $this->db->get()->result_array();

		
		// $this->db->select('*');
		// $this->db->from('racetrack_offer');
		// $this->db->join('track','racetrack_offer.track_id=track.track_id');
		// $this->db->where('racetrack_offer.offer_name like "%'.$off.'%"' );
		// //$this->db->or_where('track.circuit_name like "'.$off.'%"');
		// $query = $this->db->get()->result_array();
		// return $query;
			
		}
		
		public function imgUpload($booking_id,$userid,$usernm)
		{
			$this->db->select("rt_offer_id");
			$this->db->from("booking");
			$this->db->where("booking_id",$booking_id);
			$query = $this->db->get()->result_array();
			$offer_id = $query[0]['rt_offer_id'];
			
			$this->db->select("userId");
			$this->db->from("racetrack_offer");
			$this->db->where("rt_offer_id",$offer_id);
			$query1 = $this->db->get()->result_array();
			//return $query1;
			
			$data=Array('Noti_touserid' => $query1[0]['userId'],
						'Noti_content' => $usernm." Has uploaded transaction Proof",
						'usernm' => $usernm,
						'notifor' => "uploaded");
						
			$this->db->insert("notifications",$data);
			return $this->db->affected_rows() > 0;
		}
		
		
		public function getnotification($userid,$start)
		{
			$start=(int)$start;
			$this->db->select("*");
			$this->db->from("notifications");
			$this->db->where("Noti_touserid",$userid);
			$this->db->order_by('Noti_id', 'DESC');
			 $this->db->limit('20', $start);
			 //$this->db->limit('8 ', $start);
			//$this->db->where("isread",'0');
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		
		public function getcount($userid)
		{
			$this->db->select("Noti_id");
			$this->db->from("notifications");
			
			$this->db->where("Noti_touserid",$userid);
			$this->db->where("isread","0");
			$query = $this->db->get()->result_array();
			return $query;
		}
		
		public function addread($userid)
		{
			$data=Array('isread' => "1");
			$this->db->where('Noti_touserid', $userid);
			return $this->db->update('notifications', $data);
			
		}
		
		public function addnew_compinfo($info)
		{
			$info->isCompany = "1";
			$userId=$this->session->userdata('userid');
			$this->db->where('userId', $userId);
			return $this->db->update('racetrackusers', $info);
			//$info['isCompany'] = "1";
			
			
		}
		
	}	
		?>