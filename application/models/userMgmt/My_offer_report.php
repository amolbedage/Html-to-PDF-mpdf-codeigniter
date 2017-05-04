<?php
include('application/libraries/Set_default_time_zone.php');
class My_offer_report extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
			
        }
		
		
		public function show_booker_info($user_Id){
			//echo $user_Id;
			$this->db->select("userFname,userLname,addemail,country,cell,address,userEmail");
			$this->db->from("racetrackusers");
			$this->db->where("userId",$user_Id);
			return $this->db->get()->result_array();
		}
		
		public function my_offers($data)
		{

		$my_query="select *,b.userId from booking b,track t, racetrack_offer r where b.rt_offer_id=r.rt_offer_id and r.track_id=t.track_id and r.userId=".$data;
			
			//$my_query="select * from booking b,track t, racetrack_offer r where b.rt_offer_id=r.rt_offer_id //and r.track_id=t.track_id and r.userId=.$data";
			$query = $this->db->query($my_query)->result_array();
			return $query;
		}
		public function datefilter($data,$dt)
		{
		 // $this->db->where('racetrack_offer.start_date BETWEEN DATE_FORMAT("'.$start_date.'","%Y-%m-%d") AND DATE_FORMAT("'.$end_date.'","%Y-%m-%d")');
			 $my_query="select * from booking b,track t, racetrack_offer r where b.rt_offer_id=r.rt_offer_id and r.track_id=t.track_id and b.userId=".$data." and '".$dt."' between r.start_date and r.end_date";
			$query = $this->db->query($my_query)->result_array();
			return $query;
			//echo $my_query;
		}
		public function monthfilter($dt,$id,$year,$yr)
		{
			$startstr=''.$yr.'/'.$dt.'/1';
			$endstr=''.$yr.'/'.$dt.'/31';
			$my_query="select * from booking b,track t, racetrack_offer r where b.rt_offer_id=r.rt_offer_id and r.track_id=t.track_id and r.userId=".$id." and (('".$startstr."' BETWEEN `r`.`start_date` AND `r`.`end_date` OR '".$endstr."' BETWEEN `r`.`start_date` AND `r`.`end_date`) OR (`r`.`start_date` BETWEEN '".$startstr."' AND '".$endstr."' OR `r`.`end_date` BETWEEN '".$startstr."' AND '".$endstr."'))";
			$query = $this->db->query($my_query)->result_array();
			return $query;
			//return $my_query;
		}
		
		public function view_status($id)
		{
			$my_query="SELECT booking.booking_id,racetrack_offer.offer_name,racetrack_offer.rt_currency,racetrackusers.userFname,booking.isApproved,racetrackusers.userLname,booking.grand_total,booking.Transaction_id,booking.transactionProof FROM booking, racetrack_offer,racetrackusers where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.isOfflinePayment=1 and booking.userId=racetrackusers.userId and racetrack_offer.userId=".$id;
			$query = $this->db->query($my_query)->result_array();
			return $query;
			
			
		}
		
		public function isApproved($in,$id)
		{
				$data1=array('isApproved' => 1);
				$this->db->where('booking_id',$in);
				$a=$this->db->update('booking', $data1);	
				
				$my_query="SELECT booking.booking_id,racetrackusers.compname,racetrack_offer.offer_name,racetrack_offer.rt_currency,racetrackusers.userFname,booking.isApproved,racetrackusers.userLname,booking.grand_total,booking.Transaction_id,booking.transactionProof FROM booking, racetrack_offer,racetrackusers where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.isOfflinePayment=1 and booking.userId=racetrackusers.userId and racetrack_offer.userId=".$id." and booking.booking_id=".$in;
				$my_sec_query="SELECT COUNT(*) from booking,racetrackusers,racetrack_offer where racetrackusers.userId=racetrack_offer.userId and booking.rt_offer_id=racetrack_offer.rt_offer_id and racetrackusers.userId=".$id;
				$count=$this->db->query($my_sec_query)->result_array();
				$query = $this->db->query($my_query)->result_array();
				$temp=array('mainData'=>$query[0],'totCount'=>$count[0]['COUNT(*)']);
				return $temp;
		}   
		
		 public function disapprove($getinfo,$id)
		 {
			  $this -> db -> where('booking_id', $getinfo);
				$query=$this -> db -> delete('booking');
				
				
				$my_query="SELECT booking.booking_id,racetrack_offer.offer_name,racetrack_offer.rt_currency,racetrackusers.userFname,booking.isApproved,racetrackusers.userLname,booking.grand_total,booking.Transaction_id,booking.transactionProof    FROM booking, racetrack_offer,racetrackusers where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.isOfflinePayment=1 and booking.userId=racetrackusers.userId and racetrack_offer.userId=".$id;
				$query = $this->db->query($my_query)->result_array();
				return $query;
		 }
		
		public function approvednoti($getinfo)
		{
			$this->db->select("rt_offer_id");
			$this->db->from("booking");
			$this->db->where("booking_id",$getinfo);
			$query = $this->db->get()->result_array();
			$offer_id = $query[0]['rt_offer_id'];
			
			$this->db->select("offer_name");
			$this->db->from("racetrack_offer");
			$this->db->where("rt_offer_id",$offer_id);
			$query1 = $this->db->get()->result_array();
			$off_nm = $query1[0]['offer_name'];
			//return $query1[0]['offer_name'];
			
			$this->db->select("userId");
			$this->db->from("booking");
			$this->db->where("booking_id",$getinfo);
			$query2 = $this->db->get()->result_array();
			$userid = $query2[0]['userId'];
			//return $query;
			
			$dat=Array('Noti_touserid' => $userid,
						'Noti_content' => $off_nm." Has been approved",
						'notifor' => "approved");
						
			$this->db->insert("notifications",$dat);
			return $this->db->affected_rows() > 0;
			
		}
		
		public function search_user($getinfo,$id)
		{
			
			$my_query="SELECT booking.booking_id,racetrack_offer.offer_name,racetrack_offer.rt_currency,racetrackusers.userFname,booking.isApproved,racetrackusers.userLname,booking.grand_total,booking.Transaction_id,booking.transactionProof FROM booking, racetrack_offer,racetrackusers where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.isOfflinePayment=1 and booking.userId=racetrackusers.userId and racetrack_offer.userId='".$id."' and racetrack_offer.offer_name like'".$getinfo."%'";
			// $my_query="SELECT booking.booking_id,racetrack_offer.offer_name,racetrack_offer.rt_currency,racetrackusers.userFname,booking.isApproved,racetrackusers.userLname,booking.grand_total,booking.Transaction_id,booking.transactionProof FROM booking, racetrack_offer,racetrackusers where booking.rt_offer_id=racetrack_offer.rt_offer_id AND booking.isOfflinePayment=1 and booking.userId=racetrackusers.userId and racetrack_offer.userId='".$id."' and racetrack_offer.offer_name like'".$getinfo."%'";
			$query = $this->db->query($my_query)->result_array();
			return $query;
			
		}
		
		public function getid($getinfo)
		{
			$this->db->select("userId");
			$this->db->from("booking");
			$this->db->where("booking_id",$getinfo);
			$query = $this->db->get()->result_array();
			$uid=$query[0]['userId'];
			
			
			$this->db->select("*");
			$this->db->from("racetrackusers");
			$this->db->where("userId",$uid);
			$query2 = $this->db->get()->result_array();
			return $query2;
			
			
		}
		
	}	
		?>