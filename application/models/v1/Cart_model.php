<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tables = [
			'introductions' => 'introductions',
			'orders' => 'orders',
			'payment_history' => 'payment_history',
			'point_system' => 'point_system',
			'user_points' => 'user_points',
			'restaurant_off_dates' => 'restaurant_off_dates',
			'working_hours' => 'working_hours',
			'ecom_cart' => 'ecom_cart', 
			'ecom_cart_items' => 'ecom_cart_items',
			'ecom_products' => 'ecom_products',
            'ecom_product_units' => 'ecom_product_units',
            'ecom_product_images' => 'ecom_product_images', 
             'ecom_delivery_charges' => 'ecom_delivery_charges' 
		];
	}

	public function get_introduction() {
		$this->db->select($this->tables['introductions'].'.*');
		$this->db->order_by($this->tables['introductions'].'.order_number','ASC');
		$query = $this->db->get($this->tables['introductions']);

		if ($query->num_rows() > 0) {
			return $query->result();
		}

		return FALSE;
	}

	public function place_order($data) {
		$this->db->insert($this->tables['orders'], $data);
		return $this->db->insert_id();
	}

	public function save_transcation($data) {
		$this->db->insert($this->tables['payment_history'], $data);
		return $this->db->insert_id();
	}

	public function get_point_system_data() {
		$this->db->select($this->tables['point_system'].'.*');
		$this->db->limit(1);
		$query = $this->db->get($this->tables['point_system']);

		if ($query->num_rows() > 0) {
			return $query->row();
		}

		return FALSE;
	}

	public function get_order($order_id) {
		$this->db->select($this->tables['orders'].'.*');
		$this->db->where($this->tables['orders'].'.order_id', $order_id);
		$query = $this->db->get($this->tables['orders']);

		if ($query->num_rows() > 0) {
			return $query->row();
		}

		return FALSE;
	}

	public function get_order_earning_point($order_id, $user_id) {
		$this->db->select($this->tables['user_points'].'.*');
		$this->db->where($this->tables['user_points'].'.order_id', $order_id);
		$this->db->where($this->tables['user_points'].'.user_id', $user_id);
		$query = $this->db->get($this->tables['user_points']);

		if ($query->num_rows() > 0) {
			return $query->row();
		}

		return FALSE;
	}

	public function add_to_cart($data) {
			$query1 = $this->db->get_where($this->tables['ecom_cart'], [ 'user_id' =>$data['user_id']]);
			if ($query1->num_rows() > 0) {
				$row= $query1->row();
				$cart_id=$row->id;
				//print_r($row); die;
			}else{
				$this->db->insert($this->tables['ecom_cart'],array('user_id'=>$data['user_id']));
				$cart_id= $this->db->insert_id();
			} 
		if(!empty($cart_id))
		{
				$query2 = $this->db->get_where($this->tables['ecom_cart_items'],array('pid'=>$data['product_id'],'cart_id'=>$cart_id));
			if ($query2->num_rows() < 1) {
			$this->db->insert($this->tables['ecom_cart_items'],array('pid'=>$data['product_id'],'cart_id'=>$cart_id,'quantity'=>$data['quantity']));
			$cart_item_id= $this->db->insert_id();
			 if(!empty($cart_item_id))
			 {
               $res['status']=1;
			 }else{
                $res['status']=0;
			 }
		    }else{
		    	 $res['status']=2;
		    }
	
		}else{
           $res['status']=0;
		}
		return $res;
	}

