<?php
include('application/libraries/Set_default_time_zone.php');
class UserAuth extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				
				
        }
	
		
		public function changePass($oldp,$newp,$id)
		{
			$this->db->select('userPassword');
			$this->db->from('racetrackusers');
			$this->db->where('userId',$id);
			$data=$this ->db->get()->result_array()[0]['userPassword'];
			if($data!=$oldp)
			{
			return "Not Match";
			}
			else
			{
			$getinfo=array("userPassword"=>$newp);
			//$this->db->select('userPassword');
			$this->db->from('racetrackusers');
			$this->db->where('userId',$id);
			$this->db->update('racetrackusers', $getinfo);
			return "Match";
			}
			
		}
		public function userlogin($usernm,$userpass)
		{
			$this->db->select('*');
			$this->db->from('racetrackusers');
			$this -> db -> where('userEmail', $usernm);
			$this -> db -> where('userPassword', $userpass);

			$query = $this -> db -> get();

			if($query -> num_rows()> 0 )
			{
			return $query->result();
			}	
		}
		
		public function checkuserverification($usernm,$userpass)
		{
			$this->db->select('*');
			$this->db->from('racetrackusers');
			$this -> db -> where('userEmail', $usernm);
			$this -> db -> where('userPassword', $userpass);
			$query = $this -> db -> get();
			if($query -> num_rows()> 0 )
			{
			return $query->result();
			}
		}
		
		public function validateEmail($email)
		{
			$this->db->select('*');
			$this->db->from('racetrackusers');
			$this -> db -> where('userEmail', $email);
			$query = $this -> db -> get();
			if($query -> num_rows()> 0 )
			{
			return true;
			}
			else
			{
			return false;
			}
		}
		public function check_verify_account($email)
		{
			$this->db->select('userVerification');
			$this->db->from('racetrackusers');
			$this -> db -> where('userEmail',$email);
			return $this ->db->get()->result_array();
			
		}
		
		}
		?>