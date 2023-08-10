<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Seller_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->tables = [
        	'ecom_sellers' => 'ecom_sellers',
            'ecom_orders' => 'ecom_orders',
            'product_images'=>'ecom_product_images',
            'level1_category'=>'ecom_level1_category',
            'level2_category'=>'ecom_level2_category',
            'order_items'=>'ecom_order_items',
            'ecom_addresses'=>'ecom_addresses',
            'notifications' => 'notifications',
            'ecom_products'=>'ecom_products'
        ];
    }


    public function login($mobile_no,$otp)
    {
        $this->db->select($this->tables['ecom_sellers'].'.*');
        $this->db->where($this->tables['ecom_sellers'].'.mobile_no', $mobile_no);
        $this->db->where($this->tables['ecom_sellers'].'.otp', $otp);
        $query = $this->db->get($this->tables['ecom_sellers']);

        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return FALSE;
    }

    public function check_user_email_exist($email)
    {
    	$this->db->select($this->tables['ecom_sellers'].'.*');
        $this->db->where($this->tables['ecom_sellers'].'.email_id', $email);
    	$query = $this->db->get($this->tables['ecom_sellers']);

    	if ($query->num_rows() > 0) {
            return $query->row();
        }

        return FALSE;
    }

    public function check_user_phone_exist($phone)
    {
        $this->db->select($this->tables['ecom_sellers'].'.*');
        $this->db->where($this->tables['ecom_sellers'].'.mobile_no', $phone);
        $query = $this->db->get($this->tables['ecom_sellers']);

        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return FALSE;
    }

    public function update_user_data($where, $data)
    {
        return $this->db->update($this->tables['users'], $data, $where);
    }

    public function check_referral_exist($referral_code)
    {
        $this->db->select($this->tables['users'].'.referral_code');
        $this->db->where($this->tables['users'].'.referral_code', $referral_code);
        $query = $this->db->get($this->tables['users']);

        if ($query->num_rows() > 0) {
            return ['status' => 0, 'data' => $query->row()];
        }

        return ['status' => 1, 'data' => ''];
    }

    public function register($data)
    {
            $this->db->insert($this->tables['ecom_sellers'],$data);
            $id=$this->db->insert_id();
            if($id) {
                return $id;           
            }else{
                return false;
            }
        
    }

    public function get_earning_points($user_id)
    {
        $this->db->select($this->tables['user_points'].'.*,'.$this->tables['orders'].'.order_unique_id,'.$this->tables['users'].'.first_name');
        $this->db->join($this->tables['orders'], $this->tables['user_points'].'.order_id = '.$this->tables['orders'].'.order_id', 'LEFT');
        $this->db->join($this->tables['users'], $this->tables['user_points'].'.from_user_id = '.$this->tables['users'].'.id', 'LEFT');
        $this->db->where($this->tables['user_points'].'.user_id', $user_id);
        $this->db->where($this->tables['user_points'].'.is_active', 1);
        $query = $this->db->get($this->tables['user_points']);

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

    public function check_referral_code($referral_code)
    {
        $this->db->select($this->tables['users'].'.referral_code');
        $this->db->where($this->tables['users'].'.referral_code', $referral_code);
        $query = $this->db->get($this->tables['users']);

        if ($query->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    public function update_user_token($data) {
        $token = $this->db->get_where($this->tables['user_device_token'], ['device_id' => $data['device_id']])->row();
        if (is_null($token)) {
            return $this->db->insert($this->tables['user_device_token'], $data);
        } else {
            return $this->db->update($this->tables['user_device_token'], $data, ['id' => $token->id]);
        }
    }

    public function delete_user_account($user_id) {
        return $this->db->update($this->tables['users'], ['is_deleted' => 1], ['id' => $user_id]);
    }

    public function notification_list($user_id, $offset, $limit) {
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('notification_id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get($this->tables['notifications']);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function order_list($seller_id)
   {

         // $seller_id=$this->session->userdata('user_id');
        if(isset($_GET['status']))
         {
          $where='AND  (`ecom_orders`.`order_track_status`='.$_GET['status'].')';
         }else if(isset($_GET['payment_status']))
         {
          $where='AND `ecom_orders`.`payment_status`="0"';
         }else{
          $where='';
         }
    $res = $this->simple_query("SELECT id FROM `ecom_products` WHERE seller_id='".$seller_id ."' ORDER BY id");
    if(!empty($res)){

      $products_arr=array();
      foreach($res as $key => $value) {
              $products_arr[] = $value['id'];
      }
      $all_pid=implode(',',$products_arr);
      $res_orders = $this->simple_query("SELECT `ecom_orders`.*,`ecom_order_items`.`quantity` as item_qty,`ecom_order_items`.`unit_price`,`ecom_order_items`.`item_price`,`ecom_addresses`.`first_name`,`ecom_addresses`.`last_name` FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) $where Group by `ecom_order_items`.`order_id`");
        //echo $this->db->last_query();
      }

      return $res_orders;
   }

   public function simple_query($sql){ 
      $query = $this->db->query($sql);
      if($query->num_rows() >0)
      {
       return $query->result_array();
      }else{
        false;
      }
   }

       public function order_details($id) {
  
        $where=array('id'=>$id);
        $res= $this->db->get_where($this->tables['ecom_orders'],$where)->result_array();
       // echo $this->db->last_query(); die;
        if(!empty($res))
        {
            foreach ($res as $key => $value) {
                   $res[$key]['order_details']=unserialize($value['order_item_array']);
                   //echo "<pre>";
                 //print_r($res[$key]['order_details']); die;
                foreach ($res[$key]['order_details'] as $key_p => $value_p) {
                   /*----------------------Product Image Get----------------------*/ 
                   $res_pimage= $this->db->get_where($this->tables['product_images'], ['pid' => $value_p->id])->result_array();
                  if(!empty($res_pimage))
                   {
                   $res[$key]['order_details'][$key_p]->product_image=base_url('images/product/'.$res_pimage[0]['search_image']);
                   }else{
                    $res[$key]['order_details'][$key_p]->product_image='';
                   }

                   /*----------------------Product Category Get----------------------*/ 
                   $res_cat1= $this->db->get_where($this->tables['level1_category'], ['id' => $value_p->id])->result_array();
                  if(!empty($res_cat1))
                   {
                   $res[$key]['order_details'][$key_p]->cat_name=$res_cat1[0]['l1_category'];
                   }else{
                    $res[$key]['order_details'][$key_p]->cat_name='';
                   }

                   /*----------------------Product Sub Category Get----------------------*/ 
                   $res_cat2= $this->db->get_where($this->tables['level2_category'], ['id' => $value_p->id])->result_array();
                  if(!empty($res_cat2))
                   {
                   $res[$key]['order_details'][$key_p]->cat_sub_name=$res_cat2[0]['l2_category'];
                   }else{
                    $res[$key]['order_details'][$key_p]->cat_sub_name='';
                   }

                   /*----------------------Product Price Get----------------------*/ 
                   $res_pirce= $this->db->get_where($this->tables['order_items'], ['pid' => $value_p->id,'order_id' => $id])->result_array();
                  if(!empty($res_pirce))
                   {
                   $res[$key]['order_details'][$key_p]->unit_price=$res_pirce[0]['unit_price'];
                   $res[$key]['order_details'][$key_p]->product_qty=$res_pirce[0]['quantity'];

                   }else{
                    $res[$key]['order_details'][$key_p]->unit_price=0;
                   $res[$key]['order_details'][$key_p]->product_qty=0;

                   }

                }

                $res_address= $this->db->get_where($this->tables['ecom_addresses'], ['id' => $value['address_id'],'user_id'=>$value['user_id']])->result_array();
               if(!empty($res_address))
                 {
                   $res[$key]['customer_address']=$res_address[0];
                 }else{
                    $res[$key]['customer_address']=array();
                 } 
                
            }
        }
        //echo "<pre>";
        //print_r($res); die;
        return $res;
    }

    public function dashboard($seller_id) {
    $res_ora=array();
    $moths_data=array();
    $total_order=0;
    $previous_total_order=0;
    $res = $this->simple_query("SELECT id FROM `ecom_products` WHERE seller_id='".$seller_id ."' ORDER BY id");
    if(!empty($res)){

      $products_arr=array();
      foreach($res as $key => $value) {
              $products_arr[] = $value['id'];
      }
      $all_pid=implode(',',$products_arr);
      //print_r($all_pid); die;
      $current_date=date('Y-m-d'); 
      $previous_date= date('Y-m-d', strtotime($current_date. ' - 1 days')); 
      $res_ora = $this->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$current_date'");

      $res_tord = $this->simple_query("SELECT count(*) as total FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$current_date' Group by `ecom_order_items`.`order_id`");
      if(!empty($res_tord[0]['total']))
      {
        $total_order= count($res_tord);  
      }

      $res_ptord = $this->simple_query("SELECT count(*) as total FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND DATE(`ecom_orders`.`order_datetime`)='$previous_date' Group by `ecom_order_items`.`order_id`");
      if(!empty($res_ptord[0]['total']))
      {
        $previous_total_order= count($res_ptord);  
      }
       $current_year=date('Y');
       
      for ($i=1; $i <= 12; $i++) { 
          
          $res_oram = $this->simple_query("SELECT SUM(`ecom_orders`.`delivery_charges`) as total_delivery_charges,SUM(`ecom_order_items`.`unit_price`) as total_order_amt FROM `ecom_orders` JOIN `ecom_order_items` ON `ecom_order_items`.`order_id`=`ecom_orders`.`id` LEFT JOIN `ecom_addresses` ON `ecom_orders`.`address_id`=`ecom_addresses`.`id` WHERE  `ecom_order_items`.`pid` IN($all_pid) AND MONTH(`ecom_orders`.`order_datetime`)='$i' AND YEAR(`ecom_orders`.`order_datetime`)='$current_year'");
            $nmonth = date('F', mktime(0, 0, 0, $i, 10));
           if(!empty($res_oram[0]['total_order_amt']))
           {
             $total_order_amt=$res_oram[0]['total_order_amt'];
           }else{
             $total_order_amt=0; 
           }
           if(!empty($res_oram[0]['total_delivery_charges']))
           {
             $total_delivery_charges=$res_oram[0]['total_delivery_charges'];
           }else{
            $total_delivery_charges=0;
           }
           $month_amt=$total_order_amt+$total_delivery_charges; 
           $moths_data[]=array($nmonth=>$month_amt);
      }
    }


    if(!empty($res_ora[0]['total_order_amt']))
           {
             $total_order_amt_t=$res_ora[0]['total_order_amt'];
           }else{
             $total_order_amt_t=0; 
           }
           if(!empty($res_ora[0]['total_delivery_charges']))
           {
             $total_delivery_charges_t=$res_ora[0]['total_delivery_charges'];
           }else{
            $total_delivery_charges_t=0;
           }
   // $total_sales_arr=array('total_order_amt'=>$total_order_amt_t,'total_delivery_charges'=>$total_delivery_charges_t);       
    $data['total_months_wise_sales']=$moths_data;
    $data['previous_total_order']=$previous_total_order;
    $data['total_order']=$total_order;
    $data['total_sales']=$total_order_amt_t+$total_delivery_charges_t;
    $data['product_view']=0;
    return $data;  
  }

 public function product_list($id) {
         if(isset($_POST['cid']) && !empty($_POST['cid']))
         {
          $where=array('seller_id'=>$id,'l1c_id'=>$_POST['cid']);
         }else{
          $where=array('seller_id'=>$id);

         }
        $res= $this->db->get_where($this->tables['ecom_products'],$where)->result_array();
        if(!empty($res))
        {
            foreach ($res as $key => $value) {

                 $res_pimage= $this->db->get_where($this->tables['product_images'], ['pid' => $value['id']])->result_array();
               if(!empty($res_pimage))
                 {
                   $res[$key]['product_image']=base_url('images/product/'.$res_pimage[0]['search_image']);
                 }else{
                    $res[$key]['product_image']='';
                 }  
                
            }
        }
        return $res;
    }

public function get_single_product($pid)
{
  $res=$this->db->get_where($this->tables['ecom_products'], ['id' =>$pid])->result_array()[0];
  $res['product_img']=$this->general_model->getAll($this->tables['product_images'],array('pid'=>$pid));
  return $res; 
}    

}