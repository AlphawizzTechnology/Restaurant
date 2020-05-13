<?php  

class Loan extends CI_Controller {
     public function __construct()
    {
        parent::__construct();
        if(empty($this->session->userdata('admin'))){
            redirect('AdminLogin');
          }
    }
    
    public function index()
    {
        $data['loan'] = $this->LoanModel->getAllLoanDetail();
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('loan/loan_list',$data);
        $this->load->view('common/footer');   
    }

    public function Status()
    {
        $loan_id = $this->uri->segment(3);
        $status_id = $this->uri->segment(4);
        $this->db->where('id',$loan_id);
        $this->db->update('Loan',array('status'=>$status_id));
        redirect('Loan');
    }


    public function setLoanAmount(){
        if(!empty($this->input->post()))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('loan_amount','Loan Amount','required|numeric');
            $this->form_validation->set_rules('loan_intrest','Loan Intrest','required|numeric');
            $this->form_validation->set_rules('weekly_payment','Weekly Payment','required|numeric');

            $this->form_validation->set_error_delimiters('<div class=" mt-2 alert alert-danger">','</div>');

            if($this->form_validation->run() == false)
            {
                $this->load->view('common/header');
                $this->load->view('common/sidebar');
                $this->load->view('loan/loan_add');
                $this->load->view('common/footer');   
            }
            else
            {
                $data = $this->input->post();
                if($this->LoanModel->saveLoanAmount($data))
                {
                    $this->session->set_flashdata('loan_result','Loan Amount added successfully');
                    $this->session->set_flashdata('loan_result_class','alert alert-success');
                }
                else
                {
                    $this->session->set_flashdata('loan_result','Unable to add Amount');
                    $this->session->set_flashdata('loan_result_class','alert alert-danger');
                }

                $this->load->view('common/header');
                $this->load->view('common/sidebar');
                $this->load->view('loan/loan_add');
                $this->load->view('common/footer'); 
            }

        }
        else
        {
            $this->load->view('common/header');
            $this->load->view('common/sidebar');
            $this->load->view('loan/loan_add');
            $this->load->view('common/footer');       
        }
        
    }
}