<?php  

class ScheduleModel extends CI_Model {
    public function getDoctors()
    {
        $this->db->select('CONCAT(Doctors.first_name," ",Doctors.last_name) as doctor_name,Doctors.id');
        $this->db->from('Doctors');
        return $this->db->get()->result();
    }


    public function getDepartment(){
        $this->db->select('*');
        $this->db->from('Department');
        return $this->db->get()->result();
    }

    public function AddSchedule($data){

        $this->db->insert('Doctor_schedule',$data);
        
        return true;
    }
    
    public function getAllSchedule(){
        $this->db->select('Doctor_schedule.id,Doctor_schedule.available,CONCAT(Doctor_schedule.morning_start_time,"-",Doctor_schedule.morning_end_time) as Morning_time,CONCAT(Doctor_schedule.evening_start_time,"-",Doctor_schedule.evening_end_time) as Evening_time,CONCAT(Doctors.first_name," ",Doctors.last_name) as doctor_name,Doctors.image,Department.department_name');
        $this->db->from('Doctor_schedule');
        $this->db->join('Doctors','Doctors.id=Doctor_schedule.doctor_id');
        $this->db->join('Department','Department.id=Doctor_schedule.department_id','left');
        $data = $this->db->get()->result();
       
        return $data;  
    }

    public function updateSchedule($data,$id)
    {
         //unset($data['id']);
           $json_available = json_encode($data['available']);
       

       $update = array('available'=>$json_available,'start_time' =>$data['start_time'], 'end_time'=>$data['end_time'], 'department_id' =>$data['department_id'],'status' =>$data['status']);
       
       $this->db->where('id',$id);
       $this->db->update('Doctor_schedule',$update);
       // echo $this->db->last_query();exit;
       
       return true;
       
    }

    public function getScheduleById($id){
        $this->db->select('*');
        $this->db->from('Doctor_schedule');
        $this->db->where('id',$id);
        return $this->db->get()->row();
    }

    public function deleteScheduleById($id){
        $this->db->where('id',$id);
      $this->db->delete('Doctor_schedule');
      
  
      }


    
}