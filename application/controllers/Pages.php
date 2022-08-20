<?php 
class Pages extends CI_Controller{
    public function for_admin(){
        $user_id = $this->session->userdata('id');
        if($this->user_model->isBanned($user_id) == 1){
            $data = array(
                'msg' => 'You have been banned for suspicious activity.'
            );
            $this->load->view('error.php', $data);
            return 0;
        }

        $isAdmin = $this->user_model->isAdmin($this->session->userdata('id'));
        $this->logs->insert('Admin visited foradmin page.', $user_id, 'VST');

        if($isAdmin!=1){
            $this->load->view('unauth');
        }else {
            $this->load->view('foradmin');
        }
    }
    public function for_user(){
        $user_id = $this->session->userdata('id');
        if($this->user_model->isBanned($user_id) == 1){
            $data = array(
                'msg' => 'You have been banned for suspicious activity.'
            );
            $this->load->view('error.php', $data);
            return 0;
        }

        $this->logs->insert('User/Admin visited foruser page.', $user_id, 'VST');
        $this->load->view('foruser');
    }
}


?>