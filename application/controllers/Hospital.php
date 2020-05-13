<?php

class Hospital extends CI_Controller {
   public function __construct()
    {
        parent::__construct();
        if(empty($this->session->userdata('admin'))){
            redirect('AdminLogin');
          }
    }
    
    public function index(){
        $data['hospital'] = $this->HospitalModel->getAllHospital();
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('hospital/hospital_list',$data);
        $this->load->view('common/footer');   
    }

  public function add_hospital(){
    if(!empty($this->input->post()))
    {
      $this->form_validation->set_rules('hospital_name', 'Hospital Name', 'required');
      $this->form_validation->set_rules('hospital_address', 'Hospital Address', 'required');
      $this->form_validation->set_rules('hospital_service', 'Hospital Service', 'required');
      $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');

      if ($this->form_validation->run() == FALSE)
      {
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('hospital/add_hospital');
        $this->load->view('common/footer');  
      }
      else
      {
        $data = $this->input->post();
        unset($data['hospital_image']);
        $config['upload_path'] = './uploads/hospital_images';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2000;
        $config['max_width'] = 4500;
        $config['max_height'] = 4500;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('hospital_image')) 
        {
          $error = array('error' => $this->upload->display_errors());
          print_r($error);exit;
          $image = '';
        } 
        else 
        {
          $image = $this->upload->data()['file_name'];
          $data['hospital_image'] = $image;
        }

        if($this->HospitalModel->addHospital($data))
          {
            redirect('Hospital');
          }
      }

    }
    else {
      $this->load->view('common/header');
      $this->load->view('common/sidebar');
      $this->load->view('hospital/add_hospital');
      $this->load->view('common/footer');  
    }
  }

    public function edit_hospital(){
        if(!empty($this->input->post())){
            $data = $this->input->post();
            
            $id = $this->input->post('id');
            unset($data['id']);
            unset($data['hospital_image']);
            $config['upload_path'] = './uploads/hospital_images';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2000;
            $config['max_width'] = 4500;
            $config['max_height'] = 4500;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('hospital_image')) 
            {
            $error = array('error' => $this->upload->display_errors());
             
            $image = '';
            } 
            else 
            {
            $image = $this->upload->data()['file_name'];
            $data['hospital_image'] = $image;
            }

            if($this->HospitalModel->updateHospital($data,$id)){
                redirect('Hospital');
            }
           }
           else {
               $hos_id = $this->uri->segment(3);
           $data['hospital'] = $this->HospitalModel->getHospitalById($hos_id);
           $this->load->view('common/header');
           $this->load->view('common/sidebar');
           $this->load->view('hospital/edit_hospital',$data);
           $this->load->view('common/footer');  
       }  
    }

    public function delete_Hospital(){
        $id = $this->uri->segment(3);
        $this->HospitalModel->deleteHospitalById($id);
        redirect('Hospital');
    }
}