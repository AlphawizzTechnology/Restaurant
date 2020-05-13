<?php

class DashboardModel extends CI_Model 
{
    public function getAllDoctorCount()
    {
        $this->db->select('*');
        $this->db->from('restaurant');
        return $this->db->get()->num_rows();
    }

    public function getAllDoctor()
    {
        $this->db->select('Doctors.id,Doctors.education,Doctors.image,CONCAT(Doctors.first_name," ",Doctors.last_name) as Doctor_name');
        $this->db->from('Doctors');
        return $this->db->get()->result();
    }


    public function getLatestAppoinment()
    {
        $this->db->select("Appointment.*,Patients.email,Patients.phone_number,Patients.disease,Patients.id,CONCAT(Patients.first_name, ' ',Patients.last_name) AS Patient_name ,Patients.image as Patient_image,CONCAT(Doctors.first_name, ' ',Doctors.last_name) AS Doctor_name");
        $this->db->from('Appointment');
        $this->db->join('Patients','Appointment.patient_id=Patients.id','left');
        $this->db->join('Doctors','Appointment.doctor_id=Doctors.id');

        $this->db->where('Appointment.status',0);
        $this->db->order_by('Appointment.appointment_id');
        return $this->db->get()->result();
    }

    public function getPatients()
    {
        $this->db->select('Patients.email,Patients.phone_number,Patients.image,Patients.disease,CONCAT(first_name," ",last_name) as Patient_name');
        $this->db->from("Patients");
        $data = $this->db->get()->result();
        return $data;
        
    }


    public function getAllPatientsCount()
    {
        $this->db->select('*');
        $this->db->from('dishes');
        return $this->db->get()->num_rows();
    }

    public function approveAppointment($id)
    {
        $this->db->where('appointment_id',$id);
        $this->db->update('appointment',array('status'=>1));
        return true;
    }

    public function getAttendPatientCount()
    {
        $this->db->select("*");
        $this->db->from('Appointment');
        $this->db->where('Appointment.status',1);
        return $this->db->get()->num_rows();
    }

    public function getPendingPatientCount()
    {
        $this->db->select("*");
        $this->db->from('Appointment');
        $this->db->where('Appointment.status',0);
        return $this->db->get()->num_rows();
    }

    
}