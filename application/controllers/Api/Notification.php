<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Notification extends REST_Controller {
  public function __construct() { 

    parent::__construct();

// Load the user model
    $this->load->model('Api/NotificationApiModel');
    $this->load->model('Api/AppointmentApiModel');
  }


  public function getUserNotification_post()
  {
  	$user_id = strip_tags($this->post('user_id'));
  	$notification = $this->NotificationApiModel->getUserNotificationByUserId($user_id);
    
    if(!empty($notification))
    {
      for($i=0;$i<count($notification);$i++)
      {
         $data = $this->AppointmentApiModel->getAppointmentByDoctorId($notification[$i]->doctor_id,$notification[$i]->appointment_id,$notification[$i]->appointment_date,$notification[$i]->shifting);

          $count = 1;

          $data1 = $this->AppointmentApiModel->getTokenNumberCountOfDoctor($notification[$i]->doctor_id,$notification[$i]->appointment_date,$notification[$i]->shifting);


          for($j=0;$j<count($data1);$j++)
          {
            if($data1[$j]->appointment_id == $notification[$i]->appointment_id)
            {
              break;
            }
              else
            {
              $count++;
            }
          }

          $notification[$i]->appointment_id = $count;

      }
    }
    
  	

  	if(!empty($notification))
  	{
     	 $this->response([
            'status' => TRUE,
            'message' => 'Notification',
            'notification' =>$notification
        ], REST_Controller::HTTP_OK);
  	}

  	else
  	{
     	 $this->response([
            'status' => TRUE,
            'message' => 'Notification Not Found',
            
        ], REST_Controller::HTTP_OK);
  	}

  }


  public function getMyUnreadMessageCount_post()
  {
  	$user_id = strip_tags($this->post('user_id'));
  	$notification_count = $this->NotificationApiModel->getUnreadMessageCount($user_id);

  		 $this->response([
            'status' => TRUE,
            'message' => 'Notification',
            'Notification_Count' =>$notification_count
        ], REST_Controller::HTTP_OK);
  }


  public function readANotification_post()
  {
  	$user_id = strip_tags($this->post('user_id'));
  	$status = $this->NotificationApiModel->ReadMessage($user_id);
  		
  	if(!empty($status))
  	{	
     	 $this->response([
            'status' => TRUE,
            'message' => 'Notification Read Successfully',
            'Notification_Count' =>0
        ], REST_Controller::HTTP_OK);
  	}
  	else
  	{
     	 $this->response([
            'status' => FALSE,
            'message' => 'Notification Already Read',
            'Notification_Count'=>0
        ], REST_Controller::HTTP_OK);
  	}

  }


  public function deleteNotification_post()
  {
  	$notification_id = strip_tags($this->post('notification_id'));
  	$status = $this->NotificationApiModel->deleteSingleNotification($notification_id);
  	if(!empty($status))
  	{	
     	 $this->response([
            'status' => TRUE,
            'message' => 'Notification Deleted Successfully'
        ], REST_Controller::HTTP_OK);
  	}
  	else
  	{
     	 $this->response([
            'status' => FALSE,
            'message' => 'Notification Not Found',
            
            
        ], REST_Controller::HTTP_OK);
  	}
  }

}  
