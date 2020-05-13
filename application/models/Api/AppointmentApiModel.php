<?php  
class AppointmentApiModel extends CI_Model {
  public function __construct()
  {
    $this->response= array();
    $this->doctor=array();
    $this->message='';
  }


  // public function getAppointmentByDoctorId($id,$token_number)
  // {
  //   $this->db->select("Appointment.*,CONCAT(Doctors.first_name,' ',Doctors.last_name) as Doctor_name,Doctors.profession,Doctors.fees,Doctors.hospital_id as hospital,Doctors.address");
  //   $this->db->from('Appointment');
  //   $this->db->join('Doctors','Doctors.id=Appointment.doctor_id');
  //   $date = new DateTime("now");
  //   $curr_date = $date->format('Y-m-d');
  //   // echo $curr_date;exit;
  //   $this->db->where(array('Appointment.doctor_id'=>$id,'Appointment.appointment_date'=>$curr_date));

  //   $query = $this->db->get();
  //   $count = $query->num_rows();
  //   $list = $query->result();
  //   $this->doctor['count']= $count;
  //   $this->doctor['appointments'] = $list;
  //   // echo $this->db->last_query();exit;
  //   return (empty($this->doctor))?false:$this->doctor;
  // }
  public function getAppointmentByDoctorId($id,$token_number,$date,$shifting)
{
$this->db->select("Appointment.*,Doctor_schedule.morning_start_time,Doctor_schedule.morning_end_time,Doctor_schedule.evening_start_time,Doctor_schedule.evening_end_time,CONCAT(Doctors.first_name,' ',Doctors.last_name) as Doctor_name,Doctors.profession,Doctors.fees,Doctors.hospital_id as hospital,Doctors.address");
$this->db->from('Appointment');
$this->db->join('Doctors','Doctors.id=Appointment.doctor_id');
$this->db->join('Doctor_schedule','Doctor_schedule.doctor_id = Appointment.doctor_id');
// $date = new DateTime("now");
$date1 = date('Y-m-d', strtotime($date) );
// $curr_date = $date->format('Y-m-d');
// echo $curr_date;exit;
$con = array('Appointment.doctor_id'=>$id,'Appointment.appointment_date'=>$date1);
if(!empty($shifting))
{
  $con['Appointment.shifting'] = $shifting;
}
$this->db->where($con);

$query = $this->db->get();
// echo $this->db->last_query();exit;
$count = $query->num_rows();
$list = $query->result();
$this->doctor['count']= $count;
$this->doctor['appointments'] = $list;
// echo $this->db->last_query();exit;
return (empty($this->doctor))?false:$this->doctor;
}


  public function reschedule_appointment($reschedule_data,$id)
  {
    if(!empty($reschedule_data))
      {
        // $this->db->select("*");
        // $this->db->from('Appointment');
        // $this->db->where('appointment_id',$id);
        // $this->db->get()->row();
        $this->db->where('appointment_id',$id);
        $this->db->update('Appointment',$reschedule_data);
      }
  }


  public function checkAvailabilityDaysOfDoctorById($doctor_id,$dayname)
  {
    $this->db->select("available");
    $this->db->from('Doctor_schedule');
    $this->db->where('doctor_id',$doctor_id);
    $this->db->like('available',$dayname);
    $data = $this->db->get()->row();
    if(!empty($data))
    {
      return true;
    }
    else
    {
      return false;
    }
    // return empty($data->available)?false:$data->available;
    
  }



 public function getTokenNumberCountOfDoctor($doctor_id,$date='',$shiffting='')
 {
   $this->db->select("*");
   $this->db->from('Appointment');
   $date1 = date('Y-m-d', strtotime($date) );
   $con = array('doctor_id'=>$doctor_id,'appointment_date'=>$date1,'shifting'=>$shiffting);
   $this->db->where($con);

   return $this->db->get()->result();
 }


  public function checkDoctorAvailableInMorningAndEvening($doctor_id,$status)
  {
     $this->db->select("Doctor_schedule.evening_morning_status");
     $this->db->from('Doctors');
     $this->db->join("Doctor_schedule",'Doctor_schedule.doctor_id = Doctors.id');
     $this->db->where('Doctors.id',$doctor_id);
     $data = $this->db->get()->row();
     // echo $this->db->last_query();exit;
     
     if(!empty($data->evening_morning_status))
     {
       $available = $data->evening_morning_status;  
       $available_days = explode(",",$available);
     }
     else
     {
       $available_days = [0,0];
     }
     
     //print_r($available_days);exit;
     // echo $available_days[0];exit;
     
     if($status == 1)
     {
      if($available_days[0] == 1)
      {
        return true;
      }
      else
      {
        return false;
      }
     }

     if($status == 2)
     {
      if($available_days[1] == 1)
      {
        return true;
      }
      else
      {
        return false;
      }
     }
     // if(in_array($status, $available_days))
     // {
     //  return true;
     // }
     // else
     // {
     //  return false;
     // }


  }


  public function checkAvailabilityOfDoctorById($doctor_id,$date)
  {
    $response = array();
    $this->db->select("*");
    $this->db->from('Doctors');
    $this->db->join('Doctor_schedule','Doctors.id = Doctor_schedule.doctor_id');
    $this->db->where('Doctor_schedule.from_date <=',$date);
    $this->db->where('Doctor_schedule.to_date >=',$date);
    $this->db->where('Doctors.id ',$doctor_id);

    $data = $this->db->get();
    // echo $this->db->last_query();exit;
    // $evening_morning_status = $data->row()->evening_morning_status;
    // $response['data'] = $evening_morning_status;
    // echo $this->db->last_query();exit;
    if($data->num_rows() > 0)
    {
    
      $response['status'] = true;
    }
    else
    {
      $response['status'] = false;
    }
    return $response;

  }


