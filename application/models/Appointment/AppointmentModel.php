<?php

class AppointmentModel extends CI_Model {
    public function AddAppointment($data){
        $this->db->insert('Doctors',$data);
        return true;
    }

    public function getAllAppointment(){
        $this->db->select("Appointment.*,CONCAT(Doctors.first_name, ' ',Doctors.last_name) AS Docter_name");
        $this->db->from('Appointment');
        $this->db->join('Patients','Appointment.patient_id=Patients.id','left');
        $this->db->join('Doctors','Appointment.doctor_id=Doctors.id','left');
        // $this->db->join('Department','Appointment.department_id=Department.id','left');
        
        return $this->db->get()->result();

    }
    
    public function getAppointmentById($id){
        $this->db->select("Appointment.*,CONCAT(Patients.first_name, ' ',Patients.last_name) AS Patient_name ,Patients.image as Patient_image,CONCAT(Doctors.first_name, ' ',Doctors.last_name) AS Docter_name,Department.department_name");
        $this->db->from('Appointment');
        $this->db->join('Patients','Appointment.patient_id=Patients.id','left');
        $this->db->join('Doctors','Appointment.doctor_id=Doctors.id','left');
        $this->db->join('Department','Appointment.department_id=Department.id','left');
        $this->db->where('Appointment.appointment_id',$id);
        return $this->db->get()->row();
    }

    public function getDoctorsName(){
        $this->db->select('CONCAT(Doctors.first_name," ",Doctors.last_name )as doctor_name,id');
        $this->db->from('Doctors');
        return $this->db->get()->result();
    }

    public function getPatientsName(){
        $this->db->select('CONCAT(Patients.first_name," ",Patients.last_name ) as patient_name,id');
        $this->db->from('Patients');
        return $this->db->get()->result();
    }

    public function getDepartmentName(){
        $this->db->select('department_name,id');
        $this->db->from('Department');
        return $this->db->get()->result();
    }
    
   

    public function updateAppointment($data,$id)
    {
       $this->db->where('appointment_id',$id);
       $this->db->update('Appointment',$data);
       
       return true;
    }

    public function deleteAppointmentById($id){
      $this->db->where('appointment_id',$id);
      $this->db->delete('Appointment');

      return true;
    

    }

   


}