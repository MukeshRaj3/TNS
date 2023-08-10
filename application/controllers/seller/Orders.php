<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

  public function __construct() {
      parent::__construct();

      /* Load :: Common */
      $this->load->library('template');
      $this->load->model('seller/orders_model');
      $this->load->model('seller/seller_model');

  }

  public function index() {
    //echo "hello";  die;
    /* Title Page */
    $res_orders=array();
    $seller_id=$this->session->userdata('user_id');
        if(isset($_GET['status']))
         {
          $where='AND  (`ecom_orders`.`order_track_status`='.$_GET['status'].')';
         }else if(isset($_GET['payment_status']))
         {
          $where='AND `ecom_orders`.`payment_status`="0"';
         }else{
          $where='';
         }

        if($this->session->userdata('user_type')=='1')
        { 
        $res = $this->seller_model->simple_query("SELECT id FROM `ecom_products` WHERE is_deleted='0' AND seller_id='".$seller_id ."' ORDER BY id");
       }else{
        $res = $this->seller_model->simple_query("SELECT id FROM `ecom_products` WHERE is_deleted='0'  ORDER BY id");
       }
    if(!empty($res)){

      $products_arr=array();
      foreach($res as $key => $value) {
              $products_arr[] = $value['id'];
      }
      $all_pid=implode(',',$products_arr);
      $res_orders = $this->seller_model->simple_query("SELECT `ecom_orders`.*,`ecom_order_items`.`quantity` as item_qty,`ecom_order_items`.`unit_price`,`ecom_order_items`.`item_price`,`ecom_addresses`.`first_name`,`ecom_addresses`.`last_name` FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) $where Group by `ecom_order_items`.`order_id`");
        //echo $this->db->last_query();
      }
      $this->data['list'] =$res_orders;
    $this->template->seller_render_page('seller/orders/list',$this->data);
  }

  public function view_orders($pid) {
    /* Title Page */
    $res = $this->orders_model->order_details($pid)[0];
    $this->data['res'] =$res;
    $this->template->seller_render_page('seller/orders/order_view',$this->data);
  }

  public function add_product() {
       /* Validate form input */
            $validation = [
                [
                    'field' => 'product_name',
                    'label' => 'product_name',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'short_description',
                    'label' => 'short_description',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please select %s.']
                ],
                [
                    'field' => 'price',
                    'label' => 'price',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'mrp',
                    'label' => 'mrp',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'stock',
                    'label' => 'stock',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'l1c_id',
                    'label' => 'category',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please select %s.']
                ]
                
            ];

            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == true) {    
                //echo "<pre>";        
                // print_r($this->input->post());exit;
                $additional_data = ['product_name'=>$this->input->post('product_name'),
                'l1c_id'=>$this->input->post('l1c_id'),
                'l2c_id'=>$this->input->post('l2c_id'),
                'stock'=>$this->input->post('stock'),
                'quantity'=>$this->input->post('quantity'),
                'mrp'=>$this->input->post('mrp'),
                'price'=>$this->input->post('price'),
                'discount_percent'=>$this->input->post('discount_percent'),
                'purchase_price'=>$this->input->post('purchase_price'),
                'unit_id'=>$this->input->post('unit_id'),
                'hsn_code'=>$this->input->post('hsn_code'),
                'applicable_tax'=>$this->input->post('applicable_tax'),
                'price_for_seller'=>$this->input->post('price_for_seller'),
                'applicable_tax'=>$this->input->post('applicable_tax'),
                'short_description'=>$this->input->post('short_description'),
                'seller_id'=>$this->session->userdata('user_id')
              ];

                if(!empty(($_FILES['video']['name'])))
                     {
                       $product_video_path='./image/product/';
                       $new_file_name=$this->orders_model->file_upload('video',$product_video_path);
                       $additional_data['video'] = 'image/product/'.$new_file_name;

                     }
                 //echo "<pre>";
                 //print_r($additional_data);exit;

                /* Register new business  */
                $insert_id = $this->orders_model->insert($additional_data);
                if ($insert_id) {
                        /*-----------------profile_pic----------------------*/  
                   if(!empty(($_FILES['image']['name'])))
                     {
                       $product_img_path='./image/product/';
                       $new_file_name=$this->orders_model->file_upload('pimg',$profile_pic_path);
                       $product_image = $new_file_name;
                       $this->orders_model->img_insert(array('search_image'=>$product_image,'cart_image'=>$product_image,'catalog_image'=>$product_image,'pid'=>$insert_id));
                     }
                $this->session->set_flashdata('message', ['1','Product added successfully.']);
                            redirect('seller/product', 'refresh');
                } else {
                    $this->session->set_flashdata('message', ['0','Product added failed.']);
                    redirect('seller/product/add_product', 'refresh');
                }
            } else {
                $this->template->seller_render_page('seller/product/add_product');
            }
		
  }

  public function change_status()
  {

    $res=  $this->orders_model->update($this->input->post('id'),array('order_track_status'=>$this->input->post('status')));
    if ($res) {
        $response = [
          'status' => 1,
          'message' => 'Order status changed successfully'
        ];
      } else {
        $response = [
          'status' => 0,
          'message' => 'unable to status changed'
        ];
      }
      echo json_encode($response);
  }
  public function settlement($pid) {
    //echo "hello";  die;
    /* Title Page */
    $res = $this->orders_model->order_details($pid)[0];
    //echo "<pre>";
    //print_r($res); die;
    $this->data['res'] =$res;
    $this->template->seller_render_page('seller/orders/view_settlement',$this->data);
  }

  public function delete() {
      $delete = $this->orders_model->delete($this->input->post('city_id'));
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
