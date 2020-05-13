<?php

class Appointment extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if(empty($this->session->userdata('admin'))){
            redirect('AdminLogin');
          }
    }

    public function index(){
        $data['Appointments'] = $this->AppointmentModel->getAllAppointment();
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('appointment/appointment_list',$data);
        $this->load->view('common/footer');   
    }

    public function add_appointment(){
        
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('appointment/add_appointment');
        $this->load->view('common/footer');  
    }

    public function edit_appointment(){
        if(!empty($this->input->post())){
         $dept_id = $this->input->post('appointment_id');
         
         $dept_data = $this->input->post();
         unset($dept_data['appointment_id']);

         if($this->AppointmentModel->updateAppointment($dept_data,$dept_id)){
          redirect('Appointment');
         }
         
       
        }
        else { 
            $data['doctors'] = $this->AppointmentModel->getDoctorsName();
            $data['patients'] = $this->AppointmentModel->getPatientsName();
            $data['departments'] = $this->AppointmentModel->getDepartmentName();
            $id = $this->uri->segment(3);
            $data['App'] = $this->AppointmentModel->getAppointmentById($id);
            
            
            $this->load->view('common/header');
            $this->load->view('common/sidebar');
            $this->load->view('appointment/edit_appointment',$data);
            $this->load->view('common/footer');  
    }
    }


    public function Status(){
        $appointment_id = $this->uri->segment(3);
        $status_id = $this->uri->segment(4);

        $this->db->where('appointment_id',$appointment_id);
        $this->db->update('Appointment',array('status'=>$status_id));
        
        redirect('Appointment');

    }

    public function delete_appointment(){
        $id = $this->uri->segment(3);
        $data['Doctor_data'] = $this->AppointmentModel->deleteAppointmentById($id);
        redirect('Appointment');
    }
    

}