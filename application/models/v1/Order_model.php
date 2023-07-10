<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->tables = [
        	'ecom_orders'     => 'ecom_orders',
            'ecom_order_items'     => 'ecom_order_items',
            'ecom_cart'       => 'ecom_cart',
            'ecom_products'   => 'ecom_products',
            'ecom_cart'       => 'ecom_cart',
            'ecom_cart_items' => 'ecom_cart_items',
            'ecom_addresses' => 'ecom_addresses',
            'ecom_product_units'=>'ecom_product_units',
            'ecom_product_images'=>'ecom_product_images',
            'ecom_promocode_usage_history'=>'ecom_promocode_usage_history',
            'ecom_promocodes'=>'ecom_promocodes'
        ];
    }


     public function insert($data) {
        $this->db->insert($this->tables['ecom_orders'], $data);
        return $this->db->insert_id();
    }

     public function insert_order_item($data) {
        $this->db->insert($this->tables['ecom_order_items'], $data);
        return $this->db->insert_id();
    }

    public function get_order_data()
    {
    	 $this->db->select('id,order_no');
        $this->db->order_by($this->tables['ecom_orders'].'.id', 'DESC');
        $this->db->limit(1);
    	$query = $this->db->get($this->tables['ecom_orders']);
    	if ($query->num_rows() > 0) {
            $res= $query->result();
            $order_id=$res[0]->id;
            $order_number='TNS'.date('dmY').($order_id+1);
        }else{
          $no=1;
          $order_number='TNS'.date('dmY').$no;
        }
       
       return $order_number;
    }

    public function get_cart_item($user_id) {
         $this->db->select($this->tables['ecom_cart'].'.id as cart_id,'.$this->tables['ecom_cart_items'].'.id as cart_item_id,pid,quantity');
         $this->db->join($this->tables['ecom_cart_items'], $this->tables['ecom_cart'].'.id = '.$this->tables['ecom_cart_items'].'.cart_id', 'LEFT');
        $this->db->where($this->tables['ecom_cart'].'.user_id',$user_id);
        $query = $this->db->get($this->tables['ecom_cart']);
        if($query->num_rows() > 0) 
        {
             return $query->result();
        }else{
             return false;
            }
    }

    public function get_cart_products($id) {
        return $this->db->get_where($this->tables['ecom_products'], ['id' => $id])->row();
    }

    public function delete_cart_item($user_id)
    {
      $res =  $this->db->get_where($this->tables['ecom_cart'], ['user_id' => $user_id])->result();
      if(!empty($res))
      {
           $this->db->where(array('cart_id'=>$res[0]->id))->delete($this->tables['ecom_cart_items']);
           $this->db->where(array('user_id'=>$user_id))->delete($this->tables['ecom_cart']);
           
      }
   
    }

