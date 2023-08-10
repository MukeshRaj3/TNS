<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Account
 * Create class for account handling
*/
class Seller extends REST_Controller {

    public function __construct() {
        parent::__construct();
        /* Load :: Helper */
        $this->lang->load('auth');
        $this->lang->load('API/account');
        /* Load :: Models */
        $this->load->model('v1/seller_model');

        $this->form_validation->set_error_delimiters(' | ', '');
    }

    /**
     * User login
     * Method (POST)
     */
    
    
     public function login_post() {

        $this->form_validation->set_rules('mobile_no', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('otp', '', 'required', array('required' => '%s'));

        if ($this->form_validation->run() == true) {
            $mobile_no = $this->input->post('mobile_no');
            $otp = $this->input->post('otp');

            $login = $this->seller_model->login($mobile_no, $otp);
             //print_r($login); die;
             if ($login) {
            if ($login->acnt_status == 1) {
                // create token data
                $token_create = (object) [
                    'id' => (int) $login->id,                  
                    'iat' => now()
                ];
                // Generate token
                $token_data = AUTHORIZATION::generateToken($token_create);

                $data = [
                    'user_id'           => (int) $login->id,
                    'seller_name'         => $login->seller_name,
                    'email_id'             => $login->email_id,
                    'mobile_no'             => $login->mobile_no,
                    'dob'             => $login->dob,
                    'address'             => $login->address,
                    'token'             => $token_data
                ];
                
                $this->response([
                    $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name')  => $this->lang->line('login_successful'),
                    $this->config->item('rest_data_field_name')     => $data
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else{

                $this->response([
                    $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name')  => $this->lang->line('login_unsuccessful_not_active'),
                ], REST_Controller::HTTP_OK);

            }

           }else {
                $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => $this->lang->line('login_unsuccessful'),
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }
    
    
    
    public function signup_post() {

   
     
        $this->form_validation->set_rules('device_token', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('seller_name', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('mobile_no', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('email_id', '', 'required', array('required' => '%s'));
        //$this->form_validation->set_rules('dob', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('id_number', '', 'required', array('required' => '%s'));
        //$this->form_validation->set_rules('address_pin_code', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('shop_address', '', 'required', array('required' => '%s'));
        if ($this->form_validation->run() == true) {
                    $email_res = $this->seller_model->check_user_email_exist($this->input->post('email_id'));
                if($email_res) {
                   $this->response([
                   $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                   $this->config->item('rest_message_field_name') => $this->lang->line('profile_email_already_exists')
                  ], REST_Controller::HTTP_OK);
                 }

                  $mobile_res = $this->seller_model->check_user_phone_exist($this->input->post('mobile_no'));
                if($mobile_res) {
                   $this->response([
                   $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                   $this->config->item('rest_message_field_name') => $this->lang->line('profile_phone_already_exists')
                  ], REST_Controller::HTTP_OK);
                 }
                     
                    $input_arr=array('seller_name'=> $this->input->post('seller_name'),
                                     'mobile_no'=>$this->input->post('mobile_no'),
                                     'email_id'=>$this->input->post('email_id'),
                                     'device_token'=>$this->input->post('device_token'),
                                     'id_number'=>$this->input->post('id_number'),
                                     'shop_address'=>$this->input->post('shop_address'));
                    $id = $this->seller_model->register($input_arr);
                    if($id){
                       
                        // create token data
                        $token_create = (object) [
                            'id' => (int) $id,                  
                            'iat' => now()
                        ];
                        // Generate token
                        $token_data = AUTHORIZATION::generateToken($token_create);
                        $this->response([
                            $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_one'),
                            $this->config->item('rest_message_field_name') => $this->lang->line('register_users_successful'),
                            'data' => [
                                'user_id'           => (int) $id,
                                'seller_name'         => !empty($this->input->post('seller_name')) ? $this->input->post('seller_name') : "",
                                'email_id'             => !empty($this->input->post('email_id')) ?  $this->input->post('email_id')  : "",
                                 'mobile_no'             => !empty($this->input->post('mobile_no')) ? $this->input->post('mobile_no')  : "",
                                'first_time'        => "1",
                                'token'             => $token_data
                            ]
                        ], REST_Controller::HTTP_OK);
                     
                  
            } else {
                // Set the response and exit
                $this->response([
                    $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                            $this->config->item('rest_message_field_name') => $this->lang->line('register_users_unsuccessful')
                        ], REST_Controller::HTTP_OK); 
            }
        } else {
           $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }


      
    /**
     * Change Verified Phone Status
     * Method (POST)
     */
    public function change_verified_phone_status_post()
    {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->seller_check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */

        $isUpdate = $this->account_model->update_user_data(['id' => $authorized_user['account']->id], ['is_verified_phone' => 1,'first_time' => 0]);

        if($isUpdate){

            // create token data
            $token_create = (object) [
                'id' => (int) $authorized_user['account']->id,                  
                'iat' => now()
            ];
            // Generate token
            $token_data = AUTHORIZATION::generateToken($token_create);

            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('phone_change_success'),
                $this->config->item('rest_data_field_name')     => [
                    'user_id' => (int) $authorized_user['account']->id,
                    'full_name' => !empty($authorized_user['account']->first_name) ? $authorized_user['account']->first_name : "",
                    'email' => !empty($authorized_user['account']->email) ? $authorized_user['account']->email  : "",
                    'profile_picture' => (!empty($authorized_user['account']->profile_picture) ? base_url($authorized_user['account']->profile_picture) : ""),
                    'phone' => !empty($authorized_user['account']->phone) ? $authorized_user['account']->phone : "",
                    'country_code' => !empty($authorized_user['account']->country_code) ? $authorized_user['account']->country_code : "",
                    'is_verified_phone' => 1,
                    'first_time' => 0,
                    'unique_id' => $authorized_user['account']->unique_id,
                    'token' => $token_data,
                ],
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => $this->lang->line('something_wrong')
            ], REST_Controller::HTTP_OK);
        }
    }

    /**
     * User forgot password
     * Method (POST)
     */
    public function forgot_password_post() {

        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('email', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('email', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() == false) {
            // Set the response and exit
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ email ]'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {

            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();

            if (empty($identity)) {
                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                // Set the response and exit
                $this->response([
                    $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('forgot_password_email_not_found'),
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->email);
            
            if ($forgotten) {
                $this->data['forgotten'] = $forgotten;
                $message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_forgot_password', 'ion_auth'), $this->data, true);

                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = $this->config->item('aws_ses_host');
                $mail->SMTPAuth = true;
                $mail->Username = $this->config->item('aws_ses_username');
                $mail->Password = $this->config->item('aws_ses_password');
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $mail->addAddress($forgotten['identity'], $this->config->item('site_title', 'ion_auth'));
                $mail->isHTML(true);
                $mail->Subject = $this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_forgotten_password_subject');
                $mail->Body = $message;
                if ($mail->send()) {
                    $this->response([
                        $this->config->item('rest_status_field_name') => 1,
                        $this->config->item('rest_message_field_name') => $this->lang->line('forgot_password_email_sent_successful') . $forgotten['identity']
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $this->response([
                        $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                        $this->config->item('rest_message_field_name') =>  $this->lang->line('forgot_password_email_sent_unsuccessful') . $identity->email
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            } else {
                // Set the response and exit
                $this->response([
                    $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('forgot_password_email_sent_unsuccessful') . $identity->email
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }

    /**
     * Get Profile
     * Method (GET)
    */
    public function get_profile_get()
    {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->seller_check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */
        //print_r($authorized_user); die;
        // create token data
        $token_create = (object) [
            'id' => (int) $authorized_user['account']->id,                  
            'iat' => now()
        ];
        // Generate token
        $token_data = AUTHORIZATION::generateToken($token_create);
      
  
        $data = [
            'user_id'           => (int) $authorized_user['account']->id,
            'email'             => !empty($authorized_user['account']->email_id) ? $authorized_user['account']->email_id : "",
            'seller_name'         => !empty($authorized_user['account']->seller_name) ? $authorized_user['account']->seller_name : "",
            'address_proof'      => !empty($authorized_user['account']->address_proof) ? $authorized_user['account']->address_proof : "",
            'dob'               => !empty($authorized_user['account']->dob) ? $authorized_user['account']->dob : "",
            'address'            => !empty($authorized_user['account']->address) ? $authorized_user['account']->address : "",
            'address_pin_code'         => $authorized_user['account']->address_pin_code,

            'mobile_no'             => !empty($authorized_user['account']->mobile_no) ? $authorized_user['account']->mobile_no : "",
            'id_proof'         => base_url().$authorized_user['account']->id_proof,
            'id_document'         => base_url().$authorized_user['account']->id_document,
            'cin'         => base_url().$authorized_user['account']->cin,
            'pan'         => base_url().$authorized_user['account']->pan,
            'tan'         => base_url().$authorized_user['account']->tan,
            'gstin'         => base_url().$authorized_user['account']->gstin,
            'udyam'         => base_url().$authorized_user['account']->udyam,
            'profile_pic'         => base_url().$authorized_user['account']->profile_pic,
            //'is_verified_phone' => (int) $authorized_user['account']->is_verified_phone,
            
            'profile_picture'   => (!empty($authorized_user['account']->profile_picture) ? $authorized_user['account']->profile_picture : ""),
            'id_number'        => $authorized_user['account']->id_number
        ];
        
        $this->response([
            $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
            $this->config->item('rest_message_field_name')  => $this->lang->line('profile_found'),
            $this->config->item('rest_data_field_name')     => $data
        ], REST_Controller::HTTP_OK);
    }

    /**
     * Check Mobile number before update
     * Method (POST)
     */
    public function check_phone_exists_post()
    {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->seller_check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */

        $this->form_validation->set_rules('phone','','required');

        if ($this->form_validation->run() == true) {
            $phone = $this->input->post('phone');

            if ($phone == $authorized_user['account']->phone) {
                $this->response([
                    $this->config->item('rest_status_field_name')       => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name')      => $this->lang->line('profile_phone_already_registered'),
                ], REST_Controller::HTTP_OK);
            }

            $phone_exist = $this->general_model->getOne('users', ['phone' => $phone]);

            if (!empty($phone_exist)) {
                if ($phone_exist->id != $authorized_user['account']->id) {
                    $this->response([
                        $this->config->item('rest_status_field_name')       => $this->config->item('rest_status_code_zero'),
                        $this->config->item('rest_message_field_name')      => $this->lang->line('profile_phone_already_exists')
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->response([
                    $this->config->item('rest_status_field_name')       => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name')      => 'New'
                ], REST_Controller::HTTP_OK);
            }
        } else {
            /* Empty request parameter */
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s) [phone]'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    /**
     * Change Verified Phone Status
     * Method (POST)
     */
    public function change_phone_number_post()
    {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->seller_check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */

        $this->form_validation->set_rules('phone','','required');

        if ($this->form_validation->run() == true) {
            $phone         = $this->input->post('phone');
            $country_code  = $this->input->post('country_code');

            $isUpdate = $this->general_model->update('users', ['id' => $authorized_user['account']->id], ['phone' => $phone, 'country_code' => $country_code]);

            if ($isUpdate) {
                // create token data
                $token_create = (object) [
                    'id' => (int) $authorized_user['account']->id,                  
                    'iat' => now()
                ];
                // Generate token
                $token_data = AUTHORIZATION::generateToken($token_create);

                $data = [
                    'user_id'           => (int) $authorized_user['account']->id,
                    'email'             => $authorized_user['account']->email,
                    'full_name'         => $authorized_user['account']->first_name,
                    'country_code'      => !empty($authorized_user['account']->country_code) ? $authorized_user['account']->country_code : "",
                    'phone'             => !empty($phone) ? $phone : $authorized_user['account']->phone,
                    'is_verified_phone' => (int) $authorized_user['account']->is_verified_phone,
                    'unique_id'         => $authorized_user['account']->unique_id,
                    'profile_picture'   => (!empty($authorized_user['account']->profile_picture) ? base_url($authorized_user['account']->profile_picture) : ""),
                    'token'             => $token_data
                ];
                
                $this->response([
                    $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name')  => $this->lang->line('profile_phone_number_change_success'),
                    $this->config->item('rest_data_field_name')     => $data
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('profile_phone_number_change_failed')
                ], REST_Controller::HTTP_OK);
            }
        } else {
            /* Empty request parameter */
            $this->response([
                $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s) [phone]'
                ], REST_Controller::HTTP_OK);
        }
    }

    /**
     * Edit Profile
     * Method (POST)
     */
    public function edit_profile_post()
    {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->seller_check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */
 
        $this->form_validation->set_rules('device_token', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('seller_name', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('mobile_no', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('email_id', '', 'required', array('required' => '%s'));
        //$this->form_validation->set_rules('dob', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('id_number', '', 'required', array('required' => '%s'));
        //$this->form_validation->set_rules('address_pin_code', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('shop_address', '', 'required', array('required' => '%s'));
        if ($this->form_validation->run() == true) {
            
                    $update_data=array('seller_name'=> $this->input->post('seller_name'),
                                     'mobile_no'=>$this->input->post('mobile_no'),
                                     'email_id'=>$this->input->post('email_id'),
                                     'device_token'=>$this->input->post('device_token'),
                                     'id_number'=>$this->input->post('id_number'),
                                     'shop_address'=>$this->input->post('shop_address'));

            if (!empty($_FILES['profile_picture']['name'])) {
                $get_data = $this->general_model->getOne('ecom_sellers', ['id' => $authorized_user['account']->id]);
                if (!empty($get_data)) {
                    if (file_exists(base_url($get_data->profile_picture))) {
                        unlink($get_data->profile_picture);
                    }
                } else {
                    $this->response([
                        $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                        $this->config->item('rest_message_field_name')  => $this->lang->line('update_failed_party_message')
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
                $file_name = time() . rand(100, 999);
                $config = [
                    'upload_path' => './uploads/users/',
                    'file_name' => $file_name,
                    'allowed_types' => 'png|jpg|jpeg',
                    'max_size' => 50480,
                    'max_width' => 20480,
                    'max_height' => 20480,
                    'file_ext_tolower' => TRUE,
                    'remove_spaces' => TRUE,
                ];
                $this->load->library('upload/', $config);
                if ($this->upload->do_upload('profile_picture')) {
                    $uploadData = $this->upload->data();
                    $update_data['profile_picture'] = 'uploads/users/' . $uploadData['file_name'];
                } else {
                    $this->response([
                        $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                        $this->config->item('rest_message_field_name')  => $this->upload->display_errors()
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            }
            $isUpdate = $this->general_model->update('ecom_sellers', ['id' => $authorized_user['account']->id], $update_data);

            if ($isUpdate) {
                $authorized_user['account'] = $this->general_model->getOne('ecom_sellers', ['id' => $authorized_user['account']->id]);
                // create token data
                $token_create = (object) [
                    'id' => (int) $authorized_user['account']->id,                  
                    'iat' => now()
                ];
                // Generate token
                $token_data = AUTHORIZATION::generateToken($token_create);
               
                $data = [
            'user_id'           => (int) $authorized_user['account']->id,
            'email'             => !empty($authorized_user['account']->email_id) ? $authorized_user['account']->email_id : "",
            'seller_name'         => !empty($authorized_user['account']->seller_name) ? $authorized_user['account']->seller_name : "",
            'address_proof'      => !empty($authorized_user['account']->address_proof) ? $authorized_user['account']->address_proof : "",
            'dob'               => !empty($authorized_user['account']->dob) ? $authorized_user['account']->dob : "",
            'address'            => !empty($authorized_user['account']->address) ? $authorized_user['account']->address : "",
            'address_pin_code'         => $authorized_user['account']->address_pin_code,

            'mobile_no'             => !empty($authorized_user['account']->mobile_no) ? $authorized_user['account']->mobile_no : "",
            'id_proof'         => base_url().$authorized_user['account']->id_proof,
            'id_document'         => base_url().$authorized_user['account']->id_document,
            'cin'         => base_url().$authorized_user['account']->cin,
            'pan'         => base_url().$authorized_user['account']->pan,
            'tan'         => base_url().$authorized_user['account']->tan,
            'gstin'         => base_url().$authorized_user['account']->gstin,
            'udyam'         => base_url().$authorized_user['account']->udyam,
            'profile_pic'         => base_url().$authorized_user['account']->profile_pic,
            //'is_verified_phone' => (int) $authorized_user['account']->is_verified_phone,
            
            'profile_picture'   => (!empty($authorized_user['account']->profile_picture) ? $authorized_user['account']->profile_picture : ""),
            'id_number'        => $authorized_user['account']->id_number
        ];
                
                $this->response([
                    $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name')  => $this->lang->line('profile_update_success'),
                    $this->config->item('rest_data_field_name')     => $data
                ], REST_Controller::HTTP_OK);
            
            } else {
                $this->response([
                    $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('profile_update_fail')
                ], REST_Controller::HTTP_OK);
            }
        } else {
            /* Empty request parameter */
            $this->response([
                $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
            ], REST_Controller::HTTP_OK); 
        }
    }

    /**
     * Change password for user
     * Method (POST)
     */
    public function change_password_post(){
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->seller_check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */

        $this->form_validation->set_rules('current_password','','required');
        $this->form_validation->set_rules('new_password','','required');

        if ($this->form_validation->run() == true) {

            $data = $this->general_model->getOne('users', ['id' => $authorized_user['account']->id]);

            $identity = $data->email;

            $old = $this->input->post('current_password');
            $new = $this->input->post('new_password');

            $change = $this->ion_auth->change_password($identity, $old, $new);
            
            if ($change) {
                $this->response([
                    $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('change_password_successful'),
                ], REST_Controller::HTTP_OK); 
            } else {
                $this->response([
                    $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('change_password_unsuccessful')
                ], REST_Controller::HTTP_OK); 
            }
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s) [current_password | new_password ]'
            ], REST_Controller::HTTP_OK);
        }
    }

    /**
     * Get User Earning Point List
     * Method (POST)
     */
    public function earning_points_get(){
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->seller_check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */

        $list = $this->account_model->get_earning_points($authorized_user['account']->id);

        if ($list) {
            $data = [
                'list' => $list,
                'points' => $authorized_user['account']->points,
                'earning_amount' => $authorized_user['account']->earning_amount
            ];
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('earning_points_list_found'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('earning_points_list_empty')
            ], REST_Controller::HTTP_OK);
        }
    }

    /**
     * Change Profile Picture
     * Method (POST)
     */
    public function change_profile_picture_post()
    {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->seller_check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */

        if (isset($_FILES['profile_picture']) && !empty($_FILES['profile_picture']['name'])) {
                $config['upload_path'] = './upload/users/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                
                $config['file_ext_tolower'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload/', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('profile_picture')) {
                    $uploadData = $this->upload->data();
                    if(!empty($authorized_user['account']->profile_picture)){
                      unlink($authorized_user['account']->profile_picture);
                    }

                    $profile_picture = 'upload/users/'.$uploadData['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->response([
                        $this->config->item('rest_result_code_field_name')  => $this->config->item('rest_status_code_zero'),
                        $this->config->item('rest_message_field_name')      => strip_tags($error['error'])
                    ], REST_Controller::HTTP_OK);
                }
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('profile_picture_not_uploaded')
            ], REST_Controller::HTTP_OK);
        }

        $is_update = $this->account_model->update_user_data(['id' => $authorized_user['account']->id], ['profile_picture' => $profile_picture]);

        if ($is_update) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('profile_picture_change_success'),
                $this->config->item('rest_data_field_name')     => ['profile_picture' => base_url($profile_picture)]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('profile_picture_change_failed')
            ], REST_Controller::HTTP_OK);
        }
    }

    /**
     * Referral code check
     * Method (POST)
     */
    public function referral_code_check_post()
    {
        $this->form_validation->set_rules('referral_code', 'referral_code', 'required');

        if ($this->form_validation->run() == true) {
            if ($this->account_model->check_referral_code($this->input->post('referral_code'))) {
                $this->response([
                    $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('referral_code_found')
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('referral_code_not_found')
                ], REST_Controller::HTTP_OK);
            }
        } else {
            /* Empty request parameter */
            $this->response([
                $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s) [referral_code]'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function update_user_token_post() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        $authorized_user = $this->general_model->seller_check_authorization($headers);
        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */
        $this->form_validation->set_rules('device_id', '', 'required', ['required' => '%s']);
        $this->form_validation->set_rules('device_token', '', 'required', ['required' => '%s']);
        if ($this->form_validation->run() == true) {
            $data = [
                'user_id'        => $authorized_user['account']->id,
                'device_token'   => $this->input->post('device_token'),
                'device_id'      => $this->input->post('device_id'),
                'last_update_on' => time()
            ];
            $update = $this->account_model->update_user_token($data);
            if ($update) {
                $this->response([
                    $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('user_device_token_success')
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('user_device_token_failed')
                ], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    /** delete user account
     *
     * Method (POST)
     */
    public function delete_user_account_post(){
        /* Check Authentications */
        $headers = $this->input->request_headers();
        $authorized_user = $this->general_model->seller_check_authorization($headers);
        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }

        $user_id = $authorized_user['account']->id;

        if ($authorized_user['account']->is_deleted == 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => 0,
                $this->config->item('rest_message_field_name') => $this->lang->line('user_account_already_deleted'),
            ], REST_Controller::HTTP_OK);
        }

        /* End Check Authentications */
        $this->form_validation->set_rules('is_social', '', 'required', ['required' => '%s']);
        if ($this->input->post('is_social') == 1) {
            $this->form_validation->set_rules('email', '', 'required', ['required' => '%s']);
        } else {
            $this->form_validation->set_rules('password', '', 'required', ['required' => '%s']);
        }
        if ($this->form_validation->run() == FALSE) {
            $this->response([
            $this->config->item('rest_status_field_name') => 0,
            $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }

        $password = $this->input->post('password');
        $email = $this->input->post('email');

        if ($this->input->post('is_social') == 1) {
            if (empty($authorized_user['account']->email)) {
                $this->response([
                    $this->config->item('rest_status_field_name') => 0,
                    $this->config->item('rest_message_field_name') => $this->lang->line('user_account_delete_email_not_found'),
                ], REST_Controller::HTTP_OK);
            }

            if ($authorized_user['account']->email == $email) {
                /* delete user account */
                $delete = $this->account_model->delete_user_account($user_id);
                if ($delete) {
                    /* return message account deleted successfully */
                    $this->response([
                        $this->config->item('rest_status_field_name') => 1,
                        $this->config->item('rest_message_field_name') => $this->lang->line('user_account_delete_successfully')
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $this->response([
                        $this->config->item('rest_status_field_name') => 0,
                        $this->config->item('rest_message_field_name') => $this->lang->line('user_account_delete_unsuccessfully')
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code      
                }
            } else {
                $this->response([
                    $this->config->item('rest_status_field_name') => 0,
                    $this->config->item('rest_message_field_name') => $this->lang->line('user_account_email_incorrect')
                ], REST_Controller::HTTP_OK);
            }
        } else {
            /* Check appsword correct or not */
            $password_status = $this->ion_auth_model->check_password($password,$user_id);

            if ($password_status == 1) {
                $user = $this->ion_auth->user($user_id)->row();

                /* delete user account */
                $delete = $this->account_model->delete_user_account($user_id);
                if ($delete) {
                    /* return message account deleted successfully */
                    $this->response([
                        $this->config->item('rest_status_field_name') => 1,
                        $this->config->item('rest_message_field_name') => $this->lang->line('user_account_delete_successfully')
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $this->response([
                        $this->config->item('rest_status_field_name') => 0,
                        $this->config->item('rest_message_field_name') => $this->lang->line('user_account_delete_unsuccessfully')
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code      
                }
            } else if ($password_status == 2) {
                /* return message if password incorrect */
                $this->response([
                    $this->config->item('rest_status_field_name') => 0,
                    $this->config->item('rest_message_field_name') => $this->lang->line('user_account_password_incorrect')
                ], REST_Controller::HTTP_OK);
            } else {
                /* return message if something went wrong */
                $this->response([
                    $this->config->item('rest_status_field_name') => 0,
                    $this->config->item('rest_message_field_name') => $this->lang->line('user_account_somthing_wrong')
                ], REST_Controller::HTTP_OK);
            }
        }
    }


    public function notification_list_get() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        $authorized_user = $this->general_model->seller_check_authorization($headers);
        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        $offset = $this->input->get('offset') * getenv('LIMIT_NOTIFICATION_LIST');
        $notifications = $this->account_model->notification_list($authorized_user['account']->id, $offset, getenv('LIMIT_NOTIFICATION_LIST'));
        if ($notifications) {
            $this->response([
                $this->config->item('rest_status_field_name') => 1,
                $this->config->item('rest_message_field_name') => 'Found',
                $this->config->item('rest_data_field_name') => $notifications
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => 0,
                $this->config->item('rest_message_field_name') => $this->lang->line('notification_list_empty'),
            ], REST_Controller::HTTP_OK);
        }
    }

 /**
     * Send OTP
     * Method (POST)
     */
    public function send_otp_post()
    {
        $this->form_validation->set_rules('type','','required');
         if($this->input->post('type')==1)
         {
         $this->form_validation->set_rules('mobile_no','','required');           
         }else{
          $this->form_validation->set_rules('email_id','','required');
         }
        if ($this->form_validation->run() == true) {
                $opt=get_otp();
                if($this->input->post('type')==1)
                 {         
                  $phone = $this->input->post('mobile_no');
                  $session_data=array('mobile_no'=>$phone,'otp_code'=>$opt);
                 }else{
                  $email = $this->input->post('email_id');
                  $session_data=array('email_id'=>$email,'otp_code'=>$opt);
                 }
                /*-------send sms on mobile number------------*/
                $current_date=date('Y-m-d H:i:s');
                $otp_expiry_date= date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime($current_date)));
                $update_arr=array('otp'=>$opt,'otp_expiry_date'=>$otp_expiry_date);
                $message=$opt." is the OTP to SignUp on thenirmanstore .Do not share to anyone.";
                //$this->db->update('users',$update_arr,['id' =>$res->id]);
                 //send_sms(array('mobile_nuber'=>$phone_exist->phone,'message'=>$message,'template_id'=>'1207167508255462029'));
                $this->session->set_userdata($session_data);
                  
                /*--------------------------------------------*/ 
                
                 $data = [
                    //'user_id'           => (int) $phone_exist->id,
                   // 'is_verified_phone' => $phone_exist->is_verified_phone,
                    'otp'               => $opt,
                    //'unique_id'         => $phone_exist->unique_id,
                    //'token'             => $token_data
                ];   
                    $this->response([
                        $this->config->item('rest_status_field_name')       => $this->config->item('rest_status_code_one'),
                        $this->config->item('rest_message_field_name')      =>'Found',
                         $this->config->item('rest_data_field_name')     => $data
                    ], REST_Controller::HTTP_OK);
                
            
        } else {
            /* Empty request parameter */
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s) [phone]'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function otp_verify_post()
    {
            $this->form_validation->set_rules('type','','required');
             if($this->input->post('type')==1)
             {
             $this->form_validation->set_rules('mobile_no','','required');           
             }else{
              $this->form_validation->set_rules('email_id','','required');
             }
            $this->form_validation->set_rules('otp','','required');
        if ($this->form_validation->run() == true) {
            if($this->input->post('type')==1)
                 {   
                   $mobile_no=$this->session->userdata('mobile_no');
                   $otp=$this->session->userdata('otp_code'); 
                  if($mobile_no==$this->input->post('mobile_no') && $otp==$this->input->post('otp'))
                  {
                    $status=1;
                  }else{
                    $status=0;
                  }
                 }else{
                   $email = $this->input->post('email_id');
                   $otp=$this->session->userdata('otp');      
                  if($email==$this->input->post('email_id') && $otp==$this->input->post('otp'))
                  {
                    $status=1;
                  }else{
                    $status=0;
                  }
                 }
            if ($status==1) {
                $session_data=array('email_id'=>'','otp_code'=>'');
                $this->session->set_userdata($session_data);
                $this->response([
                    $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name')  => $this->lang->line('otp_verify')
                ], REST_Controller::HTTP_OK);
            
            } else {
                $this->response([
                    $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name') => $this->lang->line('otp_verify_fail')
                ], REST_Controller::HTTP_OK);
            }
        } else {
            /* Empty request parameter */
            $this->response([
                $this->config->item('rest_status_field_name')  => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
            ], REST_Controller::HTTP_OK); 
        }
    }

  public function order_list_get() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        $authorized_user = $this->general_model->seller_check_authorization($headers);
        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        //print_r($authorized_user['account']->id); die;
        $res = $this->seller_model->order_list($authorized_user['account']->id);
        if ($res) {
            $this->response([
                $this->config->item('rest_status_field_name') => 1,
                $this->config->item('rest_message_field_name') => 'Found',
                $this->config->item('rest_data_field_name') => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => 0,
                $this->config->item('rest_message_field_name') => 'Not Found',
            ], REST_Controller::HTTP_OK);
        }
    }

     public function order_details_post() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        $authorized_user = $this->general_model->seller_check_authorization($headers);
        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        //print_r($authorized_user['account']->id); die;
        $this->form_validation->set_rules('order_id', '', 'required', array('required' => '%s'));

        if ($this->form_validation->run() == true) {
        $res = $this->seller_model->order_details($this->input->post('order_id'));
        if ($res) {
            $this->response([
                $this->config->item('rest_status_field_name') => 1,
                $this->config->item('rest_message_field_name') => 'Found',
                $this->config->item('rest_data_field_name') => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => 0,
                $this->config->item('rest_message_field_name') => 'Not Found',
            ], REST_Controller::HTTP_OK);
        }

        } else {
            $this->response([
            $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
            $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

      public function dashboard_get() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        $authorized_user = $this->general_model->seller_check_authorization($headers);
        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        //print_r($authorized_user['account']->id); die;
        $res = $this->seller_model->dashboard($authorized_user['account']->id);
        if ($res) {
            $this->response([
                $this->config->item('rest_status_field_name') => 1,
                $this->config->item('rest_message_field_name') => 'Found',
                $this->config->item('rest_data_field_name') => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => 0,
                $this->config->item('rest_message_field_name') => 'Not Found',
            ], REST_Controller::HTTP_OK);
        }
    }

     public function product_list_get() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        $authorized_user = $this->general_model->seller_check_authorization($headers);
        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        //print_r($authorized_user['account']->id); die;
        $res = $this->seller_model->product_list($authorized_user['account']->id);
        if ($res) {
            $this->response([
                $this->config->item('rest_status_field_name') => 1,
                $this->config->item('rest_message_field_name') => 'Found',
                $this->config->item('rest_data_field_name') => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => 0,
                $this->config->item('rest_message_field_name') => 'Not Found',
            ], REST_Controller::HTTP_OK);
        }
    }

     public function single_product_post() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        $authorized_user = $this->general_model->seller_check_authorization($headers);
        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        //print_r($authorized_user['account']->id); die;
        $this->form_validation->set_rules('product_id', '', 'required', array('required' => '%s'));

        if ($this->form_validation->run() == true) {
        $res = $this->seller_model->get_single_product($this->input->post('product_id'));
        if ($res) {
            $this->response([
                $this->config->item('rest_status_field_name') => 1,
                $this->config->item('rest_message_field_name') => 'Found',
                $this->config->item('rest_data_field_name') => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name') => 0,
                $this->config->item('rest_message_field_name') => 'Not Found',
            ], REST_Controller::HTTP_OK);
        }

        } else {
            $this->response([
            $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
            $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }    
    
}
