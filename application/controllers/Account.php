<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends Public_Controller {

	public function __construct() {
	    parent::__construct();
        /* stadium radius distance */
        $this->radius_distance = 5;
       // $this->load->library(['ion_auth', 'form_validation']);
	    /* Load :: Language */
	   // $this->lang->load('public/account');
        //$this->lang->load('auth');
	    /* Load :: Common */
        $this->load->model('public/account_model');
	    //$this->load->model('general_model');
	}



    public function seller_login() {
   
            $this->page_title->push(lang('header_login'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Validate form input */
            $validation = array(
                array(
                    'field' => 'identity',
                    'label' => 'mobile',
                    'rules' => 'required',
                    'errors' => array('required' => 'Please enter %s.')
                    ),
                array(
                    'field' => 'otp',
                    'label' => 'otp',
                    'rules' => 'required',
                    'errors' => array('required' => 'Please enter %s.')
                    )
                );
            $this->form_validation->set_rules($validation);

            if($this->form_validation->run() == true) {
				//print_r($this->input->post());exit;
                $login = $this->account_model->seller_login($this->input->post('identity'), $this->input->post('otp'), $remember = FALSE);
                if ($login) {
                    if ($login->acnt_status==1) {
                    $obj= array();
                    $obj['user_id']=$login->id;
                    $obj['email_id']=$login->email_id;
                    $obj['mobile_no']=$login->mobile_no;
                    $obj['seller_name']=$login->seller_name;
                    $this->session->set_userdata($obj);
                    redirect('seller/seller/dashboard');
                   // echo "dsdj"; die;
                  }else{
                    //$this->session->set_flashdata('message','Your account is not active');
                    $this->session->set_flashdata('message', ['1','Your account is not active.']);

                    redirect('account/seller_login', 'refresh');
                  }
                } else {
                    //$this->session->set_flashdata('message','Invalid mobile number and otp');
                    $this->session->set_flashdata('message', ['1','Invalid mobile number and otp.']);

                    redirect('account/seller_login', 'refresh');
                }
            } else {
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->template->seller_render('seller/seller_login', $this->data);
            }
       
    }

    

    public function seller_register()
    {
        
            $this->page_title->push(lang('header_login'));
            
            /* Validate form input */
            $validation = [
                [
                    'field' => 'name',
                    'label' => 'name',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'mobile_number',
                    'label' => 'mobile number',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'email',
                    'label' => 'email',
                    'rules' => 'required|valid_email|is_unique[ecom_sellers.email_id]',
                    'errors' => ['required' => 'Please enter %s.', 'valid_email' => 'Please enter valid %s.', 'is_unique' => 'Email already exists']
                ],
                [
                    'field' => 'password',
                    'label' => 'password',
                    'rules' => 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                
            ];

            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == true) {    
                //echo "<pre>";                print_r($_FILES); die;
				// print_r($this->input->post());exit;
                $additional_data = ['seller_name'=>$this->input->post('name'),
                'email_id'=>$this->input->post('email'),
                'email_otp'=>$this->input->post('email_otp'),
                'mobile_no'=>$this->input->post('mobile_number'),
                'mobile_otp'=>$this->input->post('mobile_otp'),
                'address'=>$this->input->post('address'),
                'id_proof'=>$this->input->post('id_proof'),
                'id_number'=>$this->input->post('id_number'),
                'password'=>md5($this->input->post('password'))];

             /*-----------------id_document----------------------*/
               if(isset(($_FILES['id_document']['name'])))
               {
                 $id_document_path='./uploads/users/seller/id_document/';
                 $new_file_name=$this->account_model->file_upload('id_document',$id_document_path);
                 $additional_data['id_document'] = 'uploads/users/seller/id_document/'.$new_file_name;
              }
              /*-----------------cin----------------------*/  
              if(isset(($_FILES['cin']['name'])))
               {
                 $cin_path='./uploads/users/seller/cin/';
                 $new_file_name=$this->account_model->file_upload('cin',$cin_path);
                 $additional_data['cin'] = 'uploads/users/seller/cin/'.$new_file_name;
               }
              /*-----------------pan----------------------*/  
              if(isset(($_FILES['pan']['name'])))
               {
                 $pan_path='./uploads/users/seller/pan/';
                 $new_file_name=$this->account_model->file_upload('pan',$pan_path);
                 $additional_data['pan'] = 'uploads/users/seller/pan/'.$new_file_name;
              }
            
             /*-----------------tan----------------------*/  
             if(isset(($_FILES['tan']['name'])))
               {
                 $tan_path='./uploads/users/seller/tan/';
                 $new_file_name=$this->account_model->file_upload('tan',$tan_path);
                 $additional_data['tan'] = 'uploads/users/seller/tan/'.$new_file_name;

               }
             /*-----------------gstin----------------------*/  
             if(isset(($_FILES['gstin']['name'])))
               {
                 $gstin_path='./uploads/users/seller/gstin/';
                 $new_file_name=$this->account_model->file_upload('gstin',$gstin_path);
                 $additional_data['gstin'] = 'uploads/users/seller/gstin/'.$new_file_name;
              }
           /*-----------------udyam----------------------*/  
              if(isset(($_FILES['udyam']['name'])))
               { 
                 $udyam_path='./uploads/users/seller/udyam/';
                 $new_file_name=$this->account_model->file_upload('udyam',$udyam_path);
                 $additional_data['udyam'] = 'uploads/users/seller/udyam/'.$new_file_name; 
                } 
                 //echo "<pre>";
                 //print_r($additional_data);exit;

                /* Register new business  */
                $register = $this->account_model->register_seller($additional_data);
                if ($register) {
					$this->session->set_flashdata('message', ['1','Your registration successfully.']);
                            redirect('account/seller_register', 'refresh');
                } else {
                    $this->session->set_flashdata('message', ['0','Your registration failed.']);
                    redirect('account/seller_register', 'refresh');
                }
            } else {
                //$this->data['company_types'] = $this->account_model->company_types();
                // print_r($this->data['business_types']);exit;
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->template->public_render('public/seller_register', $this->data);
            }
      
    }


    public function check_email_exists() {
        $email = $this->input->post('email');
        $found = $this->general_model->getOne('sellers', ['email' => $email]);
        if (!empty($found)) {
            $response = [
                'resultcode' => 0,
                'message' => 'Email address already exist'
            ];
        } else {
            $response = [
                'resultcode' => 1,
                'message' => ""
            ];
        }
        echo json_encode($response);
    }

	
	public function seller_logout() {
		$this->data['title'] = "Logout";

		// log the user out
		//$this->ion_auth->seller_logout();

		// redirect them to the login page
		redirect('account/seller_login', 'refresh');
	}
}
