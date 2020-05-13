<?php

class AdminLoginModel extends CI_Model {
    public function CheckAdmin($data){
        $data['Password'] = md5($data['Password']);
        
        $this->db->select('*');
        $this->db->from('Admin');
        $this->db->where($data);

        $data = $this->db->get()->result();
        
        $this->session->set_userdata('admin',$data);
        if(count($data) > 0){
            return true;
        }
        else {
            return false;
        }
    }

    public function checkEmailAvailable($email){
        $response = array();
        $this->db->select('*');
        $this->db->from('Admin');
        $this->db->where('Email',$email);
        $data = $this->db->get()->row();
        
        $response['username'] = $data->Username;
        $response['first_name'] = $data->first_name;
        if(count($data) > 0){
            $response['status']=true;
        }
        else {
            $response['status']=false;
        }

        return $response;
    }


    public function changePassword($password,$email){
      
        $update_data = array('Password'=>md5($password));
        $this->db->where('Email',$email);
        $this->db->update('Admin',$update_data);
        
        // echo $this->db->last_query();exit;
        return true;
    }

    public function getAdminProfile($id){

        $this->db->select('*');
        $this->db->from('Admin');
        $this->db->where('id',$id);
        $data = $this->db->get()->row();
        
        return $data;
    }

    public function updateAdmin($data,$id)
    {
       $this->db->where('id',$id);
       $this->db->update('Admin',$data);
      
       return true;
    }

    public function updatePassword($data,$id){
     $array = array('Password'=>md5($data));
     $this->db->where('id',$id);
     $this->db->update('Admin',$array);
    
    
     return true;
    }

    public function checkOldPassword($old_password,$id){
      $this->db->select("*");
      $this->db->from('Admin');
      $this->db->where('Password',md5($old_password));
      $data = $this->db->get()->result();
      
      if(!empty($data)){
      if(count($data) > 0){
          return true;
      }
      else {
          return false;
      }
    }
    else {
        return false;
    }
    }



    // public function isLoggedIn(){
    //     if(!empty())
    // }
}