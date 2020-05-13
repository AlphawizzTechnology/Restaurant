<?php  
class NotificationApiModel extends CI_Model {
  public function __construct()
  {
    $this->response= array();
    $this->doctor=array();
    $this->message='';
  }

  public function getUserNotificationByUserId($user_id)
  {
  	$this->db->select("Notification.*,Appointment.full_name as Patient_name,Appointment.appointment_id,Appointment.doctor_id,Appointment.appointment_date,Appointment.shifting");
  	$this->db->from('Notification');
    $this->db->join('Appointment','Notification.appointment_id = Appointment.appointment_id');
  	$this->db->where('Notification.user_id',$user_id);
  	$this->db->order_by('Notification.read_status','asc');
  	$this->db->order_by('Notification.notification_id','desc');
  	$data = $this->db->get()->result();
  	return empty($data)?false:$data;
  }


  public function getUnreadMessageCount($user_id)
  {
    $this->db->select("*");
  	$this->db->from('Notification');
  	$this->db->where(array('user_id'=>$user_id,'read_status'=>0));
  	$data = $this->db->get()->num_rows();
  	// echo $this->db->last_query();exit;
  	return $data;
  }


  public function ReadMessage($user_id=0)
  {
    $this->db->where(array('user_id'=>$user_id));
    $this->db->update('Notification',array('read_status'=>1));
    if($this->db->affected_rows()  > 0)
    {
    	return true;
    }
    else
    {
    	return false;
    }
  }


  public function deleteSingleNotification($notification_id)
  {
  	$this->db->where('notification_id',$notification_id);
   	$this->db->delete('Notification');
   	if($this->db->affected_rows() > 0)
   	{
   		return true;
   	}
   	else
   	{
   		return false;
   	}
  }

}  