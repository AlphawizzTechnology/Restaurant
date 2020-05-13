<?php

class LoginApiModel extends CI_Model {
    public function __construct(){
     
        $this->table_name = '';
        $this->logged_in_with='';
        $this->response=array();
    }
    
    public function GetAllRestaurantr(){
        $this->db->select("*");
        $this->db->from('restaurant');
        $data = $this->db->get()->result();
        return $data;
    }
    
    public function GetAllDishesh($id){
        $this->db->select("*");
        $this->db->from('dishes');
        $this->db->where('restaurant_id',$id);
        $data = $this->db->get()->result();
        return $data;
    }
    
    

    public function getRows($data, $login_type){

      if($login_type == 1){
        $table = 'Doctors';
      }
      else {
        $table = 'Patients';
      }
     
     $this->db->select("id, username, phone_number");
     $this->db->from($table);
     $this->db->where('phone_number',$data['phone_number']);
     $data1 = $this->db->get()->row();
     
     (empty($data1))?$count=0:$count = count($data1);


     if($count > 0)
     {
      if($data['phone_number'] == $data1->phone_number)
      {


      $this->response['status'] = 1;
      $this->response['message'] = 'Login successfully.';
      $this->response['data'] = $data1;
      $this->response['logged_as'] =$this->logged_in_with;   
      }
      else
      {
      $this->response['status'] = 0;
      $this->response['message'] = 'Incorrect Phonenumber';
      }
      
     }

     else 
     {
        $this->response['status'] = 1;
        $this->response['message'] = 'Mobile No Not Registered';
     }
     return $this->response;
    }

    public function insert_patient($data){
        $this->db->insert('Patients',$data);
       if($this->db->affected_rows() >0) {
           $this->response['status'] = false;
           $this->response['message'] = 'Unable to insert';
           
       }
       else {
        $this->response['status'] = false;
        $this->response['message'] = 'Inserted successfully';
       }
       return $this->response;
    }


    public function insert_doctor($data){
        $this->db->insert('Doctors',$data);
       if($this->db->affected_rows() >0) {
           $this->response['status'] = false;
           $this->response['message'] = 'unable to insert';
           
       }
       else {
        $this->response['status'] = false;
        $this->response['message'] = 'inserted successfully';
       }
       return $this->response;
    }


    public function checkEmail($email,$slug){
        if($slug == 1){
            $table = 'Patients';
        }
        else {
            $table = 'Doctors';
        }
        
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where('email',$email);
        $data = $this->db->get()->result();
        
        if(!empty($data)){
         if(count($data)>0){
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


    public function checkPhoneNumber($forget_type,$phone_number)
    {

      if($forget_type == 2)
      {
        $table = 'Doctors';
      }
      if($forget_type == 1) 
      {
        $table = 'Patients';
      }
     
      

      $this->db->select("*");
      $this->db->from($table);
      $this->db->where(array('phone_number'=>$phone_number));
      $count = $this->db->get()->num_rows();
   /*   echo $count;
     echo $str = $this->db->last_query();
      exit();*/

      if($count > 0){
        return true;
      }
      else {
        return false;
      }
    }

    public function changePassword($phone_number,$password,$user_type)
    {
      if($user_type == 1){
        $table = 'Doctors';
      }
      else {
        $table = 'Patients';
      }
      $this->db->select("*");
      $this->db->from($table);
      $this->db->where('phone_number',$phone_number);
      $count = $this->db->get()->num_rows();
      
      if($count <= 0){
      return false;
      }
      else {
      $this->db->where('phone_number',$phone_number);
      $this->db->update($table, array('password'=>$password));
      
      return true;
      }
    }

    public function editProfile($user_type,$id,$app)

  {

    if($user_type == 1)
    {
      $table = "Patients";
    }
    else{
      $table = "Doctors";
    }

     if(!empty($app))

      {

        $this->db->where('id',$id);

       $this->db->update($table,$app);

       

       return true;

      }

  }
    
    public function UpdateOtp($data){
        if($data['type'] == 2){
        $table = 'Doctors';
          }
          else {
            $table = 'Patients';
          }
        $this->db->where('phone_number',$data['Phone']);
        $this->db->update($table, array('otp'=>$data['otp']));
        return true;
    }

    public function checkContact($contact,$slug){
        if($slug == 1){
            $table = 'Patients';
        }
        else {
            $table = 'Doctors';
        }
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where('phone_number',$contact);
        $data = $this->db->get()->result();
        if(!empty($data)){
         if(count($data)>0){
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


    public function user_booking($data){
        $this->db->insert('booking',$data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function editBooking($data,$id){
        $this->db->where('id',$id);   
        $update = $this->db->update('booking',$data);
        if($update){
          return true;
        }else{
          return false;
        }
    }

    public function getBooking(){
      $this->db->select('*');
      $this->db->from('booking');
      $data = $this->db->get()->result();
      return $data;
    }

    public function getprofile($user_id,$user_type){
      if($user_type == 1)
      {
        $table = "Patients";

      }
      else{
        $table = "Doctors";
      }
      $this->db->select('*');
      $this->db->from($table);
      $this->db->where('id',$user_id);
      $data = $this->db->get()->result();
      return $data;
    }

    public function getBookingByUserid($user_id){
      $this->db->select('booking.*,Patients.username,Patients.phone_number,Patients.image');
      $this->db->from('booking');
      $this->db->join('Patients','Patients.id=booking.user_id');
      $this->db->where('user_id',$user_id);

      $data = $this->db->get()->result();
      return $data;
    }

    public function getvehiclebycatid($cat_id){
      $this->db->select('id,name');
      $this->db->from('vehicle');
      
      $this->db->where('cat_id',$cat_id);

      $data = $this->db->get()->result();
      return $data;
    }
    
    public function deleteBooking($id){
      $this->db->select('*');
      $this->db->from('booking');
      $this->db->where('id',$id);
      $data = $this->db->get()->result();
      if($data){
      $this->db->where('id', $id);
      $this->db->delete('booking');
      return true;
      }
      else{
        return false;
      }
    }
}  