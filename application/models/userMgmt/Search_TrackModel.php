<?php
include('application/libraries/Set_default_time_zone.php');
class Search_TrackModel extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
			
        }
		
		public function get_search_track_data($min_lat,$min_lng,$max_lat,$max_lng,$start_date,$end_date,$Gocart,$Car,$RaceCar,$Motobike,$Touring,$Formula,$GTCar,$Streetlegal)
		{
		
		$my_query="select * from `track` `t`,`racetrack_offer` `r` where `t`.`Latitude` BETWEEN ".$min_lat." AND ".$max_lat." AND `t`.`Longitude` BETWEEN ".$min_lng." AND ".$max_lng." AND `r`.`track_id`=`t`.`track_id`";
		
		// select * from `track` `t`,`racetrack_offer` `r` where `t`.`Latitude` BETWEEN $min_lat AND $max_lat AND `t`.`Longitude` BETWEEN 73.50518119999992 AND 74.20830619999992 AND `r`.`track_id`=`t`.`track_id` AND (`r`.`start_date` BETWEEN '2016/12/12' AND '2016/12/18' OR `r`.`end_date` BETWEEN '2016/12/12' AND '2016/12/18')
		
		
		 // echo $min_lat.$min_lng.$max_lag.$max_lng; 78.96617888007313
		 //$min_lat=
		 // $this->db->select('*');
		// $this->db->from('track');
		// $this->db->where('track.Latitude BETWEEN '.(double)$min_lat.' AND '.(double)$max_lat);
		// $this->db->where('track.Longitude BETWEEN '.(double)$min_lng.' AND '.(double)$max_lng);
		// $this->db->join('racetrack_offer', 'track.track_id = racetrack_offer.track_id','inner');
	
if(($Gocart!=2) || ($Car!=2) || ($RaceCar!=2) || ($Motobike!=2) || ($Touring!=2) || ($Formula!=2)
|| ($GTCar!=2) || ($Streetlegal!=2)){

	$my_query.="AND(";
	
	  
			$my_query.="(`r`.`isgokart`=".$Gocart.")";
	
			
		
			$my_query.=" OR (`r`.`iscar`=".$Car.")";
			
	
			$my_query.=" OR (`r`.`isracecar`=".$RaceCar .")";
		
	
				$my_query.=" OR (`r`.`ismotorbike`=".$Motobike .")";
	
		
				$my_query.=" OR (`r`.`istouring`=".$Touring .")";
		
		
				$my_query.=" OR( `r`.`isformula`=".$Formula.")";
		
		
				$my_query.=" OR (`r`.`isgtcar`=".$GTCar.")";
		
		
    		$my_query.=" OR (`r`.`isstreet`=".$Streetlegal.")";

		
	$my_query.=")";
}
		
		if(!empty($start_date) && !empty($end_date)){
			$my_query.=" AND ((`r`.`start_date` BETWEEN '".$start_date."' AND '".$end_date."' OR `r`.`end_date` BETWEEN '".$start_date."' AND '".$end_date."') OR ('".$start_date."' BETWEEN `r`.`start_date` AND `r`.`end_date` OR '".$end_date."' BETWEEN `r`.`start_date` AND `r`.`end_date`))";
		}
		
		//echo $my_query;
		$query = $this->db->query($my_query)->result_array();
		return $query;
		}
		
		
		
	
	}	
		?>