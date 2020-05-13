<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Appointments extends REST_Controller {
  public function __construct() { 

    parent::__construct();

// Load the user model
    $this->load->model('Api/AppointmentApiModel');
  }

  public function addAppointment_post()
  {
    $doctor_id = strip_tags($this->post('doctor_id'));
    $patient_id = strip_tags($this->post('patient_id'));
    $full_name = strip_tags($this->post('full_name')); 
    $phone_number = strip_tags($this->post('phone_number'));
    $age = strip_tags($this->post('age'));
    $address = strip_tags($this->post('address'));
    $appointment_date = strip_tags($this->post('appointment_date'));
    $appointment_time = strip_tags($this->post('appointment_time'));
    $status = strip_tags($this->post('status'));
    $gender = strip_tags($this->post('gender'));
    $token=strip_tags($this->post('device_id'));
    $appointment_data = array('patient_id'=>$patient_id,'full_name'=>$full_name,'doctor_id'=>$doctor_id,'phone_number'=>$phone_number,'address'=>$address,
      'age'=>$age,'appointment_date'=>$appointment_date,'appointment_time'=>$appointment_time,'gender'=>$gender);
    
    if($status == 'morning' || $status == 'Morning')
    {	
       $appointment_shifting = 1;
    }
    else if($status == 'evening' || $status == 'Evening')
    {
       $appointment_shifting = 2;
    }
    else
    {
    	$appointment_shifting = 0;
    }
    //echo $appointment_shifting;exit;
    
    if($this->AppointmentApiModel->checkDoctorAvailableInMorningAndEvening($doctor_id,$appointment_shifting))
    {
      if($this->AppointmentApiModel->checkAvailabilityOfDoctorById($doctor_id,$appointment_date)['status'])
      {
        $this->response([
        'status' => FALSE,
        'message' => 'Doctor on leave',
        ], REST_Controller::HTTP_OK);
      }

      else
      {

    	$appointment_data['shifting'] = $appointment_shifting;
	    $token_id = $this->AppointmentApiModel->addAppointment($appointment_data);

	    if($token_id)
	    {
	      $this->response([
	        'status' => TRUE,
	        'message' => 'Appointment added successfully',
	        'Time' => date('Y-m-d H:i:s'),
	        'Token Number'=>$token_id
	        ], REST_Controller::HTTP_OK);
	      $message = 'your appointment book successfully';


	      $this->firebase->send_notification('Apppointment addedd successfully',$token);
	    }

	    else 
	    {
	      $this->response([
	        'status' => FALSE,
	        'message' => 'Appointment already added',
	        ], REST_Controller::HTTP_OK);
	    }
      }

    }
    
	else
	{
      $this->response([
	        'status' => FALSE,
	        'message' => 'Doctor not available '.$status,

	        ], REST_Controller::HTTP_OK);
	}
 } 
  



  public function getDoctorAvailable_post()
  {
  	$date = strip_tags($this->post('date'));
  	$doctor_id = strip_tags($this->post('doctor_id'));
  	$data = $this->AppointmentApiModel->checkAvailabilityOfDoctorById($doctor_id,$date);
    $availableStatus1 = $this->AppointmentApiModel->getDoctorEveningMorningAvailableStatus($doctor_id);
    $array = explode(',',$availableStatus1);


    $count = 0;

    $availableStatus = '';
    if(empty($array[0]) && empty($array[1]))
    {
      $availableStatus .= 'Doctor Not Available' ;
    }
    else
    {
      $availableStatus .= 'Doctor Availability' ;  
    }
    


    if(array_key_exists(0, $array))
    {
      if($array[0] == 1)
      {
        $availableStatus.= ',Morning' ;
        $count++;
      }
    }


    if(array_key_exists(1, $array))
    {
      if($array[1] == 1)
      {
        if($count > 0)
        {
          $availableStatus .= ',Evening' ;  
        }
        else
        {
          $availableStatus .= ',Evening' ;  
          $count++;
        }

      }

    }
      
      
  	if($data['status'])
  	{
  		 $this->response([
	        'status' => FALSE,
	        'message' => 'Doctor on leave',
            'Data' =>$availableStatus
	        ], REST_Controller::HTTP_OK);
  	}

  	else
  	{
  		$this->response([
	        'status' => TRUE,
	        'message' => 'Doctor not on leave',
	        'Data' =>$availableStatus
	        ], REST_Controller::HTTP_OK);
  	}
  }


  public function getSingleAppointment_post()
  {
    $doctor_id = strip_tags($this->post('doctor_id'));
    $token_number = strip_tags($this->post('token_number'));
    $shiffting_status = strip_tags($this->post('shiffting_status'));
    $data = $this->AppointmentApiModel->getSingleAppointmentByDoctorId($doctor_id,$token_number,$shiffting_status);

    if($data->shifting == 1)
    {
     $data->appointment_time = $data->morning_start_time.' To '.$data->morning_end_time;
    }
    if($data->shifting == 2)
    {
     $data->appointment_time = $data->evening_start_time.' To '.$data->evening_end_time;
    }

    if(!empty($data))
    {
      $this->response([
        'status' => TRUE,
        'message' => 'Your appointment',
        'data'=>$data
        ], REST_Controller::HTTP_OK);
    }

    else 
    {
      $this->response([
        'status' => FALSE,
        'message' => 'appointment not found'
        ], REST_Controller::HTTP_OK);
    }

  }


// public function AppointmentsOfDoctors_post()
// {
//     $doctor_id = strip_tags($this->post('doctor_id'));
//     $token_number = strip_tags($this->post('token_number'));
//     $data = $this->AppointmentApiModel->getAppointmentByDoctorId($doctor_id,$token_number);
//     $your_number = 1;
//     for($i=0;$i<count($data['appointments']);$i++)
//     {
//       if($data['appointments'][$i]->status == 0)
//       {
//         $data['appointments'][$i]->isDone = false;
//         if($data['appointments'][$i]->appointment_id == $token_number)
//         {
//           break;
//         }
//         else 
//         {
//          $your_number++;
//         }
//       }
//       else 
//       {
//         $data['appointments'][$i]->isDone = true;
//       }  
//     }
//     for($i=0;$i<count($data['appointments']);$i++)
//     {
//       if($data['appointments'][$i]->appointment_id == $token_number)
//       {
//         $data['appointments'][$i]->isYour = true;
//       }
//       else
//       {
//        $data['appointments'][$i]->isYour = false; 
//       }
//     }


//     if($your_number >$data['count']){

//       $this->response([
//           'status' => FALSE,
//           'message' => 'your appointment completed please add again',

//       ], REST_Controller::HTTP_OK);
//     }

//     else if($data){
//       $this->response([
//           'status' => TRUE,
//           'your_number'=>$your_number,
//           'message' => 'Number of Appointment',
//           'total_number_of_appointment'=>$data['count'],
//           'appointment_list'=>$data['appointments'],

//       ], REST_Controller::HTTP_OK);
//     }

//     else {
//       $this->response([
//           'status' => FALSE,
//           'message' => 'Appointment not found',
//           'appointment'=>0
//       ], REST_Controller::HTTP_OK);
//     }
// }
 /* 2nd rework */
  // public function AppointmentsOfDoctors_post()
  // {
  //   $doctor_id = strip_tags($this->post('doctor_id'));
  //   $token_number = strip_tags($this->post('token_number'));
  //   $date = strip_tags($this->post('date'));
  //   $data = $this->AppointmentApiModel->getAppointmentByDoctorId($doctor_id,$token_number,$date);
  //   $your_number = 1;
  //   for($i=0;$i<count($data['appointments']);$i++)
  //   {
  //     $data['appointments'][$i]->AppointmentNumbering = $i+1;
  //     if($data['appointments'][$i]->status == 0)
  //     {
  //       $data['appointments'][$i]->isDone = false;
  //       if($data['appointments'][$i]->appointment_id == $token_number)
  //       {
  //         break;
  //       }
  //       else
  //       {
  //         $your_number++;
  //       }
  //     }
  //     else
  //     {
  //       $data['appointments'][$i]->isDone = true;
  //     }
  //   }
  //   for($i=0;$i<count($data['appointments']);$i++)
  //   {
  //     if($data['appointments'][$i]->appointment_id == $token_number)
  //     {
  //       $data['appointments'][$i]->isYour = true;
  //     }
  //     else
  //     {
  //       $data['appointments'][$i]->isYour = false;
  //     }
  //   }


  //   if($your_number >$data['count']){

  //     $this->response([
  //       'status' => FALSE,
  //       'message' => 'your appointment completed please add again',

  //       ], REST_Controller::HTTP_OK);
  //   }

  //   else if($data){
  //     $this->response([
  //       'status' => TRUE,
  //       'your_number'=>$your_number,
  //       'message' => 'Number of Appointment',
  //       'total_number_of_appointment'=>$data['count'],
  //       'appointment_list'=>$data['appointments'],

  //       ], REST_Controller::HTTP_OK);
  //   }

  //   else {
  //     $this->response([
  //       'status' => FALSE,
  //       'message' => 'Appointment not found',
  //       'appointment'=>0
  //       ], REST_Controller::HTTP_OK);
  //   }
  // }

 /*3rd rework */
	public function AppointmentsOfDoctors_post()
	{
		$doctor_id = strip_tags($this->post('doctor_id'));
		$token_number = strip_tags($this->post('token_number'));
		$date = strip_tags($this->post('date'));
		$shifting = strip_tags($this->post('shiffting_status'));
		$data = $this->AppointmentApiModel->getAppointmentByDoctorId($doctor_id,$token_number,$date,$shifting);
		$your_number = 1;
    // print_r($data['appointments']);exit;
		for($i=0;$i<count($data['appointments']);$i++)
		{
			$data['appointments'][$i]->AppointmentNumbering = $i+1;

    if($data['appointments'][$i]->shifting == 1)
    {
      $data['appointments'][$i]->appointment_time = $data['appointments'][$i]->morning_start_time.' To '.$data['appointments'][$i]->morning_end_time;
    }
    if($data['appointments'][$i]->shifting == 2)
    {
      $data['appointments'][$i]->appointment_time  = $data['appointments'][$i]->evening_start_time.' To '.$data['appointments'][$i]->evening_end_time;
    }
		}


    
		for($i=0;$i<count($data['appointments']);$i++)
		{
			$data['appointments'][$i]->AppointmentNumbering = $i+1;
			if($data['appointments'][$i]->status == 0)
			{
				$data['appointments'][$i]->isDone = false;
			if($data['appointments'][$i]->appointment_id == $token_number)
			{
				break;
			}
				else
			{
				$your_number++;
			}
			}
			else
			{
				$data['appointments'][$i]->isDone = true;
			}
		}


    // if(!empty($data['appointments']))
    // {
    //   for($i=0;$i<count($data['appointments']);$i++)
    //   {
    //     $count = 1;
        
    //     $data1 = $this->AppointmentApiModel->getTokenNumberCountOfDoctor($data['appointments'][$i]->doctor_id);


    //     for($j=0;$j<count($data1);$j++)
    //     {
    //       if($data1[$j]->appointment_id == $data['appointments'][$i]->appointment_id)
    //       {
    //         break;
    //       }
    //       else
    //       {
    //         $count++;
    //       }
    //     }

    //    $data['appointments'][$i]->appointmentOriginalNumbering = $count;
    //    if($data['appointments'][$i]->status == 0)
    //     {
    //       $data['appointments'][$i]->isDone = FALSE;
    //     }
    //     else
    //     {
    //       $data['appointments'][$i]->isDone = TRUE;
    //     }
        
    //   }

    // }
   // $count =1;
		for($i=0;$i<count($data['appointments']);$i++)
		{
			if($data['appointments'][$i]->appointment_id == $token_number)
			{
				$data['appointments'][$i]->isYour = true;
      //  break;
			}
			else
			{
				$data['appointments'][$i]->isYour = false;
       // $count++;
			}
		}



		if($your_number >$data['count'])
		{
			$this->response([
			'status' => FALSE,
			'message' => 'your appointment Not found',
			], REST_Controller::HTTP_OK);
		}


		else if($data)
		{
			$this->response([
			'status' => TRUE,
			'your_number'=>$count,
      'doctor_time' => $data['appointments'][0]->appointment_time,
			'message' => 'Number of Appointment',
			'total_number_of_appointment'=>$data['count'],
			'appointment_list'=>$data['appointments'],

			], REST_Controller::HTTP_OK);
		}

		else 
		{
			$this->response([
			'status' => FALSE,
			'message' => 'Appointment not found',
			'appointment'=>0
			], REST_Controller::HTTP_OK);
		}
	}

	

  public function AppointmentStatus_post()
  {
    $doctor_id = strip_tags($this->post('doctor_id'));
    $patient_id = strip_tags($this->post('patient_id'));
    $appoitment_id = strip_tags($this->post('appointment_id'));
    $status = strip_tags($this->post('status'));
    $res =  $this->AppointmentApiModel->cancelAppointment($patient_id,$doctor_id,$status,$appoitment_id);
    if($res['status'])
    {
      $this->response([
        'status' => $res['status'],
        'message' => $res['message'],

        ], REST_Controller::HTTP_OK);
    }
    else 
    {
      $this->response([
        'status' => $res['status'],
        'message' => $res['message'],
        ], REST_Controller::HTTP_OK);
    }

  }


// public function PatientAppointmentHistory_post()
// {
//   $patient_id = strip_tags($this->post('patient_id'));
//   $data = $this->AppointmentApiModel->appointmentHistory($patient_id);

//   if($data)
//   {
//     $this->response([
//       'status'=>true,
//       'message'=>'your appointment history',
//       'appointments'=>$data
//       ], REST_Controller::HTTP_OK);
//   }
//   else 
//   {
//     $this->response([
//       'status'=>true,
//       'message'=>'Appointment not found',

//       ], REST_Controller::HTTP_OK); 
//   }

// }

  public function PatientAppointmentHistory_post()
  {
    $patient_id = strip_tags($this->post('patient_id'));
    // $date = strip_tags($this->post('date'));
     $shiffting_status = strip_tags($this->post('shiffting_status'));

    $data = $this->AppointmentApiModel->appointmentHistory($patient_id,0,$shiffting_status);
    
    if(!empty($data))
    {
	    for($i=0;$i<count($data);$i++)
	    {
	      $data[$i]->AppointmentNumbering = $i+1;
        $data[$i]->appointment_current_date = date("Y-m-d", strtotime($data[$i]->created));

	    }
    }

   if(!empty($data))
    {
      for($i=0;$i<count($data);$i++)
      {
        $count = 1;
        
        $data1 = $this->AppointmentApiModel->getTokenNumberCountOfDoctor($data[$i]->doctor_id);

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

    }

    

    if($data)
    {
      $this->response([
        'status'=>true,
        'message'=>'your appointment history',
        'appointments'=>$data
      ], REST_Controller::HTTP_OK);
    }

    else
    {
      $this->response([
        'status'=>true,
        'message'=>'Appointment not found',
      ], REST_Controller::HTTP_OK);
    }

  }



  public function PatientAppointmentHistoryFilters_post()
  {
  	$patient_id = strip_tags($this->post('patient_id'));
    $date = strip_tags($this->post('date'));
    //$shiffting_status = strip_tags($this->post('shiffting_status'));

    $data = $this->AppointmentApiModel->appointmentHistory($patient_id,$date,0);
    
    if(!empty($data))
    {
	    for($i=0;$i<count($data);$i++)
	    {
	      $data[$i]->AppointmentNumbering = $i+1;
        $data[$i]->appointment_current_date = date("Y-m-d", strtotime($data[$i]->created));
	    }
    }


    if(!empty($data))
    {
      for($i=0;$i<count($data);$i++)
      {
        $count = 1;
        
        $data1 = $this->AppointmentApiModel->getTokenNumberCountOfDoctor($data[$i]->doctor_id);

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
    }



    if($data)
    {
      $this->response([
        'status'=>true,
        'message'=>'your appointment history',
        'appointments'=>$data
      ], REST_Controller::HTTP_OK);
    }

    else
    {
      $this->response([
        'status'=>true,
        'message'=>'Appointment not found',
      ], REST_Controller::HTTP_OK);
    }
  }


  public function EditScheduleAppointment_post()
  {
    $appointment_id = strip_tags($this->post('appointment_id'));
    $doctor_id = strip_tags($this->post('doctor_id'));
    $patient_id = strip_tags($this->post('patient_id'));
    $full_name = strip_tags($this->post('full_name')); 
    $phone_number = strip_tags($this->post('phone_number'));
    $age = strip_tags($this->post('age'));
    
    $address = strip_tags($this->post('address'));
    
    $appointment_date = strip_tags($this->post('appointment_date'));
    $appointment_time = strip_tags($this->post('appointment_time'));
    $gender = strip_tags($this->post('gender'));
    $status = strip_tags($this->post('status'));

    if($status == 'morning' || $status == 'Morning')
    {
       $appointment_shifting = 1;
    }
    else if($status == 'evening' || $status == 'Evening')
    {
       $appointment_shifting = 2;
    }
    else
    {
      $appointment_shifting = 0;
    }


    $reschedule_appointment  = array('full_name'=>$full_name,'doctor_id'=>$doctor_id,'patient_id'=>$patient_id,'age'=>$age,'gender'=>$gender,'phone_number'=>$phone_number,'appointment_date'=>$appointment_date,'appointment_time'=>$appointment_time,'address'=>$address,'shifting'=>$appointment_shifting);
    if($this->AppointmentApiModel->checkDoctorAvailableInMorningAndEvening($doctor_id,$appointment_shifting))
    {
     if($this->AppointmentApiModel->CheckStatusOfAppointment($appointment_id,$appointment_shifting))
    {  
      if($this->AppointmentApiModel->reschedule_appointment($reschedule_appointment,$appointment_id))
      {
        $this->response([
          'status' => TRUE,
          'message' => 'Appointment reschedule successfully',

          ], REST_Controller::HTTP_OK);
      }

      else 
      {
        $this->response([
          'status' => TRUE,
          'message' => 'Appointment reschedule successfully',

          ], REST_Controller::HTTP_OK); 
      }
    }
    else
    {
        $this->response([
          'status' => TRUE,
          'message' => 'Appointment has completed can not reschedule'

          ], REST_Controller::HTTP_OK); 
    }
  }

  else
  {
     $this->response([
          'status' => FALSE,
          'message' => 'Doctor not available in '.$status,

          ], REST_Controller::HTTP_OK);
  }

  }







}