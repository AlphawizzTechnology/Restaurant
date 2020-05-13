<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Banner extends REST_Controller {

    public function __construct() { 
    	 
        parent::__construct();
        
        // Load the user model
         $this->load->model('Api/LoginApiModel');
        
    }

    public function index_get(){
      $data = array('0'=>'b1.png','1'=>'b2.png','2'=>'b3.png','3'=>'b4.png','4'=>'b5.png','5'=>'b6.png','6'=>'b7.png','7'=>'b8.png');
      $this->db->select("*");
      $this->db->from('Banner');
      $data = $this->db->get()->result();
       
       $this->response([
                    'status' => TRUE,
                    'images' => $data,
                   
                    
                ], REST_Controller::HTTP_OK);
    }
    

    public function Enquiry_post()
    {

        $title = strip_tags($this->post('title'));
        $description = strip_tags($this->post('description'));
        $email = 'gopalsh98598@gmail.com';
        // echo $email;exit;$this->config->item('enquiry_email')

        $this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        $to = $email;
        $subject = $title;
        $message = $description;
         
        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
         
        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {  
            show_error($this->email->print_debugger());
        }

    }
    
   
}