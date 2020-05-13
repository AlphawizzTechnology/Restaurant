<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Hospital extends REST_Controller {
    public function __construct() { 
    	 
        parent::__construct();
        
        // Load the user model
         $this->load->model('Api/HospitalApiModel');
        
    }


    public function getFreeHospitals_get()
    {
    	$data = $this->HospitalApiModel->getHospitalList();

		if(!empty($data))
		{
			$this->response([
			'status' => TRUE,
			'message' => 'Free hospital list',
			'Doctors'=>$data
			], REST_Controller::HTTP_OK);
		}
		
		else 
		{
			$this->response([
			'status' => FALSE,
			'message' => 'Free Hospitals Not available'
			], REST_Controller::HTTP_OK);
		}
    }


}    
