<?php

class AdminDashboard extends CI_Controller {

    // public function __construct(){
    //     parent::__construct();
    //     if(!$this->login->isLoggedIn()){
    //      redirect('AdminLogin');
    //     }
    // }
    public function index(){
        if(empty($this->session->userdata('admin'))){
            redirect('AdminLogin');
          }
        $data['dc'] =  $this->DashboardModel->getAllDoctorCount();
        $data['pc'] =  $this->DashboardModel->getAllPatientsCount();
        $data['apc'] = $this->DashboardModel->getAttendPatientCount();
        $data['ppc'] = $this->DashboardModel->getPendingPatientCount();
        $data['doc'] = $this->DashboardModel->getAllDoctor();
        $data['App'] = $this->DashboardModel->getLatestAppoinment();
        $data['pat'] = $this->DashboardModel->getPatients();
        
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('dashboard/dashboard_view',$data);
        $this->load->view('common/footer');
    }
    
    public function AdminProfile(){
       
        $id = $this->session->userdata('admin')[0]->id;
        $data['admin'] = $this->AdminLoginModel->getAdminProfile($id);
        
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('admin/admin_profile',$data);
        $this->load->view('common/footer');  
    }

    public function Setting(){
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('admin/admin_setting');
        $this->load->view('common/footer');
    }

    public function EditProfile(){
       if(!empty($this->input->post())){
          $admin = $this->input->post();
             $id = $admin['id'];
             $config['upload_path'] = './uploads/admin_profiles';
             $config['allowed_types'] = 'gif|jpg|png|jpeg';
             $config['max_size'] = 2000;
             $config['max_width'] = 4500;
             $config['max_height'] = 4500;

            $this->load->library('upload', $config);
            if(empty($admin['dob'])){
                unset($admin['dob']);
            }
            if (!$this->upload->do_upload('admin_image')) {
                $error = array('error' => $this->upload->display_errors());
                
            } else {
                $image = $this->upload->data()['file_name'];
                $admin['image'] = $image;
            }

            if($this->AdminLoginModel->updateAdmin($admin,$id)){
                redirect('AdminDashboard/AdminProfile');
              }
            
       }
       else {
        $id = $this->session->userdata('admin')[0]->id;
        $data['Admin_data'] = $this->AdminLoginModel->getAdminProfile($id);
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('admin/admin_edit_profile',$data);
        $this->load->view('common/footer');
    }   
    }

    public function changePassword(){
        $this->form_validation->set_rules('old_password','Old Password','required');
        $this->form_validation->set_rules('new_password','New Password','required');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[new_password]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
        if($this->form_validation->run() == TRUE){
        	$old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $id = $this->session->userdata('admin')[0]->id;
          
        if($this->AdminLoginModel->checkOldPassword($old_password,$id)){
        	if($this->AdminLoginModel->updatePassword($new_password,$id)){
        		$this->session->set_flashdata('success','Password changed succesfully');
        		redirect('AdminDashboard/Setting');
         }
          }
        else {
        	$this->session->set_flashdata('error','Old password are incorrect');
        	redirect('AdminDashboard/Setting');
         }
       
        }
        else {
            $this->load->view('common/header');
            $this->load->view('common/sidebar');
            $this->load->view('admin/admin_setting');
            $this->load->view('common/footer');
        }

    }


    public function Approve(){
    $id = $this->uri->segment(3);
    $this->DashboardModel->approveAppointment($id);
    redirect('AdminDashboard');
    }
}