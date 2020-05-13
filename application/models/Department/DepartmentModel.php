<?php

class DepartmentModel extends CI_Model {
    public function addDepartment($data){
        $this->db->insert('Department',$data);
        return true;

    }

    public function getAllDepartments(){
        $this->db->select('*');
        $this->db->from('Department');
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDepartmentById($id){
        $this->db->select('*');
        $this->db->from('Department');
        $this->db->where('id',$id);
        $data = $this->db->get()->row();
        return $data;
      }


      public function editDepartment($data,$id){
        //   print_r($data);echo $id;exit;
        $this->db->where('id',$id);
        $this->db->update('Department',$data);
        
        return true;

      }
      public function deleteDepartmentById($id){
        $this->db->where('id',$id);
        $this->db->delete('Department');

      }
  
  
}