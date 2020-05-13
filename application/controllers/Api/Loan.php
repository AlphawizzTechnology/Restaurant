<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Loan extends REST_Controller {

    public function __construct() { 
    	 
        parent::__construct();
        
        // Load the user model
          $this->load->model('Api/LoanApiModel');
        
    }

    public function ProvideLoan_post()
    {	

    	$patient_name = strip_tags($this->post('patient_name'));
        $patient_id = strip_tags($this->post('patient_id'));
    	$phone_number = strip_tags($this->post('phone_number'));
    	$loan_amount = strip_tags($this->post('loan_amount'));
        $loan_interest = strip_tags($this->post('loan_interest'));
    	$from = strip_tags($this->post('from'));
    	$to = strip_tags($this->post('to'));
    	// $status = strip_tags($this->post('status'));
         
        $date = strtotime($from); 
        $from_in_date_formate = date('Y-m-d h:i:s', $date); 

        $date = strtotime($to); 
        $to_in_date_formate = date('Y-m-d h:i:s', $date); 

    	$loan_detail = array('patient_name'=>$patient_name,'phone_number'=>$phone_number,
    		'loan_amount'=>$loan_amount,'from'=>$from_in_date_formate,'to'=>$to_in_date_formate,'patient_id'=>$patient_id,'loan_interest'=>$loan_interest);
        
    	if($this->LoanApiModel->loanProvide($loan_detail))
        {

    		$this->response([
	        'status' => TRUE,
	        'message' => 'Loan Applied successfully'
	      ], REST_Controller::HTTP_OK);
    	}  
    }


    public function LoanOptions_get()
    {
        $data = $this->LoanApiModel->offeredLoanDetails();
        for($i=0;$i<count($data);$i++)
        {
            $data[$i]->interest_pay = round(($data[$i]->loan_amount/100)*$data[$i]->loan_intrest);
        }
        if(!empty($data))
        {
            $this->response([
            'status' => TRUE,
            'message' => 'Loan Amount Detail',
            'data' =>$data
            ], REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response([
            'status' => FALSE,
            'message' => 'Loan Amount Detail not found'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function getLoanByUser_post()
    {
        $patient_id = strip_tags($this->post('patient_id'));
        $data = $this->LoanApiModel->getLoanByPatientId($patient_id);
        
        if(!empty($data))
        {
            $this->response([
            'status' => TRUE,
            'message' => 'Your Loan Listing',
            'data' =>$data
            ], REST_Controller::HTTP_OK);
        }

        else
        {
            $this->response([
            'status' => FALSE,
            'message' => 'Loan Detail not found'
            ], REST_Controller::HTTP_OK);
        }

    }


    public function getLoanByLoanId_post()
    {
        $loan_id = strip_tags($this->post('loan_id'));
         $data = $this->LoanApiModel->getLoanAmountByLoanId($patient_id);
        
    }
}