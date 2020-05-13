<?php

	class LoanApiModel extends CI_Model {
		public function __construct(){
		}

		public function loanProvide($loan){
        	$this->db->insert('Loan',$loan);
        	return true;
		}

		public function offeredLoanDetails()
		{
			$this->db->select("*");
			$this->db->from('loan_amount');
			$data = $this->db->get()->result();
			return $data;
		}

		public function getLoanByPatientId($patient_id)
    	{
	        $this->db->select("*");
	        $this->db->from('Loan');
	        $this->db->where('patient_id',$patient_id);
	        $data = $this->db->get()->result();
	        return $data;
    	}
    	public function getPaymentHistory($UserId){
    		$this->db->select("*");
			$this->db->from('loan_amount');
			$data = $this->db->get()->result();
			return $data;
    	}
	}