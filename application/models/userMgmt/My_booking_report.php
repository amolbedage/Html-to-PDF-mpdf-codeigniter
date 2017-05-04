<?php
include('application/libraries/Set_default_time_zone.php');
class My_booking_report extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
			
        }
		
		public function my_bookings($data)
		{

			$my_query="select * from booking b,track t, racetrack_offer r where b.rt_offer_id=r.rt_offer_id and r.track_id=t.track_id and b.userId=".$data." and b.isOfflinePayment=0";
			$query = $this->db->query($my_query)->result_array();
			return $query;
		}

		public function datefilter($data,$dt)
		{
			 $my_query="select * from booking b,track t, racetrack_offer r where b.rt_offer_id=r.rt_offer_id and r.track_id=t.track_id and b.userId=".$data." and '".$dt."' between r.start_date and r.end_date and b.isOfflinePayment=0";
			$query = $this->db->query($my_query)->result_array();
			return $query;
			//echo $my_query;
		}
		
		public function filtermonthyear($dt,$id,$year,$yr)
		{
		
			$startstr=''.$yr.'/'.$dt.'/1';
			$endstr=''.$yr.'/'.$dt.'/31';
			$my_query="select * from booking b,track t, racetrack_offer r where b.rt_offer_id=r.rt_offer_id and r.track_id=t.track_id and b.userId=".$id." and b.isOfflinePayment=0 and (('".$startstr."' BETWEEN `r`.`start_date` AND `r`.`end_date` OR '".$endstr."' BETWEEN `r`.`start_date` AND `r`.`end_date`) OR (`r`.`start_date` BETWEEN '".$startstr."' AND '".$endstr."' OR `r`.`end_date` BETWEEN '".$startstr."' AND '".$endstr."'))";
			$query = $this->db->query($my_query)->result_array();
			return $query;
			//return $my_query;
		}

}	
		?>