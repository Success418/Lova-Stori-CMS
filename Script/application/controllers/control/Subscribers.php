<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');



	class Subscribers extends Admin_Core_Controller
	{
	    protected $model            = 'subscribers_model';
	    protected $columns_prefix   = 'subscriber';



		function __construct()
		{
			Parent::__construct();
			$this->load->model('control/subscribers_model')
					   ->library('mailer');
			if(!check_permission())
				redirect('control/dashboard');
		}



		public function index()
		{
			$uri_params = $this->uri->uri_to_assoc(4, ['page', 'orderby', 'order']);
            $order = $uri_params['order'];
            if($order === 'desc') $order = 'asc';
            elseif($order === 'asc') $order = 'desc';
            else $order = 'asc';
            extract($this->subscribers_model->get($uri_params));
          	$page_title        = lang('ui_subscribers');
            $partial           = '_subscribers';
          	$breadcrumbs       = "Kontrol / {$page_title}";
          	$filters_base_url  = base_url('control/newsletter/subscribers/orderby');
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'subscribers',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
		}




		public function add()
		{
			if($this->input->method() === 'post')
			{
				$emails = $this->input->post('newsletter_emails', TRUE);
				$emails = explode(',', $emails);
				
				$_POST['emails_count'] = count($emails) ?? 0;

				foreach($emails as $key => &$email)
				{
					$email = trim($email);
					if(!filter_var($email, FILTER_VALIDATE_EMAIL))
						unset($emails[$key]);
				}


				$this->form_validation->set_rules('newsletter_subject',
												  'Subject',
												  'required|trim')
									  ->set_rules('newsletter_body',
									  			  'Content',
												  'required|trim');
				
				if(!count($emails))
				{
					$emails = $this->subscribers_model->emails();
				}

				if(!$emails)
				{
					$this->form_response = ['type' => 'error', 
											'response' => 'Tidak ada email yang disediakan.'];

					$this->session->set_flashdata('form_response',
											  $this->form_response);

					redirect("control/newsletter/send");
				}
				

				if($this->form_validation->run())
				{
					$subject = $this->input->post('newsletter_subject', TRUE);
					$body    = $this->input->post('newsletter_body', FALSE);
					$settings 	  = $this->settings;
					$site_name    = $settings['site_name'] ?? '{site_name}';
					$email_data = ['subject' => "{$subject} - {$site_name}", 
					               'from'    => $this->settings['site_admin_email'] ?? '',
								   'to' 	 => $emails,
								   'body' 	 => "
								   
								   
								   
								   
								   
<table style='margin: auto;border-spacing: 0;width:630px' border='0'>
  <tbody>
    <tr>
      <td style='text-align: center;padding:0'>
        <p style='text-align: center;margin:0'><a href='https://www.medialova.com' class='logo'><img alt='Image' src='https://1.bp.blogspot.com/-_LCUYp5jecs/XlwQ7gVogxI/AAAAAAAAABg/OdrpUjXAekEH1oVa2GGgbMqSDQIDdR57gCLcBGAsYHQ/s1600/logo.png' style='width:630px'></a></p>
        
        <p style='text-align: center;margin:0'><img alt='Image' src='https://1.bp.blogspot.com/-JKQBw89d9u4/XlwRitwlloI/AAAAAAAAABo/fiI5fIFhO7syr5pf7KghVEotoIOhv8qdQCLcBGAsYHQ/s1600/kontributor.png' style='width:630px'></p>
        
<table style='width:630px;border-spacing: 0;margin:auto' border='0'>
  <thead>
    <tr>
      <th style='width: 25%; background-color: #EC8A22; padding: .25rem'></th>
      <th style='width: 25%; background-color: #679047; padding: .25rem'></th>
      <th style='width: 25%; background-color: #D53540; padding: .25rem'></th>
      <th style='width: 25%; background-color: #009888; padding: .25rem'></th>
    </tr>
  </thead>
</table>        
        
        
        <br>
        
        <h1 style='text-align: center;font-size:35px;font-family:arial,helvetica,sans-serif;margin:0'>Hai Sahabat Netizen</h1>
        
        <br>
        
        <p style='font-size:20px;font-weight:bold;font-family:arial,helvetica,sans-serif;;margin:0'>INFORMASI UNTUK KAMU.<br /></p>
        
        <br>
        
        <div style='background-color: White; border: 2px #E60045 dotted; padding: 10px; text-align: center;'>								   
								   
								   
								   {$body}
								   
								   
								   
        </div>
        
        <br>
        
        
        <p style='text-align: center;margin:0'><img alt='Image' src='https://1.bp.blogspot.com/-GohATAgyS6s/XlwRyht_rPI/AAAAAAAAABw/IPB13RYzk-AMp-RmkgUB9ebJocuvSVuYwCLcBGAsYHQ/s1600/favicon.ico' style='width:48px'></p>
        
        <a href='https://www.medialova.com/medialova.apk' class='Android'>
          <img alt='Image' src='https://1.bp.blogspot.com/-i0umzAcnT04/XlwSTL53qWI/AAAAAAAAAB4/VfMpAwRbSu0BqL27ORtVySorywA8JREmgCLcBGAsYHQ/s1600/playstore.png' style='width:150px'></a>        
        
        <br>
        
        <p style='font-weight:bold;font-size:40px;font-family:arial,helvetica,sans-serif;margin:0'>PT. MEDIALOVA PRODUCTION</p>
        <p style='font-weight:bold;font-size:15px;font-family:arial,helvetica,sans-serif;'>© Copyright 2020 - All Rights Reserved Medialova Production</p>
        
        <p style='text-align: center;margin:0'><img alt='Image' src='https://1.bp.blogspot.com/-jkI4uBuy2Fc/XlwSYKqEaqI/AAAAAAAAACA/1drWHZUFmZ8cZogakspmrBhELmuDAq20ACLcBGAsYHQ/s1600/kontributor2.png' style='width:630px'></p>
        

<table style='width:630px;border-spacing: 0;margin:auto' border='0'>
  <thead>
    <tr>
      <th style='width: 25%; background-color: #EC8A22; padding: .25rem'></th>
      <th style='width: 25%; background-color: #679047; padding: .25rem'></th>
      <th style='width: 25%; background-color: #D53540; padding: .25rem'></th>
      <th style='width: 25%; background-color: #009888; padding: .25rem'></th>
    </tr>
  </thead>
</table>        
        
        
        <div style='background-color: lightyellow; border: 2px dotted rgb(230, 0, 69); padding: 10px; text-align: center;'>
         <p style='font-size:11px;color:#000000;margin:0'>Pesan ini dikirim sesuai alamat email yang Anda daftarkan.</p>
        
          <p style='font-size:11px;color:#000000;margin:0'>Jangan membalas email dari kami, karena email ini tidak kami pantau.</p>
        
          <p style='font-size:11px;color:#000000;margin:0'>Jika Anda merasa tidak pernah mendaftarkan alamat email ini</p>
        
          <p style='font-size:11px;color:#000000;margin:0'>sebagai pendaftaran, silahkan lapor: lapor@medialova.com</p>
        </div>
      </td>
    </tr>
  </tbody>
</table>
								   
								   
								   
								   
								   
								   
								   
								   
								   ",
								   'name'    => $this->settings['site_name'] ?? ''];
					
					
					$mailer = new Mailer();
					$mail_status = @$mailer->init($this->settings)
					   		   		   ->send($email_data);
					if(!$mail_status)
					{
						$this->form_response = ['type' => 'error', 
												'response' => 'Kesalahan yang tidak diketahui'];
					}
					else
					{
						$this->form_response = ['type' => 'success', 
												'response' => 'Berhasil!'];

						$this->session->set_flashdata('form_response',
											  $this->form_response);
					}
				}
				else
				{
					$this->form_response = ['type' 	 => 'error',
								  	    	'response' => $this->form_validation->error_array()];
				}

				$this->session->set_flashdata('form_response',
											  $this->form_response);

				redirect("control/newsletter/send");
			}

			$page_title        = 'Surat Berita';
            $partial           = '_newsletter';
          	$breadcrumbs       = 'Kontrol / Surat Berita';
            $this->load->view('control/item', compact('page_title',
                                                      'partial',
                                                      'breadcrumbs'));
		}
	}