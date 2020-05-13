<?php

class Doctor extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
       
         if(!$this->login->isLoggedIn())
         {
            redirect('AdminLogin');
         }
    }
       
    
    public function index()
    {
        $data['doctors'] = $this->DoctorModel->getAllRestaurant();
        
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('doctor/doctor_list',$data);
        $this->load->view('common/footer');   
    }

    public function add_restaurant(){   
        if(!empty($this->input->post()))
        {

            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Restaurant Name', 'required');
            
            if ($this->form_validation->run() == TRUE)
            {

                $config['upload_path'] = './uploads';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2000;
                $config['max_width'] = 4500;
                $config['max_height'] = 4500;
       


                $this->load->library('upload', $config);
        
                if (!$this->upload->do_upload('profile_image')) 
                {
                   $error = array('error' => $this->upload->display_errors());
                   $image = '';
            
           
                 } 
                 else 
                 {
                   $image = $this->upload->data()['file_name'];
                 }
                    $d = $this->input->post();
         
        $doctor_data = array('name'=>$d['name'],'image'=>$image);
        
        if($this->DoctorModel->AddRestaurant($doctor_data)){
            $this->session->set_flashdata('docter_add_result','Restaurant Added Successfully');
        }
       
       redirect('Doctor');
        
            }
            else {
              $data['department'] = $this->DoctorModel->departments();
                  $data['hospital'] = $this->DoctorModel->hospital_list();
                $this->load->view('common/header');
                $this->load->view('common/sidebar');
                $this->load->view('doctor/add_doctor',$data);
                $this->load->view('common/footer');  
            }
           
        }
        else {
         $data['department'] = $this->DoctorModel->departments();
         $data['hospital'] = $this->DoctorModel->hospital_list();
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('doctor/add_doctor',$data);
        $this->load->view('common/footer');  
    }
    }

    public function edit_restaurant(){

        if(!empty($this->input->post())){
            $d = $this->input->post();
            
            $id = $d['id'];
              
             $config['upload_path'] = './uploads';
             $config['allowed_types'] = 'gif|jpg|png|jpeg';
             $config['max_size'] = 2000;
             $config['max_width'] = 4500;
             $config['max_height'] = 4500;
    

          

            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $image = '';
                
                
            } else {
                $image = $this->upload->data()['file_name'];
                $d['image'] = $image;
            }
            
            if($this->DoctorModel->updateRestaurant($d,$id)){
              redirect('Doctor');
            }
           



        }
        else {
        $doctor_id = $this->uri->segment(3);
        $data['Doctor_data'] = $this->DoctorModel->getDocterById($doctor_id);
        $data['department'] = $this->DoctorModel->departments();
         $data['hospital'] = $this->DoctorModel->hospital_list();
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('doctor/edit_doctor',$data);
        $this->load->view('common/footer');  
        }
    }
    
    public function doctors_profile(){
        $doctor_id = $this->uri->segment(3);
        $data['Doctor_profile'] = $this->DoctorModel->getDocterById($doctor_id);
        
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('doctor/doctor_profile',$data);
        $this->load->view('common/footer');  
    }

    public function delete_Restaurant(){
        $id = $this->uri->segment(3);
        $data['Doctor_data'] = $this->DoctorModel->deleteDocterById($id);
        redirect('Doctor');
    }

    public function CheckEmail(){
        $email = $this->input->post('email');
        if($this->DoctorModel->isEmailAvailable($email)){
           echo TRUE;
        }
        else {
           echo FALSE;
        }
    }
}