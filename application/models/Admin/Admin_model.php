<?php
include('application/libraries/Set_default_time_zone.php');
class Admin_model extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();		
				
        }
		
		public function view_user()
		{
			$this->db->select('*');
			$this->db->from('racetrackusers');
			$this->db->where('userRole','user');
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		public function view_offer()
		{
			
			$this->db->select('*');
			$this->db->from('racetrack_offer');
			$this->db->join('track','racetrack_offer.track_id=track.track_id');
			$this->db->order_by('rt_offer_id', 'DESC');
			$this->db->where('racetrack_offer.end_date >=',date('Y-m-d'));
			$this->db->limit('8');
			$query = $this->db->get()->result_array();
			return $query;
		}
		public function view_offer_admin()
		{
			$this->db->select('*');
			$this->db->from('racetrack_offer');
			$this->db->join('track','racetrack_offer.track_id=track.track_id');
			$query = $this->db->get()->result_array();
			return $query;
		}
		public function delete_offer($getinfo)
		{
			
			$this->db->where('rt_offer_id', $getinfo);
			 $this->db->delete('racetrack_offer');
			 
			 $this->db->select('*');
			$this->db->from('racetrack_offer');
			$this->db->join('track','racetrack_offer.track_id=track.track_id');
			$query = $this->db->get()->result_array();
			return $query;
		}
		 public function get_userid($getinfo)
		 {
			 $this->db->select('userId');
			 $this->db->from('racetrack_offer');
			 $this->db->where('rt_offer_id',$getinfo);
			 $query = $this->db->get()->result_array();
			return $query;
		 }
		public function get_useremail($userid)
		 {
			$this->db->select('userEmail');
			 $this->db->from('racetrackusers');
			 $this->db->where('userId',$userid);
			 $query = $this->db->get()->result_array();
			return $query;
			
		}
		// public function save_reason($reason)
		// {
			
		// }
		public function ban_user($getinfo)
		{
			$getinfo=$_GET['info'];
			$data=$this->db->select('userId')->from('racetrack_offer')->where('userId',$getinfo)->get()->result();
			 if(empty($data))
			 {
				$data1=Array('baned_user' => '1');
				$this->db->where('userId',$getinfo);
				$this->db->update('racetrackusers', $data1);
				
				$this->db->select('*');
				$this->db->from('racetrackusers');
				$this->db->where('userRole','user');
				$query = $this->db->get()->result_array();
				return $query;
			}
			else
			{
				return "user created track!!!";
			}
		}
		public function active_user($getinfo)
		{
			$data=Array('baned_user' => '0');
			$this->db->where('userId',$getinfo);
			return $this->db->update('racetrackusers', $data);
		}
		
		public function search_user($getinfo)
		{
			$this->db->select('*');
			$this->db->from('racetrackusers');
			$this->db->where('userFname like "%'.$getinfo.'%"' );
			$this->db->or_where('userLname like "%'.$getinfo.'%"' );
			$this->db->or_where('userEmail like "%'.$getinfo.'%"' );
			$query = $this->db->get()->result_array();
			return $query;
		}
		public function search_offer1($getinfo)
		{
			$this->db->select('*');
			$this->db->from('racetrack_offer');
			$this->db->join('track','racetrack_offer.track_id=track.track_id');
			$this->db->where('offer_name like "%'.$getinfo.'%"' );
			$this->db->or_where('City like "%'.$getinfo.'%"' );
			$this->db->or_where('Country like "%'.$getinfo.'%"' );
			$this->db->or_where('circuit_name like "%'.$getinfo.'%"' );
			$query = $this->db->get()->result_array();
			return $query;	
		}
		public function all_bookings()
		{
			$this->db->select('*');
			$this->db->from('booking b,racetrack_offer r,track t');
			$this->db->where('b.rt_offer_id=r.rt_offer_id AND r.track_id=t.track_id' );
			$query = $this->db->get()->result_array();
			return $query;	
		}
		
		public function datefil($getinfo)
		{
			
			$query = $this->db->query("SELECT * FROM booking b,track t,racetrack_offer r WHERE b.rt_offer_id=r.rt_offer_id AND r.track_id=t.track_id AND \"$getinfo\" BETWEEN r.start_date AND r.end_date")->result_array();
			
			return $query;	
		}
		// public function selectedItemChanged($getinfo)
		// {
			
			// $query = $this->db->query("SELECT * FROM booking b,track t,racetrack_offer r WHERE b.rt_offer_id=r.rt_offer_id AND r.track_id=t.track_id AND extract(MONTH from start_date) =". $getinfo)->result_array();
			
			// return $query;	
		// }
		
		// public function selectedyearChanged($getinfo)
		// {
			
			// $query = $this->db->query("SELECT * FROM booking b,track t,racetrack_offer r WHERE b.rt_offer_id=r.rt_offer_id AND r.track_id=t.track_id AND extract(YEAR from start_date) =". $getinfo)->result_array();
			
			// return $query;	
		// }
		
		public function filmonthyear($dt,$id,$year,$yr)
		{
			$startstr=''.$yr.'/'.$dt.'/1';
			$endstr=''.$yr.'/'.$dt.'/31';
			$my_query="select * from booking b,track t, racetrack_offer r where b.rt_offer_id=r.rt_offer_id and r.track_id=t.track_id and (('".$startstr."' BETWEEN `r`.`start_date` AND `r`.`end_date` OR '".$endstr."' BETWEEN `r`.`start_date` AND `r`.`end_date`) OR (`r`.`start_date` BETWEEN '".$startstr."' AND '".$endstr."' OR `r`.`end_date` BETWEEN '".$startstr."' AND '".$endstr."'))";
			$query = $this->db->query($my_query)->result_array();
			return $query;
			//return $my_query;
		}
		
		//total Booking Per Person
		// public function totalBooking()
		// {
			// $this->db->select('userId');
			// $this->db->from('racetrack_offer');
			// $query = $this->db->get()->result_array();
			// return $query;
			// // $this->db->select('userId');
			// // $this->db->from('offerbooking');
			// // return $uid = $this->db->get()->result_array();
			// // //return $uid[0]['userId'];
			
				
		// }
		
		// public function get_nm($unm)
		// {
			// $this->db->select('userFname');
			// $this->db->from('racetrackusers');
			// $this->db->where('userId',$unm);
			// $query = $this->db->get()->result_array();
			// return $query;	
			
		// }
		// public function update_nm($u_nm,$tuid)
		// {
			//return $u_nm;
		// $data = array('username' => $u_nm[0]['userFname']);
		// $this->db->where('userId',$tuid);
		// return $this->db->update('offerbooking', $data);
			
		// }
		
		public function updateStatusForBooking($tr,$bik,$imgname)
		{
		$trdata=array(
		'status_transaction'=>$tr,
		'status'=>1,
		'status_img'=>$imgname
		);
		$im='';
		$query='';
		if($imgname)
		{
		$im=$imgname;
			$query='UPDATE booking,racetrack_offer set booking.status = 1,booking.status_transaction='.$tr.',booking.status_img='.$im.' where racetrack_offer.userId='.$bik.' and booking.status=0';
		}
		else
		{
			$query='UPDATE booking,racetrack_offer set booking.status = 1,booking.status_transaction='.$tr.' where racetrack_offer.userId='.$bik.' and booking.status=0';
		}
		//return $query;
		//$this->db->where('rt_offer_id="'.$bik.'" and status=0');
		//return $this->db->update('booking', $trdata);
		return $this->db->query($query);
		//return $bik;
		}
		
		
		public function save_pass_admin($getinfo,$id)
		{
			$data=Array('userPassword' => $getinfo);
			$this->db->where('userId', $id);
			return $this->db->update('racetrackusers', $data);
	
		}
		
		public function chk_pass_ad($getinfo,$id)
		{
			$this->db->select("*");
			$this->db->from("racetrackusers");
			$this->db->where('userPassword',$getinfo);
			$this->db->where('userId',$id);
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		
			
	
	}	
		?>