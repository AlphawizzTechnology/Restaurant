<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Patients extends REST_Controller {

    public function __construct() { 
    	 
        parent::__construct();
        
        // Load the user model
          $this->load->model('Api/PatientApiModel');
        
    }


    public function PatientProfile_post()
    {
     $patient_id = strip_tags($this->post('patient_id'));
     $data = $this->PatientApiModel->getAllPatiens($patient_id);

     if($data){
       $this->response([
        'status' => TRUE,
        'message' => 'patient',
        'data'=>$data
      ], REST_Controller::HTTP_OK);
     }

     else {
     	$this->response([
        'status' => TRUE,
        'message' => 'patient not found',
      ], REST_Controller::HTTP_OK);
     }

    }


    public function getPatientImage_post()
    {
      $patient_id = strip_tags($this->post('patient_id'));
      $data = $this->PatientApiModel->getPatientImage($patient_id);

      if($data)
      {
       $this->response([
        'status' => TRUE,
        'message' => 'your profile',
        'data'=>$data
      ], REST_Controller::HTTP_OK);
     }
     else 
     {
      $this->response([
        'status' => FALSE,
        'message' => 'patient not found',
      ], REST_Controller::HTTP_OK);
     }

      
    }


  public function updateMyProfile_post()
  {
     
    $patient_id =strip_tags($this->post('patient_id'));
    $email = strip_tags($this->post('email'));

    $dob = strip_tags($this->post('dob'));

    $address = strip_tags($this->post('address'));

    $phone_number = strip_tags($this->post('phone_number'));


    $update_patient= array('email'=>$email,
    'dob'=>$dob,'address'=>$address,'phone_number'=>$phone_number);


    if(!empty($_FILES['profile_image']['name'])){
      $config['upload_path'] = './uploads/patients_profiles';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 20000;
      $config['max_width'] = 45000;
      $config['max_height'] = 45000;



      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('profile_image')) {
        $error = array('error' => $this->upload->display_errors());
        $image = '';


      }
      else {
        $image = $this->upload->data()['file_name'];
        $update_patient['image'] = $image;
      }
      }

      if($this->PatientApiModel->checkPhone($update_patient['phone_number'],$patient_id)){
        $this->response([
          'status' => FALSE,
          'message' =>'Phone Number is already exist',
        ], REST_Controller::HTTP_OK);
        }

      else if($this->PatientApiModel->checkEmail($update_patient['email'],$patient_id))
      {
        $this->response([
          'status' => FALSE,
          'message' =>'Email is already exist',
        ], REST_Controller::HTTP_OK);
      }
      else 
      {
        if(empty($update_patient['image']))
        {
          $update_patient['image'] = '';
        }
        if($this->PatientApiModel->updatePatientProfile($update_patient,$patient_id))
        {
          $this->response([
            'status' => TRUE,
            'message' =>'updated',
            'data'=> $update_patient
          ], REST_Controller::HTTP_OK);
        }
      }
    }

  //     "message" => $message
  //   )
  //   );

  //   //header includes Content type and api key
  //   $headers = array(
  //   'Content-Type:application/json',
  //   'Authorization:key='.$api_key
  //   );

  //   $ch = curl_init();
  //   curl_setopt($ch, CURLOPT_URL, $url);
  //   curl_setopt($ch, CURLOPT_POST, true);
  //   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  //   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
  //   $result = curl_exec($ch);
  //   if ($result === FALSE) {
  //   die('FCM Send Error: ' . curl_error($ch));
  //   }
  //   curl_close($ch);
    
  // }


  public function yourAppointment_post()
  {
    $doctor_id = strip_tags($this->post('doctor_id'));
    
    $patient_id = strip_tags($this->post('patient_id'));
    $data = $this->PatientApiModel->Appointment($doctor_id,$patient_id);
    $this->token = 0;
    $this->your_token=0;
    $this->appointment_time='';
    for($i=0;$i<count($data);$i++){
      $this->token++;
      if($data[$i]->patient_id == $patient_id){
        $data[$i]->your_appointment = true;
        $data[$i]->token_number = $this->token;
        $data[$i]->Estimated_time = $data[$i]->appointment_time ; 
        $this->your_token = $this->token;
        $this->appointment_time = $data[$i]->appointment_time;
        if($this->token == 1){
          $data[$i]->isAttending = true;
        }
        else {
          $data[$i]->isAttending = false; 
        }
        
      }
      else {
        if($this->token == 1){
          $data[$i]->isAttending = true;
        }
        else {
          $data[$i]->isAttending = false; 
        }
        $data[$i]->Estimated_time = $data[$i]->appointment_time ; 
        $data[$i]->your_appointment = false; 
        $data[$i]->token_number = $this->token; 
      }
    }


    $this->response([
            'status' => TRUE,
            'message' =>'Appointments List',
            'Your_Token'=>$this->your_token,
            'Appointment_Time'=>$this->appointment_time,
            'data'=> $data
    ], REST_Controller::HTTP_OK); 

  }


  // public function cancelAppointment_post(){
    
  // }

  




}