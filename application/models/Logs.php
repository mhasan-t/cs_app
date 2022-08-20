<?php 
class Logs extends CI_Model {
    public function __construct(){
        $this->load->database();
    }


    public function insert($msg, $id, $type){
        $data = array(
            'log_msg' => $msg,
            'user_id' => $id,
            'type' => $type
        );
        $this->db->insert('log_data', $data);
    }

    public function get_failure_log($id){
        $time = time()-600;
        $timestring = date("Y-m-d H:i:s",$time);

        $this->db->select('*');
        $this->db->from('log_data');
        $this->db->where('user_id', $id);
        $this->db->where('type', 'SUS');
        $this->db->where('created_at>=', $timestring);
        $query = $this->db->get(); 
        return $query->num_rows();
    }
}


?>