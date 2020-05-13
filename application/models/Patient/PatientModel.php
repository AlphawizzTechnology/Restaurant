<?php

class PatientModel extends CI_Model {
    public function AddDishes($data){
        $this->db->insert('dishes',$data);
        return true;
    }
    
    public function getRestaurantById($id){
        $this->db->select('*');
        $this->db->from('dishes');
        $this->db->where('id',$id);
        $data = $this->db->get()->row();
        return $data;
    }
    
    public function getAllRestaurant(){
        $this->db->select('*');
        $this->db->from('restaurant');
        $data = $this->db->get()->result();
        return $data;
    }
    

    public function isEmailAvailable($email){
     $this->db->select('*');
     $this->db->from('Patients');
     $this->db->where('email',$email);
     $data = $this->db->get()->result();
     if(!empty($data)){
       return true;
     }
     else {
       return false;
     }
     
    }

    public function getAllDishesh(){
        $this->db->select('*');
        $this->db->from('dishes');
        $data = $this->db->get()->result();
        return $data;  
    }

    public function getPatientById($id){
      $this->db->select('*');
      $this->db->from('Patients');
      $this->db->where('id',$id);
      $data = $this->db->get()->row();
      return $data;
    }

    public function updatePatient($data,$id)
    {
       $this->db->where('id',$id);
       $this->db->update('dishes',$data);
      
       return true;
    }

    public function deletePatientById($id){
      $this->db->where('id',$id);
    $this->db->delete('dishes');
    

    }

}