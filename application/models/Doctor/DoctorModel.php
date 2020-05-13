<?php

class DoctorModel extends CI_Model {
    public function AddRestaurant($data){
        $this->db->insert('restaurant',$data);
        return true;
    }

    public function isEmailAvailable($email){
     $this->db->select('*');
     $this->db->from('Doctors');
     $this->db->where('email',$email);
     $data = $this->db->get()->result();
     if(!empty($data)){
       return true;
     }
     else {
       return false;
     }
     
    }


    public function getAllRestaurant(){
        $this->db->select('*');
        $this->db->from('restaurant');
        $data = $this->db->get()->result();
        
        return $data;  
    }
 
    public function getDocterById($id){
      $this->db->select('*');
      $this->db->from('restaurant');
      $this->db->where('id',$id);
      $data = $this->db->get()->row();

      return $data;
    }

    public function updateRestaurant($data,$id)
    {
       $this->db->where('id',$id);
       $this->db->update('restaurant',$data);
       return true;
    }

    public function hospital_list(){
      $this->db->select("*");
      $this->db->from('Hospital');
      $data = $this->db->get()->result();
      
      return $data;
    }

    public function departments(){
      $this->db->select("*");
      $this->db->from('Department');
      return $this->db->get()->result();
    }

    

    public function deleteDocterById($id){
      $this->db->where('id',$id);
    $this->db->delete('restaurant');
    

    }

}