  public function getDoctorEveningMorningAvailableStatus($doctor_id)
  {
    $this->db->select("*");
    $this->db->from('Doctors');
    $this->db->join('Doctor_schedule','Doctor_schedule.doctor_id = Doctors.id');
    $this->db->where('Doctors.id',$doctor_id);
    $schedule = $this->db->get()->row();
    
    if(!empty($schedule->evening_morning_status))
    {
      $data = $schedule->evening_morning_status;
    }
    else
    {
      $data = '';
    }
    
    return $data;
  }

  public function getSingleAppointmentByDoctorId($id,$token_number)
  {
    $this->db->select("Appointment.*,Doctor_schedule.morning_start_time,Doctor_schedule.morning_end_time,Doctor_schedule.evening_start_time,Doctor_schedule.evening_end_time,CONCAT(Doctors.first_name,' ',Doctors.last_name) as Doctor_name,Doctors.profession,Doctors.exp as Doctor_experience,Doctors.image as Doctor_image,Doctors.fees,Doctors.hospital_id as hospital,Doctors.address as Hospital_address");
    $this->db->from('Appointment');
    $this->db->join('Doctors','Doctors.id=Appointment.doctor_id','left');
    $this->db->join('Doctor_schedule','Appointment.doctor_id = Doctor_schedule.doctor_id','left');
    $this->db->where(array('Appointment.doctor_id'=>$id,'Appointment.appointment_id'=>$token_number));
    $data = $this->db->get()->row();
    return empty($data)?false:$data;
  }


   public function getSingleAppointmentByDoctorIdForShiffing($id,$token_number)
  {
    $this->db->select("Appointment.*,Doctor_schedule.morning_start_time,Doctor_schedule.morning_end_time,Doctor_schedule.evening_start_time,Doctor_schedule.evening_end_time,CONCAT(Doctors.first_name,' ',Doctors.last_name) as Doctor_name,Doctors.profession,Doctors.exp as Doctor_experience,Doctors.image as Doctor_image,Doctors.fees,Doctors.hospital_id as hospital,Doctors.address as Hospital_address");
    $this->db->from('Appointment');
    $this->db->join('Doctors','Doctors.id=Appointment.doctor_id','left');
    $this->db->join('Doctor_schedule','Appointment.doctor_id = Doctor_schedule.doctor_id','left');
    $this->db->where(array('Appointment.doctor_id'=>$id,'Appointment.appointment_id'=>$token_number));
    $data = $this->db->get()->row();
    return empty($data)?false:$data;
  }


  public function addAppointment($app)
  {
     if(!empty($app))
      {
        $this->db->insert('Appointment',$app);
        return $this->db->insert_id();  
      }
  }




  public function cancelAppointment($p,$d,$s=0,$a)
  {
    if($s==1)
    {
      $this->message = 'Approved';
    }
    else if($s==2)
    {
      $this->message = 'Cancelled';
    } 
    
    $this->db->select("*");
    $this->db->from('Appointment');
    $this->db->where(array('doctor_id'=>$d,'patient_id'=>$p,'appointment_id'=>$a,'status !='=>1));
    $data = $this->db->get()->result();
    if(count($data)<= 0)
    {
      $this->response['status']=true;
      $this->response['message'] ='Appointment Checked Successfully';
    }
    else 
    {
      $this->db->where(array('patient_id'=>$p,'doctor_id'=>$d,'appointment_id'=>$a));
      $this->db->update('Appointment',array('status'=>$s));
      $this->response['status']=true;
      $this->response['message'] ='Appointment '.$this->message.' Successfully';
    }
    return $this->response;
  }
  

  public function appointmentHistory($patient_id,$date ='',$shifting=0)
  {
    $this->db->select("Appointment.*,,CONCAT(Doctors.first_name,' ',Doctors.last_name) as Doctor_name,Doctors.profession,Doctors.fees,Doctors.hospital_id as hospital,Doctors.address");
    $this->db->from('Appointment');
    $this->db->join('Doctors','Doctors.id=Appointment.doctor_id');
    $this->db->order_by('Appointment.appointment_id','asc');
    
    // else
    // {
    //   $date = new DateTime("now");
    //   $curr_date = $date->format('Y-m-d');  
    // }
    $condition = array('patient_id'=>$patient_id);
    if(!empty($date))
    {
      $condition['Appointment.appointment_date'] = $date;
    }

    if(!empty($shifting))
    {
      $condition['shifting'] = $shifting;
    }
    
    
    $this->db->order_by('Appointment.appointment_id','desc');
    $this->db->where($condition);
    $data = $this->db->get()->result();
     // echo $this->db->last_query();exit;
    return empty($data)?false:$data;
  }


  public function CheckStatusOfAppointment($id,$date)
  {
     $this->db->select("*");
     $this->db->from('Appointment');
     $this->db->where(array('appointment_id'=>$id,'status'=>0));
     $count = $this->db->get()->num_rows();


     if($count > 0)
     {
      return true;
     }
     else
     {
      return false;
     }
  }

}