public function get_cart_item($data) {
		 $this->db->select($this->tables['ecom_cart'].'.id as cart_id,'.$this->tables['ecom_cart_items'].'.id as cart_item_id,pid,quantity');
         $this->db->join($this->tables['ecom_cart_items'], $this->tables['ecom_cart'].'.id = '.$this->tables['ecom_cart_items'].'.cart_id', 'LEFT');
       	$this->db->where($this->tables['ecom_cart'].'.user_id',$data['user_id']);
		$query = $this->db->get($this->tables['ecom_cart']);
			if ($query->num_rows() > 0) {
				$product_arr=array();      
				$res= $query->result();
	     $total_quantity=0;
         $total_amount=	0;		
		foreach ($res as $key => $value) {
         $this->db->select($this->tables['ecom_products'].'.id,product_name,short_description,long_description,product_highlights,discount_percent,price,stock,min_order_qty,returnable,available,variants,'.$this->tables['ecom_product_units'].'.unit');
          $this->db->join($this->tables['ecom_product_units'], $this->tables['ecom_products'].'.unit_id = '.$this->tables['ecom_product_units'].'.id', 'LEFT');
          $this->db->where($this->tables['ecom_products'].'.id',$value->pid);
          $query_product = $this->db->get($this->tables['ecom_products']);
           if ($query_product->num_rows() > 0) {
               $res_product= $query_product->result()[0];
               $res_product->cart_item_id=$value->cart_item_id;
               $res_product->cart_id=$value->cart_id;
               $res_product->quantity=$value->quantity;
               $res_product->total_unit_price=$res_product->price*$value->quantity;

               $total_quantity+=$value->quantity;

               $total_amount+=$res_product->price*$value->quantity;
         
                /*------------------Get Product Image----------------*/
                $product_image_url=base_url('uploads/products/');
                $res_image=$this->get_sql_query($this->tables['ecom_product_images'],'IF(search_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",search_image)) AS search_image,IF(catalog_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",catalog_image)) AS catalog_image,IF(cart_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",cart_image)) AS cart_image,',array('pid'=>$res_product->id));
	               if(!empty($res_image))
	               {
	                 $res_product->product_image=@$res_image;
	               }else{
	                 $res_product->product_image=array();
	               }
           	     }
            
                $product_arr[]=$res_product;
           	 
			}
			

			$obj=array('total_quantity'=>$total_quantity,'total_amount'=>$total_amount,'data'=>$product_arr);
         return $obj;
	}else{
			return FALSE;
	}

}

public function delete_cart_item($data)
{
	$res=$this->get_sql_query($this->tables['ecom_cart_items'],'id',array('cart_id'=>$data['cart_id']));
	if(!empty($res))
	{
	  $total_item=count($res);	
	  if($total_item==1)
	  {
        $this->db->where(array('user_id'=>$data['user_id'],'id'=>$data['cart_id']))->delete($this->tables['ecom_cart']);
         return $this->db->where(array('id'=>$data['cart_item_id']))->delete($this->tables['ecom_cart_items']);
	  }else{
         return $this->db->where(array('id'=>$data['cart_item_id']))->delete($this->tables['ecom_cart_items']);
	  }
 
	}else{
     return FALSE;
	}    
}

public function update_cart_item($data)
 {
 	$res=$this->get_sql_query($this->tables['ecom_cart_items'],'id',array('id'=>$data['cart_item_id']));
	if(!empty($res))
	{
     return $this->db->update($this->tables['ecom_cart_items'],array('quantity'=>$data['quantity']),array('id'=>$data['cart_item_id']));
    }else{
       return FALSE;
    }
}


public function get_checkout_details($data) {
		 $this->db->select($this->tables['ecom_cart'].'.id as cart_id,'.$this->tables['ecom_cart_items'].'.id as cart_item_id,pid,quantity');
         $this->db->join($this->tables['ecom_cart_items'], $this->tables['ecom_cart'].'.id = '.$this->tables['ecom_cart_items'].'.cart_id', 'LEFT');
       	$this->db->where($this->tables['ecom_cart'].'.user_id',$data['user_id']);
		$query = $this->db->get($this->tables['ecom_cart']);
			if ($query->num_rows() > 0) {
				$product_arr=array();      
				$res= $query->result();
	     $total_quantity=0;
         $total_amount=	0;		
		foreach ($res as $key => $value) {
         $this->db->select($this->tables['ecom_products'].'.id,product_name,short_description,long_description,product_highlights,discount_percent,price,stock,min_order_qty,returnable,available,variants,'.$this->tables['ecom_product_units'].'.unit');
          $this->db->join($this->tables['ecom_product_units'], $this->tables['ecom_products'].'.unit_id = '.$this->tables['ecom_product_units'].'.id', 'LEFT');
          $this->db->where($this->tables['ecom_products'].'.id',$value->pid);
          $query_product = $this->db->get($this->tables['ecom_products']);
           if ($query_product->num_rows() > 0) {
               $res_product= $query_product->result()[0];
               //$res_product->cart_item_id=$value->cart_item_id;
              // $res_product->cart_id=$value->cart_id;
               $total_quantity+=$value->quantity;
               $total_amount+=$res_product->price*$value->quantity;
           	    }
             
			}

			$obj=array('total_quantity'=>$total_quantity,'total_amount'=>$total_amount);
         return $obj;
	}else{
			return FALSE;
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