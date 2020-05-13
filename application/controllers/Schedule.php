<?php

class Schedule extends CI_Controller {
   public function __construct()
    {
        parent::__construct();
        if(empty($this->session->userdata('admin'))){
            redirect('AdminLogin');
          }
    }
    
    public function index()
    {
      $data['schedule']=$this->ScheduleModel->getAllSchedule();
      $this->load->view('common/header');
      $this->load->view('common/sidebar');
      $this->load->view('schedule/schedule_list',$data);
      $this->load->view('common/footer');   
    }

    public function add_schedule()
    {
      if(!empty($this->input->post()))
      {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('doctor_id', 'Doctor Id', 'required');
        $this->form_validation->set_rules('available[]', 'available', 'required');
        $this->form_validation->set_rules('department_id', 'Department', 'required');
        // $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        // $this->form_validation->set_rules('end_time', 'End time', 'required');
         $this->form_validation->set_rules('status', 'status', 'required');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');


        if ($this->form_validation->run() == FALSE)
        {
         $data['doctors']=$this->ScheduleModel->getDoctors();
         $data['Department']=$this->ScheduleModel->getDepartment();

        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('schedule/add_schedule',$data);
        $this->load->view('common/footer');    
        }
        else 
        {

          $count = 0;
          $data = $this->input->post();
           // echo '<pre>';
           // print_r($data);exit;
          



          $data['available'] = json_encode($data['available']);
          if($this->ScheduleModel->AddSchedule($data)){
         redirect('Schedule');
         }
        
      }
    
  }
  else {
        $data['doctors']=$this->ScheduleModel->getDoctors();
        $data['Department']=$this->ScheduleModel->getDepartment();

        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('schedule/add_schedule',$data);
        $this->load->view('common/footer');  
        }
}

    public function edit_schedule(){
      if(!empty($this->input->post())){
        $data = $this->input->post();
        $id = $this->input->post('id');
        if($this->ScheduleModel->updateSchedule($data,$id)){
          redirect('Schedule');
        }
          
      }else {
        $data['doctors']=$this->ScheduleModel->getDoctors();
        $data['Department']=$this->ScheduleModel->getDepartment();
        
        $sch_id = $this->uri->segment(3);
       
        $data['Schedule'] = $this->ScheduleModel->getScheduleById($sch_id);
        
        $data['department'] = $this->ScheduleModel->getDepartment($sch_id);
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('schedule/edit_schedule',$data);
        $this->load->view('common/footer');  
      }
    }

    public function delete_schedule(){
        $id = $this->uri->segment(3);
        $this->ScheduleModel->deleteScheduleById($id);
        redirect('Schedule');
    }
   
}