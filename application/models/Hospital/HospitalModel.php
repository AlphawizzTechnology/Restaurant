<?php

class HospitalModel extends CI_Model {
    public function addHospital($data){
        $this->db->insert('Hospital',$data);
        return true;

    }

    public function getAllHospital(){
        $this->db->select('*');
        $this->db->from('Hospital');
        return $this->db->get()->result();
    }

    public function getHospitalById($id){
        $this->db->select('*');
        $this->db->from('Hospital');
        $this->db->where('id',$id);
        return $this->db->get()->row();
    }

    public function updateHospital($data,$id){
        $this->db->where('id',$id);
       $this->db->update('Hospital',$data);
       return true;
    }

    public function deleteHospitalById($id){
        $this->db->where('id',$id);
      $this->db->delete('Hospital');
      
  
      }
}