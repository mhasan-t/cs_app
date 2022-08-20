<?php 
class Verification_keys extends CI_Model {
    public function __construct(){
        $this->load->database();
    }


    public function insert($key, $id){
        $time = time()+600;
        $timestring = date("Y-m-d H:i:s",$time);
        $data = array(
            'var_key' => $key,
            'valid_till' => $timestring,
            'user_id' => $id
        );
        $this->db->insert('verification_keys', $data);
    }
    public function get_latest_key($id){
        $this->db->select('var_key, valid_till');
        $this->db->from('verification_keys');
        $this->db->where('user_id', $id);
        $this->db->order_by("valid_till", "desc");
        $this->db->limit(1);
        $query = $this->db->get(); 

        $key = $query->row(0)->var_key;
        $valid = strtotime($query->row(0)->valid_till);

        $time = time();


        if($time < $valid){
            return $key;
        }
        else {
            return false;
        }

        
    }

}


?>