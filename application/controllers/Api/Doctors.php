  <?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Doctors extends REST_Controller {
    public function __construct() { 
    	 
        parent::__construct();
        
        // Load the user model
         $this->load->model('Api/DoctorsModel');
         $this->load->model('Api/AppointmentApiModel');
        
    }
     

    // public function DoctorSchedule_post(){
    //   $FromData = strip_tags($this->post('from_date'));
    //   $to_date = strip_tags($this->post('to_date'));
    //   $doctor_id = strip_tags($this->post('doctor_id'));
    //   $availabilitystatus = strip_tags($this->post('availablestatus'));
    // }

    public function Doctorslist_get()
    { 
      $date = strip_tags($this->post('date'));
      $location = strip_tags($this->post('location'));
      $doctor_id = strip_tags($this->post('doctor_id'));

      $data = $this->DoctorsModel->getAllDoctors();
      for($i=0;$i<count($data['data']);$i++){
       $data['data'][$i]->feedback = $this->db->where('doctor_id',$data['data'][$i]->id)->from("feedback")->count_all_results();
      }

      for($i=0;$i<count($data['data']);$i++)
      {
        $data['data'][$i]->username = $data['data'][$i]->first_name.' '.$data['data'][$i]->last_name;

       $status = $data['data'][$i]->available_status;
       $array = explode(',',$status);
       $count = 0;
       if(array_key_exists(0, $array))
       {
         if($array[0] == 1)
         {
          $data['data'][$i]->availables = 'morning' ;
          $count++;
         }
       }

       if(array_key_exists(1, $array))
       {
         if($array[1] == 1)
         {
          if($count > 0)
          {
             $data['data'][$i]->availables .= ',evening' ;  
          }
          else
          {
            $data['data'][$i]->availables = 'evening' ;  
            $count++;
          }
          
         }
       }

       if($count == 0)
       {
         $data['data'][$i]->availables = 'Not available' ;  
       }

      }

      
      if($data['data']){
        $this->response([
            'status' => TRUE,
            'message' => $data['message'],
            'Doctors'=>$data['data']
        ], REST_Controller::HTTP_OK);
      }
      else {
        $this->response([
            'status' => TRUE,
            'message' => 'Doctors Not found'
        ], REST_Controller::HTTP_OK);
      }
    }




   public function UpdateMySchedule_post()
   {
     $doctor_id = strip_tags($this->post('doctor_id'));
     $status = strip_tags($this->post('status'));


     $morning_start_time = strip_tags($this->post('morning_start_time'));
     $morning_end_time = strip_tags($this->post('morning_end_time'));

     $evening_start_time = strip_tags($this->post('evening_start_time'));
     $evening_end_time = strip_tags($this->post('evening_end_time'));
     $insert_array = array();
     $status1 = '';
     $count = 0;
     
     $status_array = explode(',',$status);
     

     if(array_key_exists(0, $status_array))
     {
       if($status_array[0] == 1)
       {
        $insert_array['morning_start_time'] = $morning_start_time;
        $insert_array['morning_end_time'] = $morning_end_time;


       }
       else
       {
        $insert_array['morning_start_time'] = '';
        $insert_array['morning_end_time'] = '';
       }
     }

     if(array_key_exists(1, $status_array))
     {
       if($status_array[1] == 1)
       {
        $insert_array['evening_start_time'] = $evening_start_time;
        $insert_array['evening_end_time'] = $evening_end_time;
       }
       else
       {
        $insert_array['evening_start_time'] = '';
        $insert_array['evening_end_time'] = '';
       }
     }

     $insert_array['evening_morning_status'] = $status;
     $insert_array['doctor_id'] = $doctor_id;
     
     if($this->DoctorsModel->updateDoctorSchedule($insert_array,$doctor_id))
     {
      $this->response([
            'status' => TRUE,
            'message' =>'Updated Successfully',

        ], REST_Controller::HTTP_OK);
     }
     else
     {
      $this->response([
            'status' => FALSE,
            'message' =>'Unable To Update',
         
        ], REST_Controller::HTTP_OK);
     }




   }


  public function getDoctorMorningEveningStatus_post()
  {
    $doctor_id = strip_tags($this->post('doctor_id'));
    $data = $this->DoctorsModel->getStatusOfShiffing($doctor_id);
    if($data)
    {
    $this->response([
        'status' => TRUE,
        'message' =>'Doctor status',
        'Doctors'=>$data
    ], REST_Controller::HTTP_OK);
    }
    else 
    {
      $this->response([
        'status' => TRUE,
        'message' => 'Status Not found'
      ], REST_Controller::HTTP_OK);
    }
  }
  


   public function Doctorslistsearch_post()
   {
      
      $name = strip_tags($this->post('content'));
     
      // $doctor_id = strip_tags($this->post('doctor_id'));
      $data = $this->DoctorsModel->getAllDoctorsbysearch($name);
      for($i=0;$i<count($data);$i++){
        if($data[$i]->hospital_name == null){
          $data[$i]->hospital_name='';
        }
      }
      if($data){
        $this->response([
            'status' => TRUE,
            'message' =>'doctor list',
            'Doctors'=>$data
        ], REST_Controller::HTTP_OK);
      }else {
        $this->response([
            'status' => TRUE,
            'message' => 'Doctors Not found'
        ], REST_Controller::HTTP_OK);
      }
    }


    public function myAppointmentList_post()
    {
      $doctor_id = $this->post('doctor_id');
      $date = $this->post('date');
      $attend_status = $this->post('attend_status');
      $shiffting_status = $this->post('shiffting_status');
      $data = $this->DoctorsModel->getAppointmentByDoctor($doctor_id,$date,$attend_status,$shiffting_status);

      for($i=0;$i<count($data);$i++)
      {
        $data1 = $this->AppointmentApiModel->getTokenNumberCountOfDoctor($data[$i]->doctor_id,$data[$i]->appointment_date,$data[$i]->shifting);  
        $count = 1;
        for($j=0;$j<count($data1);$j++)
        {
        if($data1[$j]->appointment_id == $data[$i]->appointment_id)
        {
        break;
        }
        else
        {
        $count++;
        }
        }

        $data[$i]->appointmentOriginalNumbering = $count;
      }
       
      
      if($data){
        $this->response([
            'status' => TRUE,
            'message' => 'Appointment',
            'data'=>$data
        ], REST_Controller::HTTP_OK);
      }else {
        $this->response([
            'status' => TRUE,
            'message' => 'Appointment Not found'
        ], REST_Controller::HTTP_OK);
      }
    }


    public function addDoctorReview_post()
    {
      $doctor_id = strip_tags($this->post('doctor_id'));
      $patient_id = strip_tags($this->post('patient_id')); 
      $comment = strip_tags($this->post('comment'));
      $rating = strip_tags($this->post('rating'));
     
      $upload_data = array('doctor_id'=>$doctor_id,'patient_id'=>$patient_id,'comment'=>$comment,'rating
        '=>$rating);
      $res = $this->DoctorsModel->AddDoctorReview($upload_data);
      if($res['status']){
         $this->response([
            'status' => TRUE,
            'message' =>$res['message'] 
        ], REST_Controller::HTTP_OK);
      }
      else {
         $this->response([
            'status' => TRUE,
            'message' => 'Internal server error'
        ], REST_Controller::HTTP_OK);
      }
     
    }


    public function updateMyProfile_post()
    {
      $doctor_id = strip_tags($this->post('doctor_id'));
      $full_name = strip_tags($this->post('username'));
      $email = strip_tags($this->post('email'));
      $phone_number = strip_tags($this->post('phone_number'));
      $dob = strip_tags($this->post('dob'));
      $gender = strip_tags($this->post('gender'));
      $password = strip_tags($this->post('password'));
      $city = strip_tags($this->post('city')); 
      $country = strip_tags($this->post('country')); 
      $state = strip_tags($this->post('state')); 
      $postal_code = strip_tags($this->post('postal_code')); 
      $profession = strip_tags($this->post('profession')); 
      $experience = strip_tags($this->post('experience'));
      $hospital_id = strip_tags($this->post('hospital_name'));
      $fees = strip_tags($this->post('fees'));
      $description = strip_tags($this->post('description'));
      $address = strip_tags($this->post('address'));
      $education = strip_tags($this->post('education'));
      $biography = strip_tags($this->post('biography'));
      $Appointment_limit = strip_tags($this->post('Appointment_limit'));


      if(!empty($full_name))
      {
        $d = explode(' ',$full_name);
      }
      // if(!empty($d[0])){
      //   $first_name = $d[0]
      // }
      empty($d[0])?$first_name='':$first_name=$d[0];
      empty($d[1])?$last_name='':$last_name=$d[1];

      $update_doctor= array('first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,
        'state'=>$state,'postal_code'=>$postal_code,'hospital_id'=>$hospital_id,'city'=>$city,'country'=>$country,'password'=>$password,'gender'=>$gender,'phone_number'=>$phone_number,'dob'=>$dob,
        'profession'=>$profession,'exp'=>$experience,'fees'=>$fees,'biography'=>$description,'address'=>$address,'education'=>$education,'biography'=>$biography,'Appointment_limit'=>$Appointment_limit);



         if(!empty($_FILES['profile_image']['name'])){
         $config['upload_path'] = './uploads/doctor_profiles';
          $config['allowed_types'] = 'gif|jpg|png|jpeg';
          $config['max_size'] = 20000;
          $config['max_width'] = 45000;
          $config['max_height'] = 45000;
 


          $this->load->library('upload', $config);
  
          if (!$this->upload->do_upload('profile_image')) 
          {
             $error = array('error' => $this->upload->display_errors());
             $image = '';
      
     
          } 
          else 
          {
            $image = $this->upload->data()['file_name'];
            $update_doctor['image'] = $image;
          }
      }
       if($this->DoctorsModel->checkPhone($update_doctor['phone_number'],$doctor_id))
       {
         $this->response([
          'status' => FALSE,
          'message' =>'Phone Number is already exist',
           ], REST_Controller::HTTP_OK);
        }
        else if($this->DoctorsModel->checkEmail($update_doctor['email'],$doctor_id))
        {
         $this->response([
          'status' => FALSE,
          'message' =>'Email is already exist',
            
        ], REST_Controller::HTTP_OK);
       }
       else 
       {
        if($this->DoctorsModel->updateDoctorProfile($update_doctor,$doctor_id))
        {
          if(empty($update_doctor['image']))
          {
            $update_doctor['image'] = $this->DoctorsModel->getUserImage($doctor_id)[0]->image;
          }
          $this->response([
            'status' => TRUE,
            'message' =>'updated',
            'data'=> $update_doctor
          ], REST_Controller::HTTP_OK);
        }
      }

    }

    public function DoctorAvailable_post()
    {
      $doctor_id = strip_tags($this->post('doctor_id'));
      $start_time = strip_tags($this->post('start_time'));
      $end_time = strip_tags($this->post('end_time'));
      $status = strip_tags($this->post('status'));
      $available_days = strip_tags($this->post('available'));
      $available_array = explode(',',$available_days);
      $start_date = strip_tags($this->post('start_date'));
      $end_date = strip_tags($this->post('end_date'));

 
      
      $available_data = array('start_time'=>$start_time,'end_time'=>$end_time,'status'=>$status,'doctor_id'=>$doctor_id);
       if($status == 0)
       {
        $available_data['from_date'] =date('Y-m-d', strtotime($start_date));
        $available_data['to_date'] = date('Y-m-d', strtotime($end_date));
       }
      if($status == 1)
      {
        $available_data['available'] =  json_encode($available_array);  
      }

      if($this->DoctorsModel->AvailabilityDoctors($available_data))
      {
        
         $this->response([
            'status' => TRUE,
            'message' =>'added successfully',
           
          ], REST_Controller::HTTP_OK);  
      }
    }



    public function DoctorProfile_post()
    {
      $doctor_id = strip_tags($this->post('doctor_id'));
      $data = $this->DoctorsModel->doctorPrf($doctor_id);

      for($i=0;$i<count($data);$i++)
      {
         $full_name = $data[$i]->first_name.' '.$data[$i]->last_name;
         $data[$i]->full_name = $full_name;
         if($data[$i]->postal_code == 0)
         {
          $data[$i]->postal_code = '';
         } 
         if($data[$i]->fees == 0)
         {
          $data[$i]->fees = '';
         }         
         if($data[$i]->exp == 0)
         {
          $data[$i]->exp = '';
         } 
         if($data[$i]->Appointment_limit == 0)
         {
          $data[$i]->Appointment_limit = '';
         } 
      }
      
      if($data)
      {
       $this->response([
            'status' => TRUE,
            'message' =>'single doctor',
            'data'=>$data
        ], REST_Controller::HTTP_OK);
       }
       else 
       {
        $this->response([
        'status' => FALSE,
        'message' =>'Doctor not found' ]
        , REST_Controller::HTTP_OK);
       }
    }


    public function getDoctorReviews_post()
    {
      $doctor_id = strip_tags($this->post('doctor_id'));
      $res = $this->DoctorsModel->doctorReviewsList($doctor_id);
      if($res['status'])
      {
        $this->response([
          'status' => TRUE,
          'message' =>$res['message'] 
        ], REST_Controller::HTTP_OK);
      }
      else 
      {
        $this->response([
          'status' => TRUE,
          'message' => 'Internal server error'
        ], REST_Controller::HTTP_OK);
      } 
    }


    public function getDoctorList_post()
    {

      $doctor_id = strip_tags($this->post('doctor_id'));
      
      $data = $this->DoctorsModel->getDoctorSchedule($doctor_id);
      for($i=0;$i<count($data);$i++)
      {
        if(!empty($data[$i]->available))
        {
          $data[$i]->available = implode(',',json_decode($data[$i]->available, true));
        }
      }
       $this->response([
          'status' => TRUE,
          'message'=>'schedule list',
          'data' =>$data 
        ], REST_Controller::HTTP_OK);


    }


public function gettnc_get()
  {
    
$data = "https://alphawizz.com/Doctor/doctor-html/Terms-condition.html"; 

    $this->response([
        'status' => TRUE,
        'message' =>'Terms and condition link',
        'link'=>$data
    ], REST_Controller::HTTP_OK);
    
  }


public function getrefund_get()
  {
    
$data = "https://alphawizz.com/Doctor/doctor-html/refund.html"; 

    $this->response([
        'status' => TRUE,
        'message' =>'Refund link',
        'link'=>$data
    ], REST_Controller::HTTP_OK);
    
  }



public function getprivacypolicy_get()
  {
    
$data = "https://alphawizz.com/Doctor/doctor-html/privacy-policy.html"; 

    $this->response([
        'status' => TRUE,
        'message' =>'Privacy policy link',
        'link'=>$data
    ], REST_Controller::HTTP_OK);
    
  }

  public function getaboutus_get()
  {
    
$data = "https://alphawizz.com/Doctor/doctor-html/About-us.html"; 

    $this->response([
        'status' => TRUE,
        'message' =>'About us link',
        'link'=>$data
    ], REST_Controller::HTTP_OK);
    
  }

}