<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Home
 * Create class for app home screen handling
*/
class Product extends REST_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Helper */
        $this->lang->load('API/product');
        /* Load :: Models */
        $this->load->model('v1/product_model');

        $this->form_validation->set_error_delimiters(' | ', '');
    }

  /**
     * All Products 
     * Method (POST)
     */
    public function products_post() {
        $post_data=array('product_id'=>$this->input->post('product_id'),
                         'category_id'=>$this->input->post('category_id'),
                         'sub_category_id'=>$this->input->post('sub_category_id'),
                         'keyword'=>$this->input->post('keyword'));
        $data = $this->product_model->get_product($post_data);
        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('products_found_success'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('products_found_failed')
            ], REST_Controller::HTTP_OK);
        }
    }

 public function products_review_rating_send_post() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */
        $this->form_validation->set_rules('product_id', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('remark', '', 'required', array('required' => '%s'));
         $this->form_validation->set_rules('rating', '', 'required', array('required' => '%s'));
      if ($this->form_validation->run() == true) {
         $post_data=array('product_id'=>$this->input->post('product_id'),
                         'remark'=>$this->input->post('remark'),
                         'rating'=>$this->input->post('rating'),
                         'user_id'=>$authorized_user['account']->id,
                         'rdate'=>date('Y-m-d'));
        $data = $this->product_model->products_review_rating_send($post_data);
        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('product_rating_send_found_success')
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('product_rating_send_found_failed')
            ], REST_Controller::HTTP_OK);
        }

      }else{
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }
 public function products_add_wish_list_post() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */
       $this->form_validation->set_rules('product_id', '', 'required', array('required' => '%s'));
      
      if ($this->form_validation->run() == true) {
         $post_data=array('product_id'=>$this->input->post('product_id'),
                         'user_id'=>$authorized_user['account']->id,
                         'created_date'=>date('Y-m-d H:i:s'));
        $data = $this->product_model->products_add_wish_list($post_data);
        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('products_wish_list_add_success'),
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('products_wish_list_add_failed')
            ], REST_Controller::HTTP_OK);
        }
      }else{
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    /**
     * Get Product Wist 
     * Method (POST)
     */
    public function product_wish_post() {

         /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */
        $data = $this->product_model->product_wish_get(array('user_id'=>$authorized_user['account']->id));
        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('products_wish_list_success'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('products_wish_list_failed')
            ], REST_Controller::HTTP_OK);
        }
    }

public function delete_wish_list_product_post() {
        /* Check Authentications */
        $headers = $this->input->request_headers();
        
        $authorized_user = $this->general_model->check_authorization($headers);

        if ($authorized_user['status'] != 1) {
            $this->response([
                $this->config->item('rest_status_field_name') => $authorized_user['status'],
                $this->config->item('rest_message_field_name') => $authorized_user['message']
            ], REST_Controller::HTTP_OK);
        }
        /* End Check Authentications */
    $this->form_validation->set_rules('product_id', '', 'required', array('required' => '%s'));
    if($this->form_validation->run() == true) {
           // print_r($authorized_user['account']->id); die;
        $post_data=array('user_id'=>$authorized_user['account']->id,
                         'product_id'=>$this->input->post('product_id'));
        $data = $this->general_model->delete(' ecom_product_wish_list',$post_data);
        if($data){
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('products_wish_list_delete_success')
            ], REST_Controller::HTTP_OK);
        }else{
             $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('products_wish_list_delete_failed')
            ], REST_Controller::HTTP_OK);
        }
     }else{
            $this->response([
                $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }    

}
