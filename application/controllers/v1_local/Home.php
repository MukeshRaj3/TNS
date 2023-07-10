<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Home
 * Create class for app home screen handling
*/
class Home extends REST_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Helper */
        $this->lang->load('API/home');
        /* Load :: Models */
        $this->load->model('v1/home_model');

        $this->form_validation->set_error_delimiters(' | ', '');
    }

  /**
     * All Banners 
     * Method (POST)
     */
    public function banners_get() {

      
        $data = $this->home_model->get_all_banners();

        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('banners_found_success'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('banners_found_failed')
            ], REST_Controller::HTTP_OK);
        }
    }


    /**
     * Filter Categories 
     * Method (POST)
     */
    public function categories_get() {

      
        $data = $this->home_model->get_categories();

        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('categories_found_success'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('categories_found_failed')
            ], REST_Controller::HTTP_OK);
        }
    }

/**
  * Sub Categories 
  * Method (POST)
*/
public function sub_categories_post() {

       $this->form_validation->set_rules('category_id', '', 'required', array('required' => '%s'));

    if($this->form_validation->run() == true) {
        $post_data=$this->input->post();
        $data = $this->home_model->get_sub_categories($post_data['category_id']);
        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('categories_found_success'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('categories_found_failed')
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
     * Get Delivery Charges 
     * Method (POST)
     */
    public function delivery_charges_get() {

      
        $data = $this->home_model->get_delivery_charges();
        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('delivery_charges_found_success'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('delivery_charges_found_failed')
            ], REST_Controller::HTTP_OK);
        }
    }    

}
