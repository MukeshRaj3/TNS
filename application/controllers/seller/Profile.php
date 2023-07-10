<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

  public function __construct() {
      parent::__construct();

      /* Load :: Common */
      $this->load->library('template');
      $this->load->model('seller/profile_model');
      $this->load->model('seller/seller_model');

  }

  public function index() {
    //echo "hello";  die;
    /* Title Page */
    //print_r($this->session->userdata()); die;
    $this->data['res'] = $this->profile_model->profile_details($this->session->userdata('user_id'));
    $this->template->seller_render_page('seller/profile/profile',$this->data);
  }

  public function edit() {
    //print_r($this->data['res']); die;
    /* Validate form input */
            $validation = [
                [
                    'field' => 'name',
                    'label' => 'name',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'dob',
                    'label' => 'dob',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please select %s.']
                ],
                [
                    'field' => 'email',
                    'label' => 'email',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'address',
                    'label' => 'address',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'address_pin_code',
                    'label' => 'address_pin_code',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'mobile_no',
                    'label' => 'mobile number',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ]
                
            ];

            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == true) {    
                //echo "<pre>";        
                // print_r($this->input->post());exit;
                $additional_data = ['seller_name'=>$this->input->post('name'),
                'email_id'=>$this->input->post('email'),
                'dob'=>$this->input->post('dob'),
                'mobile_no'=>$this->input->post('mobile_no'),
                'address'=>$this->input->post('address'),
                'address_pin_code'=>$this->input->post('address_pin_code'),
                'shop_address'=>$this->input->post('shop_address'),
                'shop_address_pin_code'=>$this->input->post('shop_address_pin_code')
              ];

             /*-----------------id_document----------------------*/
            
               if(!empty($_FILES['id_document']['name']))
               {
                 $id_document_path='./uploads/users/seller/id_document/';
                 $new_file_name=$this->seller_model->file_upload('id_document',$id_document_path);
                 $additional_data['id_document'] = 'uploads/users/seller/id_document/'.$new_file_name;
              }
              /*-----------------id_proof----------------------*/  
              if(!empty(($_FILES['id_proof']['name'])))
               {
                 $id_proof_path='./uploads/users/seller/id_proof/';
                 $new_file_name=$this->seller_model->file_upload('id_proof',$id_proof_path);
                 $additional_data['id_proof'] = 'uploads/users/seller/id_proof/'.$new_file_name;
               }
              /*-----------------address_proof----------------------*/  
              if(!empty(($_FILES['address_proof']['name'])))
               {
                 $address_proof_path='./uploads/users/seller/address_proof/';
                 $new_file_name=$this->seller_model->file_upload('address_proof',$address_proof_path);
                 $additional_data['address_proof'] = 'uploads/users/seller/address_proof/'.$new_file_name;
              }
            
             /*-----------------profile_pic----------------------*/  
             if(!empty(($_FILES['profile_pic']['name'])))
               {
                 $profile_pic_path='./uploads/users/seller/profile_pic/';
                 $new_file_name=$this->seller_model->file_upload('profile_pic',$profile_pic_path);
                 $additional_data['profile_pic'] = 'uploads/users/seller/profile_pic/'.$new_file_name;

               }
             
                 //echo "<pre>";
                 //print_r($additional_data);exit;

                /* Register new business  */
                $register = $this->seller_model->update($this->session->userdata('user_id'),$additional_data);
                if ($register) {
                $this->session->set_flashdata('message', ['1','Your profile updated successfully.']);
                            redirect('seller/profile/edit', 'refresh');
                } else {
                    $this->session->set_flashdata('message', ['0','Your profile update failed.']);
                    redirect('seller/profile/edit', 'refresh');
                }
            } else {
              $this->data['res'] = $this->profile_model->profile_details($this->session->userdata('user_id'));  
              $this->template->seller_render_page('seller/profile/edit',$this->data);

            }
    
  }

  public function delete() {
      $delete = $this->profile_model->delete($this->input->post('city_id'));
      if ($delete) {
        $response = [
          'status' => 1,
          'message' => 'city deleted successfully'
        ];
      } else {
        $response = [
          'status' => 0,
          'message' => 'unable to delete city'
        ];
      }
      echo json_encode($response);
  }
}
