<?php

class AdminLogin extends CI_Controller{
    // public function __construct(){
    //     parent::__construct();
    //     // if($this->login->isLoggedIn()){
    //      redirect('AdminDashboard');
    //     }
       
    // }
    public function index(){
        if(!empty($this->session->userdata('admin'))){
          redirect('AdminDashboard');
        }
        else {
         $this->load->view('login/admin_login');
    }
    }

    public function Login(){
        $data = $this->input->post();

        if($this->AdminLoginModel->CheckAdmin($data)){
            redirect('AdminDashboard');
        }
        else {
            $this->session->set_flashdata('admin_login_result','Incorrect password');
            redirect('AdminLogin');
        }
    }

    public function Logout(){
        $this->session->unset_userdata('admin');
        redirect('AdminLogin');
    }

    public function ForgetPassword(){
        if($this->input->post()){
            $email = $this->input->post('email');
            $password = rand(10000,100000000);
            $admin_info = $this->AdminLoginModel->checkEmailAvailable($email);
            if($admin_info['status']){
                $this->load->config('email');
                $this->load->library('email');
                $from = $this->config->item('smtp_user');
                $to = $email;

                $subject   =  'Reset Password';
                $message   =  '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>';
                $message  .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>';
                $message  .=  '<div class="container">';
                $message  .=  '<div class="container">';
                $message  .=  '<div class="jumbotron text-center">';
                $message  .=  '<h1>Hii, '.$admin_info['first_name'].'</h1>';
                $message  .=  '<p class="content">You Recently Requested to reset password for your doctor admin account </br> we reset your password and your new password for username '.$admin_info['username'].' is '.$password;
                $message .= '</div>';
                $message .= '</div>';
                
                // $message = 'For your Username '.$admin_info['data']['username'].' Your New Password is '.$password;        
                $this->email->set_header('Content-type', 'text/html');
                $this->email->set_newline("\r\n");
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);
        
                if ($this->email->send()) 
                { 
                    $this->AdminLoginModel->changePassword($password,$email);
                    $this->session->set_flashdata('result_success_forget_password','Your password send in email.');
                    redirect('AdminLogin/ForgetPassword');
                } 
                else 
                {
                     // print_r($this->email->print_debugger());exit;
                    $this->session->set_flashdata('result_forget_password','Unable to send email.');
                    redirect('AdminLogin/ForgetPassword');
                }
              }   
                else {
                    $this->session->set_flashdata('result_forget_password','Email is not belogs to you');
                    redirect('AdminLogin/ForgetPassword');
                }
        }
                else {
                $this->load->view('login/admin_forget');
                }
    }

    
}