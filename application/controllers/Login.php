<?php
	class Login extends CI_Controller{
		public function view($page = 'login'){
			if(!file_exists(APPPATH.'views/'.$page.'.php')){
                // echo APPPATH.'views/'.$page.'.php';
				show_404();
			}

			$data['title'] = ucfirst($page);

			$this->load->view($page, $data);
		}

        public function check_for_suspicious_act($id){
            $occurance = $this->logs->get_failure_log($id);
            if($occurance>=9){
                $this->user_model->banUser($id);
                $this->logs->insert('User Banned.', $id, 'BAN');
                $data = array(
                    'msg' => 'You have been banned for suspicious activity.'
                );
                $this->load->view('error.php', $data);
                return 0;
            }
            else return 1;

            
        }

        public function viewSignup(){
            $this->load->view('signup.php');
        }

        public function signup(){
            $this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('passwd', 'Password', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
            if($this->form_validation->run() === FALSE){
                $data = array(
                    'msg' => '.'
                );
				$this->load->view('error.php', $data);
			} else {
				
				// Get username
				$username = $this->input->post('username');
				// Get and encrypt the password
				$password = md5($this->input->post('passwd'));
				$phone = $this->input->post('phone');
				$email = $this->input->post('email');

                $this->user_model->insert($username, $email, $phone, $password);
                $this->load->view('login.php');
            }


        }

        public function login(){

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('passwd', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view(APPPATH.'views/login.php');
			} else {
				
				// Get username
				$username = $this->input->post('username');
				// Get and encrypt the password
				$password = md5($this->input->post('passwd'));

				// Login user
				$user_id = $this->user_model->login($username, $password);

                if($this->check_for_suspicious_act($user_id)==0) return 0;

				if($user_id){
                    if($this->user_model->isBanned($user_id) == 1){
                        $data = array(
                            'msg' => 'You have been banned for suspicious activity.'
                        );
                        $this->load->view('error.php', $data);
                        return 0;
                    }

                    $this->session->set_userdata('id', $user_id);
                    $this->logs->insert('User logged in.', $user_id, 'LOGIN');
					redirect('2FA');
				}
                else {
                    $this->logs->insert('Someone tried to log in.', $user_id, 'LGN_ATMPT');
                    $data = array(
                        'msg' => 'Wrong email or password'
                    );
                    $this->load->view('error.php', $data);
                }
			}
		}

        public function choose2FA(){
            $user_id = $this->session->userdata('id');
            if($this->user_model->isBanned($user_id) == 1){
                $data = array(
                    'msg' => 'You have been banned for suspicious activity.'
                );
                $this->load->view('error.php', $data);
                return 0;
            }
            $this->logs->insert('User visited 2FA page.', $user_id, 'VST');
            $this->load->view('choose_tsv.php');
        }
        public function phone(){
            $user_id = $this->session->userdata('id');
            if($this->user_model->isBanned($user_id) == 1){
                $data = array(
                    'msg' => 'You have been banned for suspicious activity.'
                );
                $this->load->view('error.php', $data);
                return 0;
            }
            $this->logs->insert('User chose OTP as verification method.', $user_id, 'SLCT');
            $this->load->view('phone.php');
        }

        function generateRandomString($length = 15) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        public function email(){
            $user_id = $this->session->userdata('id');
            if($this->user_model->isBanned($user_id) == 1){
                $data = array(
                    'msg' => 'You have been banned for suspicious activity.'
                );
                $this->load->view('error.php', $data);
                return 0;
            }
            $this->logs->insert('User chose E-Mail as verification method.', $user_id, 'SLCT');
            $to = $this->user_model->get_email($this->session->userdata('id'));

            $config = Array(
                'protocol' => 'smtp',
                // 'smtp_host' => 'smtp.gmail.com',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'tahnoon19@gmail.com', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'wordwrap' => TRUE
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('tahnoon19@gmail.com', 'Muhib Al Hasan');
            $this->email->to($to);
            
            $key = $this->generateRandomString();
            $this->verification_keys->insert($key, $this->session->userdata('id'));
            $this->email->subject('Verification Key');
            $this->email->message('Your key is - '.$key);

            if($this->email->send(FALSE)) 
                $this->session->set_flashdata("email_sent","Email sent successfully. Enter Code."); 
            else {
                show_error($this->email->print_debugger());
                $this->session->set_flashdata("email_sent","Error in sending Email."); 
            }

            $this->load->view('email.php');

            
        }
        public function verify_email(){
            $user_id = $this->session->userdata('id');
            if($this->user_model->isBanned($user_id) == 1){
                $data = array(
                    'msg' => 'You have been banned for suspicious activity.'
                );
                $this->load->view('error.php', $data);
                return 0;
            }
            $email = $this->user_model->get_email($this->session->userdata('id'));
            $key = $this->verification_keys->get_latest_key($this->session->userdata('id'));

            $code = $this->input->post('code');

            if($key != false && $code==$key){
                $data = array(
                    'msg' => 'User successfully verified.'
                );
                $this->user_model->verifyUser($user_id);
                $this->logs->insert('User E-Mail verified.', $user_id, 'SUCCESS');
                $this->load->view('success.php', $data);
            }
            else {
                $data = array(
                    'msg' => 'Verification unsuccessfull. Please enter the code carefully and check the validity'
                );
                $this->logs->insert('User failed to verify email.', $user_id, 'SUS');
                if($this->check_for_suspicious_act($user_id)==0) return 0;
                $this->load->view('error.php', $data);
            }
        }
	}   