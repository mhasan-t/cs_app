<?php 
class User_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }


    public function insert($username, $email, $phone, $passwd){
        $data = array(
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'passwd' => $passwd
        );
        $this->db->insert('users', $data);
    }


    // Log user in
    public function login($username, $password){
        // Validate


        $this->db->where('username', $username);
        $this->db->where('passwd', $password);

        $result = $this->db->get('users');

        if($result->num_rows() == 1){
            return $result->row(0)->id;
        } else {
            return false;
        }
    }

    public function get_email($id){
        $this->db->where('id', $id);

        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return $result->row(0)->email;
        } else {
            return false;
        } 
    }
    public function get_phone($id){
        $this->db->where('id', $id);

        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return $result->row(0)->phone;
        } else {
            return false;
        } 
    }
    public function isAdmin($id){
        $this->db->where('id', $id);

        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return $result->row(0)->role=='ADMN';
        } else {
            return false;
        } 
    }

    public function isBanned($id){
        $this->db->where('id', $id);

        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return $result->row(0)->isBanned;
        } else {
            return false;
        } 
    }

    public function banUser($id){
        $this->db->where('id', $id);
        $this->db->update('users', array('isBanned' => 1));
    }

    public function verifyUser($id){
        $this->db->where('id', $id);
        $this->db->update('users', array('verified' => 1));
    }
}


?>