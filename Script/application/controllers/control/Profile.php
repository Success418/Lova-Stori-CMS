<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Profile extends Admin_Core_Controller
    {
        protected $model            = 'profiles_model';
        protected $columns_prefix   = 'profile';




		function __construct()
		{
			Parent::__construct();

			$this->load->model('control/users_model');

            if(!check_permission())
                redirect('control/dashboard');
		}




		public function index()
		{
			if(!ctype_digit($_SESSION['user_id'] ?? NULL))
				redirect(base_url('control/dashboard'));

			$profile 	  = $this->users_model->get_profile((int)$_SESSION['user_id']);
			$page_title   = lang('ui_profile').' - '.lang('ui_edit');
            $partial      = '_profile';
        	$breadcrumbs  = 'Kontrol / '.lang('ui_profile').' / '. ucfirst($_SESSION['user_name']);

        	$this->load->view('control/item', compact('page_title', 
                                                      'partial', 
                                                      'breadcrumbs',
                                                      'profile'));
		}




		public function update()
		{
            $images_abs_path = FCPATH.'uploads/profiles';
			$user_data       = json_decode(base64_decode($this->input->post('user_data')));
        
            if(!$user_data) redirect("control/profile");

            # ----------------------------------------------------------- #

            $_POST['useremail_is_unique'] = 1;

            if($this->input->post('user_email') != $user_data->user_email)
            {
                $columns = ['id !=', 'user_email'];
                $values  = [$_SESSION['user_id'], $this->input->post('user_email', TRUE)];

                $_POST['useremail_is_unique'] = $this->users_model->is_unique('users',
                                                                $columns, $values)
                                               ? 1 : 0;
            }

            # ----------------------------------------------------------- #

            if($this->input->post('user_image_changed'))
            {
                # FILE UPLOAD CONFIG --------------------------------------
                $config['upload_path']       = FCPATH.'uploads/profiles/';
                $config['allowed_types']     = 'gif|jpg|jpeg|png|ico|svg';
                $config['file_ext_tolower']  = TRUE;
                $config['encrypt_name']      = FALSE;
                $config['overwrite']         = TRUE;
                $config['file_name']         = md5($_SESSION['user_id']);
                # ----------------------------------------------------------
                
                $imgs = glob("{$images_abs_path}/{$config['file_name']}.*");

                foreach($imgs as $img) unlink($img);

                $this->load->library('upload', $config);
                
                if(!$this->upload->do_upload('user_image'))
                {
                    $this->form_response = ['type'     => 'error', 
                                            'response' => $this->upload->display_errors()];

                    $this->session->set_flashdata('form_response', $this->form_response);

                    redirect("control/profile");
                }
                
                $user_image  = $this->upload->data('file_name');
                
                $_SESSION['user_image'] = $user_image;
            }


            $this->form_validation->set_rules('user_country', 'Country', 'max_length[2]')

                                  ->set_rules('user_email', 'Email', 
                                              'trim|strip_tags|required|valid_email')

                                  ->set_rules('useremail_is_unique', 'Keunikan email',
                                              'is_natural_no_zero', 
                                              ['is_natural_no_zero' => 'Email sudah digunakan']);

            if($this->form_validation->run())
            {
                $data = [
                    'user_email'     => $this->input->post('user_email', TRUE),
                    'user_about'     => $this->input->post('user_about', TRUE),
                    'user_firstname' => $this->input->post('user_firstname', TRUE),
                    'user_lastname'  => $this->input->post('user_lastname', TRUE),
                    'user_country'   => $this->input->post('user_country', TRUE),
                    'user_address'   => $this->input->post('user_address', TRUE),
                    'user_phone'     => $this->input->post('user_phone', TRUE),
                    'user_dob'       => $this->input->post('user_dob', TRUE),
                    'user_facebook'  => $this->input->post('user_facebook', TRUE),
                    'user_gplus'     => $this->input->post('user_gplus', TRUE),
                    'user_linkedin'  => $this->input->post('user_linkedin', TRUE),
                    'user_twitter'   => $this->input->post('user_twitter', TRUE),
                    'user_pinterest'   => $this->input->post('user_pinterest', TRUE),
                    'user_youtube'   => $this->input->post('user_youtube', TRUE),
                    'user_pwd'       => $this->input->post('user_pwd', TRUE)
                ];


                $data['user_pwd'] = $data['user_pwd']
                                    ? password_hash($data['user_pwd'], PASSWORD_ARGON2I)
                                    : NULL;
                                    
                $data = array_filter($data);

                $response = $this->users_model->update($user_data->id, $data, 
                                                       $user_image ?? NULL);
                if($response)
                {
                    $sessions = ['user_email'  => $data['user_email'],
                                 'user_image'  => $_SESSION['user_image'] 
                                                  ?? 'default.png'];

                    $this->session->set_tempdata($sessions, NULL, 86400);

                    $this->form_response = ['type' => 'success', 'response' => 'Berhasil!'];
                }
                else
                {
                    $this->form_response = ['type' => 'error', 'response' => 'Error!'];
                }
            }
            else
            {
                $this->form_response = ['type'     => 'error',
                                        'response' => $this->form_validation->error_array()];
            }

            
            $this->session->set_flashdata('form_response', $this->form_response);

            redirect("control/profile");
		}












	}