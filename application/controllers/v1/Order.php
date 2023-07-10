<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
ob_start();
/**
 * Class Refund
 * Create class for refund handling
*/
class Order extends REST_Controller {

    public function __construct() {
        parent::__construct();
        /* Load :: Models */
        $this->load->model('v1/order_model');
        $this->lang->load('API/order_history');
        $this->lang->load('API/promocode');
        $this->lang->load('API/cart');
        $this->form_validation->set_error_delimiters(' | ', '');
       

    }

    public function create_order_post() {
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

        $this->form_validation->set_rules('final_price', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('delivery_address', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('payment_method', '', 'required', array('required' => '%s'));
        //$this->form_validation->set_rules('delivery_charges', '', 'required', array('required' => '%s'));
        if ($this->form_validation->run() == true) {
            $delivery_charge = $this->order_model->get_sql_query('ecom_delivery_charges','amount',array('status'=>'1'));
            if(!empty($delivery_charge))
            {
              $delivery_charge =$delivery_charge[0]->amount;   
            }else{
              $delivery_charge =0;  
            }
            
             $final_price = $this->input->post('final_price')+$delivery_charge+$this->input->post('discount_amount');
             $total_amount = 0;
             $order_num=$this->order_model->get_order_data();
             $carts=$this->order_model->get_cart_item($authorized_user['account']->id);
             if (!empty($carts)) {
                    
                    foreach ($carts as $key => $value) {
                        $products[$key] = $this->order_model->get_cart_products($value->pid);
                      
                        $total_amount += $products[$key]->price * intval($value->quantity);
                        
                    }
                }else{

                        $this->response([
                        $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                        $this->config->item('rest_message_field_name')  => $this->lang->line('cart_item_found_failed')
                    ], REST_Controller::HTTP_OK);
                }

          
            $final_amount = ($total_amount + intval($delivery_charge));
            if($final_amount != $final_price){
                $this->response([
                        $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                        $this->config->item('rest_message_field_name')  => $this->lang->line('order_amount_not_equal')
                    ], REST_Controller::HTTP_OK);
            }   

            /*---------------Insert Order------------------------------*/
            $data = [
                'user_id'              => $authorized_user['account']->id,
                'order_no'        =>$order_num,
                'order_item_array'    => serialize($products),
                'address_id'          => $this->input->post('delivery_address'),
                'delivery_charges'     => @$delivery_charge,
                'email_id'             => @$authorized_user['account']->email,
                'contact_no'         => @$authorized_user['account']->phone,
                'payment_method'=>$this->input->post('payment_method'),
                'order_datetime'            => date('Y-m-d H:i:s')
            ];
           
            //print_r($data); die;
            $insert_id = $this->order_model->insert($data);
            if($insert_id) {
                 /*---------------Insert Order Item------------------*/
                   if(!empty($carts))
                   {
                   foreach ($carts as $key => $value) {
                        $item_price = $products[$key]->price;
                        $unit_price = $products[$key]->price * intval($value->quantity);
                          $order_item = [
                            'order_id'=>$insert_id,
                            'pid'  =>$value->pid,
                            'quantity' =>$value->quantity,
                            'item_price'=> $item_price,
                            'unit_price' => $unit_price
                              ];
                        $this->order_model->insert_order_item($order_item);
                      }
                    } 
                /*---------------Delete Cart Item------------------*/
                $this->order_model->delete_cart_item($authorized_user['account']->id);
                /*--------------------------------------------------*/
                $this->response([
                    $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                    $this->config->item('rest_message_field_name')  => $this->lang->line('order_create_success'),
                       'order_id'    => $insert_id
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response([
                    $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                    $this->config->item('rest_message_field_name')  => $this->lang->line('order_create_fail')
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        } else {
            $this->response([
            $this->config->item('rest_status_field_name') => $this->config->item('rest_status_code_zero'),
            $this->config->item('rest_message_field_name') => 'Empty request parameter(s). [ ' . ltrim(str_replace("\n", '', validation_errors()), ' |') . ' ]'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
         
    }

    /**
     * Get My Orders
     * Method (POST)
     */
    public function my_orders_post() {
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
        $filter_type=$this->input->post('filter_type');
        $data = $this->order_model->get_my_orders($authorized_user['account']->id,$filter_type);
        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('order_history_data_found'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('order_not_found')
            ], REST_Controller::HTTP_OK);
        }
    }

/**
     * Get Order Details
     * Method (POST)
     */
    public function order_details_post() {
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
        $this->form_validation->set_rules('order_id', '', 'required', array('required' => '%s'));
        if ($this->form_validation->run() == true) {
        $order_id=$this->input->post('order_id');
        $data = $this->order_model->get_order_details($authorized_user['account']->id,$order_id);
        if ($data) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('order_data_found'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('order_data_not_found')
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
     * Get Promo Code Apply
     * Method (POST)
     */
    public function promo_code_apply_post() {
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
        $this->form_validation->set_rules('total_amount', '', 'required', array('required' => '%s'));
        $this->form_validation->set_rules('promo_code', '', 'required', array('required' => '%s'));

        if ($this->form_validation->run() == true) {
        $total_amount=$this->input->post('total_amount');
        $promo_code=$this->input->post('promo_code');
        $data = $this->order_model->promo_code_apply($total_amount,$authorized_user['account']->id,$promo_code);
        if ($data['status']==1) {
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_one'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('promocode_applied_success'),
                $this->config->item('rest_data_field_name')     => $data
            ], REST_Controller::HTTP_OK);
        }else if ($data['status']==2){
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('promocode_already_used_by_user')
            ], REST_Controller::HTTP_OK);
        }else if ($data['status']==3){
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('promocode_expired')
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                $this->config->item('rest_status_field_name')   => $this->config->item('rest_status_code_zero'),
                $this->config->item('rest_message_field_name')  => $this->lang->line('promocode_invalid')
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