public function get_my_orders($user_id,$filter_type) {
         $this->db->select($this->tables['ecom_orders'].'.id as order_id,order_no,order_datetime,order_track_status,'.'sum('.$this->tables['ecom_order_items'].'.quantity) as total_qty,'.'sum('.$this->tables['ecom_order_items'].'.unit_price) as total_amount');
         $this->db->join($this->tables['ecom_order_items'], $this->tables['ecom_orders'].'.id = '.$this->tables['ecom_order_items'].'.order_id', 'LEFT');
        $this->db->where($this->tables['ecom_orders'].'.user_id',$user_id);
        if($filter_type==1)
        {
        $this->db->where($this->tables['ecom_orders'].'.order_track_status','1');

        }
        if($filter_type==2)
        {
        $this->db->where($this->tables['ecom_orders'].'.order_track_status','2');

        }
         if($filter_type==3)
        {
        $this->db->where($this->tables['ecom_orders'].'.order_track_status','3');

        }
        $query = $this->db->get($this->tables['ecom_orders']);
        if($query->num_rows() > 0) 
        {
            $res=$query->result();
            if($res[0]->order_id)
            {
            foreach ($res as $key => $value) {
                $res[$key]->order_date=date('d-m-Y',strtotime($value->order_datetime));
               if($value->order_track_status=='1')
               {
                $res[$key]->order_track_status='Proccessing';
               }else if($value->order_track_status=='2')
               {
                $res[$key]->order_track_status='Delivered';
               }else{
                 $res[$key]->order_track_status='Cancelled'; 
               }
               
            }
            return $res;
           }else{
            return false;
           } 
          
        }else{
             return false;
            }
    }



    public function get_order_details($user_id,$order_id) {
         $this->db->select($this->tables['ecom_orders'].'.id as order_id,order_no,order_datetime,order_track_status,delivery_charges,payment_status,'.$this->tables['ecom_order_items'].'.pid,quantity,unit_price,item_price,'.$this->tables['ecom_addresses'].'.first_name,last_name,address,city,state,country,postcode,phone,email,type');
         $this->db->join($this->tables['ecom_order_items'], $this->tables['ecom_orders'].'.id = '.$this->tables['ecom_order_items'].'.order_id', 'LEFT');
        $this->db->join($this->tables['ecom_addresses'], $this->tables['ecom_orders'].'.address_id = '.$this->tables['ecom_addresses'].'.id', 'LEFT');
        $this->db->where($this->tables['ecom_orders'].'.id',$order_id);
        $this->db->where($this->tables['ecom_orders'].'.user_id',$user_id);
        $query = $this->db->get($this->tables['ecom_orders']);
        //echo $this->db->last_query(); die;
        if($query->num_rows() > 0) 
        {
            $res=$query->result();
            $res[0]->order_date=date('d-m-Y',strtotime($res[0]->order_datetime));
               if($res[0]->order_track_status=='1')
               {
                $res[0]->order_track_status='Proccessing';
               }else if($res[0]->order_track_status=='2')
               {
                $res[0]->order_track_status='Delivered';
               }else{
                 $res[0]->order_track_status='Cancelled'; 
               }
               
               if($res[0]->payment_status=='1')
               {
                $res[0]->payment_status='Success';
               }elseif($res[0]->payment_status=='0'){
                 $res[0]->payment_status='Pending'; 
               }else{
                 $res[0]->payment_status='Failed';
               }
            foreach ($res as $key => $value) {
          $this->db->select($this->tables['ecom_products'].'.id as product_id,product_name,short_description,long_description,product_highlights,discount_percent,price,stock,min_order_qty,returnable,available,variants,'.$this->tables['ecom_product_units'].'.unit');
          $this->db->join($this->tables['ecom_product_units'], $this->tables['ecom_products'].'.unit_id = '.$this->tables['ecom_product_units'].'.id', 'LEFT');
          $this->db->where($this->tables['ecom_products'].'.id',$value->pid);
          $query_product = $this->db->get($this->tables['ecom_products']);
           if ($query_product->num_rows() > 0) {
               $res_product= $query_product->result()[0];
               $res_product->quantity=$value->quantity;
               $res_product->item_price=$value->item_price;
               $res_product->total_unit_price=$value->unit_price;
               
                /*------------------Get Product Image----------------*/
                $product_image_url=base_url('uploads/products/');
                $res_image=$this->get_sql_query($this->tables['ecom_product_images'],'IF(search_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",search_image)) AS search_image,IF(catalog_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",catalog_image)) AS catalog_image,IF(cart_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",cart_image)) AS cart_image,',array('pid'=>$res_product->product_id));
                   if(!empty($res_image))
                   {
                     $res_product->product_image=@$res_image;
                   }else{
                     $res_product->product_image=array();
                   }
                 }
            
                $product_arr[]=$res_product;
            }
           
          $arr=array('order_id'=>$res[0]->order_id,'order_no'=>$res[0]->order_no,'order_date'=>$res[0]->order_date,'order_track_status'=>$res[0]->order_track_status,'delivery_charges'=>$res[0]->delivery_charges,'payment_status'=>$res[0]->payment_status,'full_name'=>$res[0]->first_name,'address'=>$res[0]->address,'city'=>$res[0]->city,'state'=>$res[0]->state,'country'=>$res[0]->country,'postcode'=>$res[0]->postcode,'phone'=>$res[0]->phone,'email'=>$res[0]->email,'type'=>$res[0]->type,'item_details'=>$product_arr);
           return $arr;
        }else{
             return false;
         }
    }

    public function promo_code_apply($amount,$user_id,$promo_code)
    {
     
         $res_pc=$this->get_sql_query($this->tables['ecom_promocodes'],'*',array('promocode'=>$promo_code,'is_deleted'=>'0'));

         if(!empty($res_pc))
         {
            if($res_pc[0]->expiry_date >= date('Y-m-d'))
            {
                  $res=$this->get_sql_query($this->tables['ecom_promocode_usage_history'],'promocode',array('promocode'=>$promo_code,'user_id'=>$user_id));
                   if(!empty($res) && $res_pc[0]->per_user <=count($res))
                   {
                     $data['status']='2';  //You are already use this promo-code. 
                   }else{
                         if($res_pc[0]->promocode_type==1)
                         {
                           $discount_amount=($amount*$res_pc[0]->discount)/100;
                         }else{
                           $discount_amount=$amount-$res_pc[0]->discount;
                            
                         }
                         if(empty($res))
                         {
                          $data_insert=array('promocode_id'=>$res_pc[0]->id,'promocode'=>$res_pc[0]->promocode,'user_id'=>$user_id); 
                         $this->db->insert($this->tables['ecom_promocode_usage_history'],$data_insert);

                          }

                          $data=array('promo_code_id'=>$res_pc[0]->id,'promo_code'=>$res_pc[0]->promocode,'promocode_title'=>$res_pc[0]->promocode_title,'discount_amount'=>$discount_amount);
                      $data['status']='1'; 
                   }
                return $data;
            }else{

                $data['status']='3'; //Promo code expireed
                 return $data;
            }
         }else{
             $data['status']='4'; //Invalid promo-code.
              return $data;
         }
         
       
    }

    public function get_sql_query($table_name,$fields,$where) {
        $this->db->select($fields);
        $this->db->where($where);
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }   

}