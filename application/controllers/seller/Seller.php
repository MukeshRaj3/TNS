<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

  public function __construct() {
      parent::__construct();

      /* Load :: Common */
      $this->load->library('template');
      $this->load->model('seller/seller_model');
  }

  public function dashboard() {
    if(empty($this->session->userdata('user_id')))
    {
    redirect('account/seller_login', 'refresh');
    }
    //echo "hello";  die;
    /* Title Page */
    $res_ora=array();
    $moths_data=array();
    $total_order=0;
    $previous_total_order=0;
    $seller_id=$this->session->userdata('user_id');
    $res = $this->seller_model->simple_query("SELECT id FROM `ecom_products` WHERE seller_id='".$seller_id ."' ORDER BY id");
    if(!empty($res)){

      $products_arr=array();
      foreach($res as $key => $value) {
              $products_arr[] = $value['id'];
      }
      $all_pid=implode(',',$products_arr);
      //print_r($all_pid); die;
      $current_date=date('Y-m-d'); 
      $previous_date= date('Y-m-d', strtotime($current_date. ' - 1 days')); 
      $res_ora = $this->seller_model->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$current_date'");

      $res_tord = $this->seller_model->simple_query("SELECT count(*) as total FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$current_date' Group by `ecom_order_items`.`order_id`");
      if(!empty($res_tord[0]['total']))
      {
        $total_order= count($res_tord);  
      }

      $res_ptord = $this->seller_model->simple_query("SELECT count(*) as total FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$previous_date' Group by `ecom_order_items`.`order_id`");
      if(!empty($res_ptord[0]['total']))
      {
        $previous_total_order= count($res_ptord);  
      }
       $current_year=date('Y');
       
      for ($i=1; $i <= 12; $i++) { 
          
          $res_oram = $this->seller_model->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND MONTH(`ecom_orders`.`order_datetime`)='$i' AND YEAR(`ecom_orders`.`order_datetime`)='$current_year'");
            $nmonth = date('F', mktime(0, 0, 0, $i, 10));

           $month_amt=$res_oram[0]['total_order_amt']+$res_oram[0]['total_delivery_charges']; 
           $moths_data[]='['.'"'.$nmonth.'"'.','.$month_amt.']';
          //echo $this->db->last_query(); die;
      }
            //echo "<pre>";
           //print_r($moths_data); die;  
    }
    $this->data['total_months_wise_sales']=$moths_data;
    $this->data['previous_total_order']=$previous_total_order;
    $this->data['total_order']=$total_order;
    $this->data['total_sales']=$res_ora;
      //echo "<pre>";
      //print_r($this->data); die;

    $this->template->seller_render_page('seller/dashboard',$this->data);
  }

  
  public function transaction_report() {
    if(empty($this->session->userdata('user_id')))
    {
    redirect('account/seller_login', 'refresh');
    }
    $res_ora=array();
    $total_order=0;
    $previous_total_order=0;
    $seller_id=$this->session->userdata('user_id');
    $res = $this->seller_model->simple_query("SELECT id FROM `ecom_products` WHERE seller_id='".$seller_id ."' ORDER BY id");
    if(!empty($res)){

      $products_arr=array();
      foreach($res as $key => $value) {
              $products_arr[] = $value['id'];
      }
       $all_pid=implode(',',$products_arr);
       $current_date=date('Y-m-d'); 
       $previous_date= date('Y-m-d', strtotime($current_date. ' - 1 days'));  
       $res_ora = $this->seller_model->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt,`ecom_orders`.`tax`,`ecom_orders`.`order_no`,`users`.`first_name`,`users`.`last_name`,`users`.`username`,`ecom_addresses`.`address`,`ecom_addresses`.`first_name` as billing_fname,`ecom_addresses`.`last_name` as billing_lname FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` LEFT JOIN `users` ON `ecom_orders`.`user_id`=`users`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid)");
    
      }
    $this->data['transaction_report']=$res_ora;
    $this->template->seller_render_page('seller/transaction_report/transaction_report',$this->data);
  }

   public function order_report() {
    if(empty($this->session->userdata('user_id')))
    {
    redirect('account/seller_login', 'refresh');
    }
    $res_ora=array();
    $total_order=0;
    $previous_total_order=0;
    $seller_id=$this->session->userdata('user_id');
    $res = $this->seller_model->simple_query("SELECT id FROM `ecom_products` WHERE seller_id='".$seller_id ."' ORDER BY id");
    if(!empty($res)){

      $products_arr=array();
      foreach($res as $key => $value) {
              $products_arr[] = $value['id'];
      }
       $all_pid=implode(',',$products_arr);
       $current_date=date('Y-m-d'); 
       $previous_date= date('Y-m-d', strtotime($current_date. ' - 1 days'));  
       $res_ora = $this->seller_model->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt,`ecom_orders`.`tax`,`ecom_orders`.`order_no`,`users`.`first_name`,`users`.`last_name`,`users`.`username`,`ecom_addresses`.`address`,`ecom_addresses`.`first_name` as billing_fname,`ecom_addresses`.`last_name` as billing_lname FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` LEFT JOIN `users` ON `ecom_orders`.`user_id`=`users`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid)");
    
      }
    $this->data['transaction_report']=$res_ora;
    $this->template->seller_render_page('seller/orders/order_report',$this->data);
  }

  public function transaction_report_11_08_2023() {
    if(empty($this->session->userdata('user_id')))
    {
    redirect('account/seller_login', 'refresh');
    }
		 $res_ora=array();
    $moths_data=array();
    $week_data=array();
    $year_data=array();

    $total_order=0;
    $previous_total_order=0;
    $seller_id=$this->session->userdata('user_id');
    $res = $this->seller_model->simple_query("SELECT id FROM `ecom_products` WHERE seller_id='".$seller_id ."' ORDER BY id");
    if(!empty($res)){

      $products_arr=array();
      foreach($res as $key => $value) {
              $products_arr[] = $value['id'];
      }
      $all_pid=implode(',',$products_arr);
      //print_r($all_pid); die;
      $current_date=date('Y-m-d'); 
      $previous_date= date('Y-m-d', strtotime($current_date. ' - 1 days')); 
      $res_ora = $this->seller_model->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$current_date'");

      $res_tord = $this->seller_model->simple_query("SELECT count(*) as total FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$current_date' Group by `ecom_order_items`.`order_id`");
      if(!empty($res_tord[0]['total']))
      {
        $total_order= count($res_tord);  
      }

      $res_ptord = $this->seller_model->simple_query("SELECT count(*) as total FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$previous_date' Group by `ecom_order_items`.`order_id`");
      if(!empty($res_ptord[0]['total']))
      {
        $previous_total_order= count($res_ptord);  
      }
       $current_year=date('Y');
       if(isset($_GET['type']) && $_GET['type']==2)
       {
      for ($i=1; $i <= 12; $i++) { 
          
          $res_oram = $this->seller_model->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND MONTH(`ecom_orders`.`order_datetime`)='$i' AND YEAR(`ecom_orders`.`order_datetime`)='$current_year'");
            $nmonth = date('F', mktime(0, 0, 0, $i, 10));

           $month_amt=$res_oram[0]['total_order_amt']+$res_oram[0]['total_delivery_charges']; 
           $moths_data[]='['.'"'.$nmonth.'"'.','.$month_amt.']';
          //echo $this->db->last_query(); die;
      }
     }

      if(isset($_GET['type']) && $_GET['type']==3)
       {
         $ts = strtotime(date('Y-m-d'));
         $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
          $start_date = date('Y-m-d', $start);
          $end_date = date('Y-m-d', strtotime('next saturday', $start)); 

      for ($i=0; $i <= 7; $i++) { 
          $start_date1 = date('Y-m-d', strtotime($start_date.' +'.$i.' day'));
          $res_oram = $this->seller_model->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$start_date1'");
            $nmonth = $start_date1;

           $month_amt=$res_oram[0]['total_order_amt']+$res_oram[0]['total_delivery_charges']; 
           $moths_data[]='['.'"'.$nmonth.'"'.','.$month_amt.']';
          //echo $this->db->last_query(); die;
      }
     }

      if(isset($_GET['type']) && $_GET['type']==1)
       {
          $year=date('Y');
          $res_oram = $this->seller_model->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND YEAR(`ecom_orders`.`order_datetime`)='$current_year'");
            $nmonth = date('Y');

           $month_amt=$res_oram[0]['total_order_amt']+$res_oram[0]['total_delivery_charges']; 
           $moths_data[]='['.'"'.$nmonth.'"'.','.$month_amt.']';
          //echo $this->db->last_query(); die;
      
     }
            //echo "<pre>";
           //print_r($moths_data); die;  
    }
    $this->data['total_months_wise_sales']=$moths_data;
    $this->data['previous_total_order']=$previous_total_order;
    $this->data['total_order']=$total_order;
    $this->data['total_sales']=$res_ora;
      //echo "<pre>";
      //print_r($this->data); die;

    $this->template->seller_render_page('seller/transaction_report/transaction_report',$this->data);
  }

  public function update($id, $data) {

        return $this->db->update($this->table, $data, ['id' => $id]);

    }

  public function delete() {
      $delete = $this->cities_model->delete($this->input->post('city_id'));
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
