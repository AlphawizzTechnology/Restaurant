<?php

class Department extends CI_Controller {
     public function __construct()
    {
        parent::__construct();
        if(empty($this->session->userdata('admin'))){
            redirect('AdminLogin');
          }
    }

    
    public function index(){
        $data['departments'] = $this->DepartmentModel->getAllDepartments();
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('department/department_list',$data);
        $this->load->view('common/footer');   
    }

    public function add_department(){
        if(!empty($this->input->post())){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('department_name', 'Department name', 'required');
            $this->form_validation->set_rules('description', 'Department description', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
            
            

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('common/header');
                $this->load->view('common/sidebar');
                $this->load->view('department/add_department');
                $this->load->view('common/footer'); 
            }
            else {
                $data = $this->input->post();
             if($this->DepartmentModel->addDepartment($data)){
                 redirect('department');
             }
            }
        }
        else {
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('department/add_department');
        $this->load->view('common/footer');  
    }
    }

    public function edit_department(){
        if(!empty($this->input->post())){
         $data = $this->input->post();
         $id = $this->input->post('id');
         unset($data['id']);

         if($this->DepartmentModel->editDepartment($data,$id)){
             redirect('department');
         }
        }
        else {
            $doctor_id = $this->uri->segment(3);
        $data['department_data'] = $this->DepartmentModel->getDepartmentById($doctor_id);
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('department/edit_department',$data);
        $this->load->view('common/footer');  
     }
    }

    public function delete_department(){
        $id = $this->uri->segment(3);
        $data['Doctor_data'] = $this->DepartmentModel->deleteDepartmentById($id);
        redirect('department');
    }
}