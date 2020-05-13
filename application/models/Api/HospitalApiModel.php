<?php
class HospitalApiModel extends CI_Model 
{
	public function __construct()
	{
		$this->response= array();
		$this->message = array();
	}


	public function getHospitalList(){
		$this->db->select("*");
		$this->db->from('Hospital');
		$hospital = $this->db->get()->result();
		

		return $hospital;
	}

}  