<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Home_model extends CI_Model {



    public function __construct() {

        parent::__construct();

        $this->tables = [

            'ecom_level1_category' => 'ecom_level1_category',

            'ecom_level2_category' => 'ecom_level2_category',

            'ecom_products' => 'ecom_products',

            'ecom_product_images' => 'ecom_product_images',

            'ecom_product_bunches' => 'ecom_product_bunches',

            'ecom_product_unit_value' => 'ecom_product_unit_value',

            'ecom_carts' => 'ecom_carts',

            'ecom_orders' => 'ecom_orders',

            'user_plans' => 'user_plans',

            'ecom_addresses' => 'ecom_addresses',

            'subscriptions' => 'subscriptions',

            'ecom_payments' => 'ecom_payments',

            'users' => 'users',

        ];

        $this->limit = 4;

        $this->productlimit = 16;



        

		$this->plan1 = [

            'category1' => 15,

            'category2' => 10,

            'category3' => 0,

        ];



        $this->plan2 = [

            'category1' => 20,

            'category2' => 15,

            'category3' => 5,

        ];



        $this->plan3 = [

            'category1' => 30,

            'category2' => 25,

            'category3' => 10,

        ];



        $this->subscriptions = [

            'plan1' => 5.01,

            'plan2' => 6.01,

            'plan3' => 8.01,

            'plan4' => 7.01,

            'plan5' => 9.01,

            'plan6' => 12.01,

            'plan7' => 15.01,

            'plan8' => 17.01,

            'plan9' => 20.01,

        ];

    }



    public function all_subscriptions() {

        $this->db->select('*');

        $query = $this->db->get($this->tables['subscriptions']);

        if ($query->num_rows()) {

            return $query->result();

        }

        return FALSE;

    }



    public function all_products() {

        $this->db->select('*');

        $this->db->where(['is_deleted' => 0]);

        $this->db->order_by('id',"desc");

        $this->db->limit($this->limit, 0);

        $query = $this->db->get($this->tables['ecom_products']);

        

        if ($query->num_rows()) {

            return $query->result();

        }

        return FALSE;

    }



    

    public function get_categories() {

        $this->db->select('*');

        $this->db->where(['is_deleted' => 0]);

        $query = $this->db->get($this->tables['ecom_level1_category']);

        if ($query->num_rows()) {

            return $query->result();

        }

        return FALSE;

    }

 

    public function get_subcategories($l1c_id) {

        $this->db->select('l2.*, l1.l1_category');

        $this->db->join($this->tables['ecom_level1_category'].' l1', 'l2.l1c_id = l1.id');

        $this->db->where(['l2.is_deleted' => 0, 'l2.l1c_id' => $l1c_id]);

        $this->db->limit($this->limit, 0);

        $query = $this->db->get($this->tables['ecom_level2_category']. ' l2');

        if ($query->num_rows()) {

            return $query->result();

        }

        return FALSE;

    }



    public function get_products($l2c_id) {

        $this->db->select('p.*, l1.l1_category, l2.l2_category');

        $this->db->join($this->tables['ecom_level1_category'].' l1', 'p.l1c_id = l1.id');

        $this->db->join($this->tables['ecom_level2_category'].' l2', 'p.l2c_id = l2.id');

        $this->db->where(['p.is_deleted' => 0, 'p.l2c_id' => $l2c_id]);

        $this->db->limit($this->productlimit, 0);

        $query = $this->db->get($this->tables['ecom_products']. ' p');

        if ($query->num_rows()) {

            return $query->result();

        }

        return FALSE;

    }

    public function get_product_details($product_id) {

        $this->db->select('p.*, l1.l1_category, l2.l2_category');

        $this->db->join($this->tables['ecom_level1_category'].' l1', 'p.l1c_id = l1.id');

        $this->db->join($this->tables['ecom_level2_category'].' l2', 'p.l2c_id = l2.id');

        $this->db->where(['p.id' => $product_id]);

        $query = $this->db->get($this->tables['ecom_products']. ' p');

        if ($query->num_rows()) {

            return $query->row();

        }

        return FALSE;

    }

    public function get_all_product_images($id) {

        return $this->db->get_where($this->tables['ecom_product_images'], ['pid' => $id])->result();

    }

    

    public function cart_count($user_id) {

        $this->db->select('p.*');

        $this->db->join($this->tables['ecom_carts'].' c', 'p.id = c.product_id');

        $this->db->where(['c.user_id' => $user_id]);

        $query = $this->db->get($this->tables['ecom_products'].' p');

        return $query->num_rows();

    }

    public function get_cart_products($id) {

        return $this->db->get_where($this->tables['ecom_products'], ['id' => $id])->row();

    }

    // public function get_product_bunches($id) {

    //     return $this->db->get_where($this->tables['ecom_product_bunches'], ['product_id' => $id])->result();

    // }

    // public function get_product_details($product_id) {

    //     $this->db->select('p.*, l1.l1_category, l2.l2_category');

    //     $this->db->join($this->tables['ecom_level1_category'].' l1', 'p.l1c_id = l1.id');

    //     $this->db->join($this->tables['ecom_level2_category'].' l2', 'p.l2c_id = l2.id');

    //     $this->db->where(['p.id' => $product_id]);

    //     $query = $this->db->get($this->tables['ecom_products']. ' p');

    //     if ($query->num_rows()) {

    //         return $query->row();

    //     }

    //     return FALSE;

    // }



    public function get_product_image($id) {

        return $this->db->get_where($this->tables['ecom_product_images'], ['pid' => $id])->row();

    }





    // public function cart_count($user_id) {

    //     $this->db->select('p.*');

    //     $this->db->join($this->tables['ecom_carts'].' c', 'p.id = c.product_id');

    //     $this->db->where(['c.user_id' => $user_id]);

    //     $query = $this->db->get($this->tables['ecom_products'].' p');

    //     return $query->num_rows();

    // }



    public function all_unit_values($unit_id) {

        $this->db->select('ev.*, eu.short_name');

        $this->db->join($this->tables['ecom_product_units'].' eu', 'ev.product_unit_id = eu.id');

        $this->db->where(['ev.product_unit_id' => $unit_id]);

        $query = $this->db->get($this->tables['ecom_product_unit_value'].' ev');

        if ($query->num_rows()) {

            return $query->result();

        }

        return FALSE;

    }



    public function unit_value($unit_value_id) {

        return $this->db->get_where($this->tables['ecom_product_unit_value'], ['id' => $unit_value_id])->row();

    }

    public function get_ecom_addresses($user_id) {

        return $this->db->order_by('id',"desc")->get_where($this->tables['ecom_addresses'], ['user_id' => $user_id])->result();

    }



    public function check_cart_limit($user_id, $plan_id, $l2c_id) {

        $this->db->select('*');

        $this->db->where(['user_id' => $user_id, 'l2c_id' => $l2c_id]);

        $query = $this->db->get($this->tables['ecom_carts']);

        $rows = $query->num_rows();

        if ($plan_id == '1' || $plan_id == '4' || $plan_id == '7') {

            if ($l2c_id == '1') {

                if ($rows >= $this->plan1['category1']) {

                    return false;

                }

            } else if ($l2c_id == '2'){

                if ($rows >= $this->plan1['category2']) {

                    return false;

                }

            } else if ($l2c_id == '3'){

                if ($rows >= $this->plan1['category3']) {

                    return false;

                }

            }

        } else if ($plan_id == '2' || $plan_id == '5' || $plan_id == '8') {

            if ($l2c_id == '1') {

                if ($rows >= $this->plan2['category1']) {

                    return false;

                }

            } else if ($l2c_id == '2'){

                if ($rows >= $this->plan2['category2']) {

                    return false;

                }

            } else if ($l2c_id == '3'){

                if ($rows >= $this->plan2['category3']) {

                    return false;

                }

            }

        } else if ($plan_id == '3' || $plan_id == '6' || $plan_id == '9') {

            if ($l2c_id == '1') {

                if ($rows >= $this->plan3['category1']) {

                    return false;

                }

            } else if ($l2c_id == '2'){

                if ($rows >= $this->plan3['category2']) {

                    return false;

                }

            } else if ($l2c_id == '3'){

                if ($rows >= $this->plan3['category3']) {

                    return false;

                }

            }

        }

        return true;

    }



    public function get_cart_weight($user_id) {

        $this->db->select('c.*, p.unit');

        $this->db->join($this->tables['ecom_products'].' p', 'c.product_id = p.id', 'left');

        $this->db->where(['c.user_id' => $user_id]);

        $query = $this->db->get($this->tables['ecom_carts']. ' c');

        $results = $query->result();

        $all_weight = new stdClass();

        $all_weight->weight = 0;

        $all_weight->weight1 = 0;

        $all_weight->weight2 = 0;

        $all_weight->weight3 = 0;

        if ($results) {

            foreach ($results as $key => $result) {

                $unit = intval($result->unit) * intval($result->quantity);

                $all_weight->weight  += $unit;

            }



            foreach ($results as $key => $result) {

                if ($result->l2c_id == '1') {

                    $unit = intval($result->unit) * intval($result->quantity);

                    $all_weight->weight1  += $unit;

                }

            }

            foreach ($results as $key => $result) {

                if ($result->l2c_id == '2') {

                    $unit = intval($result->unit) * intval($result->quantity);

                    $all_weight->weight2  += $unit;

                }

            }

            foreach ($results as $key => $result) {

                if ($result->l2c_id == '3') {

                    $unit = intval($result->unit) * intval($result->quantity);

                    $all_weight->weight3  += $unit;

                }

            }

        }

        return $all_weight;

    }



    public function check_weight_limit($user_id, $plan_id, $total_weight) {

        $weight = floatval($total_weight/1000);

        if ($plan_id == '1') {

            if ($weight < floatval($this->subscriptions['plan1'])) {

                return true;

            }

        } else if ($plan_id == '2') {

            if ($weight < floatval($this->subscriptions['plan2'])) {

                return true;

            }

        } else if ($plan_id == '3') {

            if ($weight < floatval($this->subscriptions['plan3'])) {

                return true;

            }

        } else if ($plan_id == '4') {

            if ($weight < floatval($this->subscriptions['plan4'])) {

                return true;

            }

        } else if ($plan_id == '5') {

            if ($weight < floatval($this->subscriptions['plan5'])) {

                return true;

            }

        } else if ($plan_id == '6') {

            if ($weight < floatval($this->subscriptions['plan6'])) {

                return true;

            }

        } else if ($plan_id == '7') {

            if ($weight < floatval($this->subscriptions['plan7'])) {

                return true;

            }

        } else if ($plan_id == '8') {

            if ($weight < floatval($this->subscriptions['plan8'])) {

                return true;

            }

        } else if ($plan_id == '9') {

            if ($weight < floatval($this->subscriptions['plan9'])) {

                return true;

            }

        }

        return false;

    }



    public function get_product_cart($product_id, $user_id) {

        $this->db->select('*');

        $this->db->where(['product_id' => $product_id, 'user_id' => $user_id]);

        $query = $this->db->get($this->tables['ecom_carts']);

        if ($query->num_rows() > 0) {

            return $query->row();

        }

        return FALSE;

    }



    public function get_all_products() {

        $this->db->select('*');

        $query = $this->db->get($this->tables['ecom_products']);

        if ($query->num_rows() > 0) {

            return $query->result();

        }

        return FALSE;

    }

    public function get_all_categories() {

        $this->db->select('*');

        $query = $this->db->get($this->tables['ecom_level1_category']);

        if ($query->num_rows() > 0) {

            return $query->result();

        }

        return FALSE;

    }

    

    public function get_product($product_id) {

        $this->db->select('*');

        $this->db->where(['id' => $product_id]);

        $query = $this->db->get($this->tables['ecom_products']);

        if ($query->num_rows() > 0) {

            $result = $query->row();

            return $result;

        }

        return FALSE;

    }



    public function get_cart_unit($product_id) {

        $this->db->select('*');

        $this->db->where(['product_id' => $product_id]);

        $query = $this->db->get($this->tables['ecom_carts']);

        if ($query->num_rows() > 0) {

            $result = $query->row();

            return $result->unit_id;

        }

        return FALSE;

    }



    

    public function add_to_cart($data) {

        return $this->db->insert($this->tables['ecom_carts'], $data);

    }



    public function insert_address($data) {

        return $this->db->insert($this->tables['ecom_addresses'], $data);

    }



    public function delete_cart($user_id) {

        return $this->db->delete($this->tables['ecom_carts'], ['user_id' => $user_id]);

    }



    public function insert_cart_orders($data) {

        $insert = $this->db->insert($this->tables['ecom_orders'], $data);

        if ($insert) {

            return $this->db->insert_id();

        }

        false;

    }

    

    public function update_order_status($order_id, $data) {

        return $this->db->update($this->tables['ecom_orders'], $data, ['id' => $order_id]);

    }

    

    public function insert_payment_details($data) {

        return $this->db->insert($this->tables['ecom_payments'], $data);

    }

    



    

    public function remove_cart($data) {

        return $this->db->delete($this->tables['ecom_carts'], $data);

    }



    public function get_user_details($user_id) {

        return $this->db->get_where($this->tables['users'], ['id' => $user_id])->row();

    }



    public function get_all_orders($user_id) {

        return $this->db->order_by('id',"desc")->get_where($this->tables['ecom_orders'], ['user_id' => $user_id])->result();

    }



    public function get_all_delivered_orders($user_id, $start_date) {

            $this->db->select('id');

            $this->db->where('user_id', $user_id);

            $this->db->where('order_datetime >=', $start_date);

            $this->db->where_in('delivered',[1,2]);

            $query = $this->db->get($this->tables['ecom_orders']);

            return $query->num_rows();

        // return $this->db->order_by('id',"desc")->get_where($this->tables['ecom_orders'], ['user_id' => $user_id, 'delivered' => 2])->result();

    }



    public function get_all_payments($user_id) {

        return $this->db->order_by('id',"desc")->get_where($this->tables['ecom_payments'], ['user_id' => $user_id])->result();

    }

    public function get_last_orders($user_id) {

        return $this->db->order_by('id',"desc")->get_where($this->tables['ecom_orders'], ['user_id' => $user_id])->row();

    }



    public function get_user_plan($user_id) {

        return $this->db->get_where($this->tables['user_plans'], ['user_id' => $user_id, 'status' => 1])->row();

    }



    public function get_plan_by_id($plan_id) {

        return $this->db->get_where($this->tables['user_plans'], ['id' => $plan_id])->row();

    }



    public function insert_user_plan($data) {

        return $this->db->insert($this->tables['user_plans'], $data);

    }



    public function get_order_by_id($order_id) {

        return $this->db->get_where($this->tables['ecom_orders'], ['id' => $order_id])->row();

    }

   

    public function update_plan_status($plan_id, $data) {

        return $this->db->update($this->tables['user_plans'], $data, ['id' => $plan_id]);

    }



    public function get_user_last_order($user_id) {

        return $this->db->order_by('id',"desc")->limit(1)->get_where($this->tables['ecom_orders'], ['user_id' => $user_id])->row();

    }



    public function get_subscription_details($plan_id) {

        return $this->db->get_where($this->tables['subscriptions'], ['id' => $plan_id])->row();

    }



    public function get_cart_category1($user_id) {

        $this->db->select('*');

        $this->db->where(['user_id' => $user_id, 'l2c_id' => 1]);

        $query = $this->db->get($this->tables['ecom_carts']);

        return $query->num_rows();

    }



    public function get_cart_category2($user_id) {

        $this->db->select('*');

        $this->db->where(['user_id' => $user_id, 'l2c_id' => 2]);

        $query = $this->db->get($this->tables['ecom_carts']);

        return $query->num_rows();

    }

    public function get_cart_category3($user_id) {

        $this->db->select('*');

        $this->db->where(['user_id' => $user_id, 'l2c_id' => 3]);

        $query = $this->db->get($this->tables['ecom_carts']);

        return $query->num_rows();

    }

    

    public function update_product($where, $data) {

        return $this->db->update($this->tables['ecom_carts'], $data, $where);

    }



    public function cancel_order($order_id) {

        return $this->db->update($this->tables['ecom_orders'], ['delivered' => 3], ['id' => $order_id]);

    }



    public function cancel_plan($plan_id) {

        return $this->db->update($this->tables['user_plans'], ['status' => 2], ['id' => $plan_id]);

    }



    public function resume_plan($plan_id) {

        return $this->db->update($this->tables['user_plans'], ['status' => 1], ['id' => $plan_id]);

    }



    

    public function pause_plan($order_id) {

        return $this->db->update($this->tables['user_plans'], ['status' => 3], ['id' => $order_id]);

    }



    public function pause_order($order_id) {

        return $this->db->update($this->tables['ecom_orders'], ['delivered' => 5], ['id' => $order_id]);

    }

    

    public function reschedule_order($order_id) {

        return $this->db->update($this->tables['ecom_orders'], ['delivered' => 4], ['id' => $order_id]);

    }



    public function get_all_product_cart($user_id) {

        $this->db->select('p.*, c.quantity');

        $this->db->join($this->tables['ecom_carts'].' c', 'p.id = c.product_id');

        $this->db->where(['c.user_id' => $user_id]);

        $query = $this->db->get($this->tables['ecom_products'].' p');

        if ($query->num_rows() > 0) {

            return $query->result();

        }

        return FALSE;

    }



    public function get_all_subscriptions($user_id) {

        $this->db->select('s.*, p.id as pid, p.status as p_status');

        $this->db->join($this->tables['user_plans'].' p', 's.id = p.plan_id');

        $this->db->where(['p.user_id' => $user_id]);

        $query = $this->db->get($this->tables['subscriptions'].' s');

        if ($query->num_rows() > 0) {

            return $query->result();

        }

        return FALSE;

    }



    public function cart_products($user_id, $product_id) {

        $this->db->select('quantity');

        $this->db->where(['user_id' => $user_id, 'product_id' => $product_id]);

        $query = $this->db->get($this->tables['ecom_carts']);

        if ($query->num_rows() > 0) {

            return $query->row();

        }

        return FALSE;

    }





    public function get_venue_count()

    {

        $this->db->select('id');

        $this->db->where_in('country_id',array(2,15,58));

        $query = $this->db->get($this->tables['enet_venues']);



        return $query->num_rows();

    }


     public function order_details($order_id) {
  
        $this->db->select('*');
        $this->db->where(['id' =>$order_id]);
        $query = $this->db->get($this->tables['ecom_orders']);
        if ($query->num_rows() > 0) {
            $res= $query->result();
            foreach ($res as $key => $value) {
                $this->db->select('*');
                $this->db->where(['id' =>$value->user_id]);
                $query_user = $this->db->get($this->tables['users']);
                $res_user= $query_user->result();
                if(!empty($res_user))
                {
                    $res[$key]->full_name=$res_user[0]->first_name;
                    $res[$key]->phone=$res_user[0]->phone;
                }else{
                    $res[$key]->full_name='';
                    $res[$key]->phone='';
                }  

                $this->db->select('address,land_mark,city,state,postcode,phone,email');
                $this->db->where(['user_id' =>$value->user_id]);
                $query_user_add = $this->db->get($this->tables['ecom_addresses']);
                $res_user_add= $query_user_add->result();
                if(!empty($res_user_add))
                {
                    $res[$key]->address=$res_user_add[0]->address;
                    $res[$key]->city=$res_user_add[0]->city;
                    $res[$key]->pincode=$res_user_add[0]->postcode;
                    $res[$key]->state=$res_user_add[0]->state;

                }else{
                    $res[$key]->full_name='';
                    $res[$key]->phone='';
                    $res[$key]->pincode='';
                    $res[$key]->state='';

                }   
            }

            return $res;
        }
        return FALSE;
    }   


    public function get_all_product($keyword) {
        $this->db->select('id,product_name');
        $this->db->where(['published' =>1, 'is_deleted' =>'0']);
        $this->db->like('product_name',$keyword);
        $query = $this->db->get($this->tables['ecom_products']);
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }   


}

