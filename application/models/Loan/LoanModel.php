<?php

class LoanModel extends CI_Model {
    public function getAllLoanDetail()
    {
        $this->db->select('*');
        $this->db->from('Loan');
        $this->db->order_by('id','asc');
        // $this->db->join('Patients','Patients.id = Loan.patient_id','left');
        return $this->db->get()->result();
    }


    public function saveLoanAmount($data)
    {
    	if($this->db->insert('loan_amount',$data))
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }


    


   
}