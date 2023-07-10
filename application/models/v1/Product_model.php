<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->tables = [
        	'cities' => 'cities',
        	'ecom_level1_category' => 'ecom_level1_category',
            'ecom_level2_category' => 'ecom_level2_category',
        	'ecom_products' => 'ecom_products',
            'ecom_product_units' => 'ecom_product_units',
            'ecom_product_images' => 'ecom_product_images',
            'ecom_product_ratings' => 'ecom_product_ratings',
            'ecom_sellers' => 'ecom_sellers',
            'ecom_product_wish_list' => 'ecom_product_wish_list',
        	'users' => 'users'
        ];
    }

    
    public function get_product($where) {
        $this->db->select($this->tables['ecom_products'].'.id,product_name,short_description,long_description,product_highlights,discount_percent,price,stock,min_order_qty,returnable,available,variants,'.$this->tables['ecom_product_units'].'.unit');

        $this->db->join($this->tables['ecom_product_units'], $this->tables['ecom_products'].'.unit_id = '.$this->tables['ecom_product_units'].'.id', 'LEFT');
        if(!empty($where['category_id']))
        {
        $this->db->where($this->tables['ecom_products'].'.l1c_id',$where['category_id']);
        }
        if(!empty($where['sub_category_id']))
        {
            $this->db->where($this->tables['ecom_products'].'.l2c_id',$where['sub_category_id']);
        }
        if(!empty($where['product_id']))
        {
            $this->db->where($this->tables['ecom_products'].'.id',$where['product_id']);
        }
        //$this->db->where($this->tables['ecom_products'].'.active', 1);
        $this->db->where($this->tables['ecom_products'].'.is_deleted',0);
         if(!empty($where['keyword']))
        {
            $this->db->like('product_name',$where['keyword']);
        }
        $query = $this->db->get($this->tables['ecom_products']);
        if ($query->num_rows() > 0) {
            $products = $query->result();
             foreach ($products as $key => $value) {
                  if(empty($where['keyword']))
                  {
                /*------------------Get Product Image----------------*/
                $product_image_url=base_url('uploads/products/');
                $res_image=$this->get_sql_query($this->tables['ecom_product_images'],'IF(search_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",search_image)) AS search_image,IF(catalog_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",catalog_image)) AS catalog_image,IF(cart_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",cart_image)) AS cart_image,',array('pid'=>$value->id));
                $products[$key]->product_image=$res_image;
                /*------------------Get Product Ratings----------------*/ 
                $res_rating=$this->get_sql_query($this->tables['ecom_product_ratings'],'count(*) as count_row,sum(rating) as total_rating',array('product_id'=>$value->id));
               if(!empty($res_rating[0]->total_rating) && !empty($res_rating[0]->count_row))
               {
                $p_rating=$res_rating[0]->total_rating / $res_rating[0]->count_row; 
                $products[$key]->product_ratings=$p_rating;
               }else{
                 $products[$key]->product_ratings='';
               }
               /*---------------User Wise Product Rating-------------------*/
                if(!empty($where['product_id']))
                 {
                    $this->db->select($this->tables['ecom_product_ratings'].'.rating,remark,'.$this->tables['users'].'.username,first_name');
                    $this->db->join($this->tables['users'], $this->tables['users'].'.id = '.$this->tables['ecom_product_ratings'].'.user_id', 'LEFT');
                    $this->db->where($this->tables['ecom_product_ratings'].'.product_id',$value->id);
                    $query = $this->db->get($this->tables['ecom_product_ratings']);
                    if ($query->num_rows() > 0) {
                        $res_user_wise_review_ratings= $query->result();
                        $products[$key]->user_wise_review_ratings=$res_user_wise_review_ratings;
                     }else{
                        $products[$key]->user_wise_review_ratings=array();
                     }

                }
                 
              }

              
            }

            return $products;
        }
        return false;
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

    public function products_review_rating_send($data) {
        $res = $this->db->get_where($this->tables['ecom_product_ratings'],['user_id' => $data['user_id'],'product_id'=>$data['product_id']])->row();
        if(is_null($res)) {
        return $this->db->insert($this->tables['ecom_product_ratings'],$data);
        }else{
            return false;
        } 
    }

public function products_add_wish_list($data) {

        $res = $this->db->get_where($this->tables['ecom_product_wish_list'],['user_id' => $data['user_id'],'product_id'=>$data['product_id']])->row();

        if(is_null($res)) {

        return $this->db->insert($this->tables['ecom_product_wish_list'],$data);
        }else{
            return false;
        } 
    }

 public function product_wish_get($where) {
        $this->db->select($this->tables['ecom_products'].'.id,product_name,short_description,long_description,product_highlights,discount_percent,price,stock,min_order_qty,returnable,available,variants,'.$this->tables['ecom_product_units'].'.unit');
        $this->db->join($this->tables['ecom_products'], $this->tables['ecom_product_wish_list'].'.product_id = '.$this->tables['ecom_products'].'.id', 'INNER');
        $this->db->join($this->tables['ecom_product_units'], $this->tables['ecom_products'].'.unit_id = '.$this->tables['ecom_product_units'].'.id', 'LEFT');
    
        $this->db->where($this->tables['ecom_product_wish_list'].'.user_id',$where['user_id']);
    
        //$this->db->where($this->tables['ecom_products'].'.active', 1);
        $this->db->where($this->tables['ecom_products'].'.is_deleted',0);
        $query = $this->db->get($this->tables['ecom_product_wish_list']);
        if ($query->num_rows() > 0) {
            $products = $query->result();
             foreach ($products as $key => $value) {
             
                /*------------------Get Product Image----------------*/
                $product_image_url=base_url('uploads/products/');
                $res_image=$this->get_sql_query($this->tables['ecom_product_images'],'IF(search_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",search_image)) AS search_image,IF(catalog_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",catalog_image)) AS catalog_image,IF(cart_image IS NULL,CONCAT("'.$product_image_url.'","images.png"),CONCAT("'.$product_image_url.'",cart_image)) AS cart_image,',array('pid'=>$value->id));
                $products[$key]->product_image=$res_image;
                /*------------------Get Product Ratings----------------*/ 
                $res_rating=$this->get_sql_query($this->tables['ecom_product_ratings'],'count(*) as count_row,sum(rating) as total_rating',array('product_id'=>$value->id));
               if(!empty($res_rating[0]->total_rating) && !empty($res_rating[0]->count_row))
               {
                $p_rating=$res_rating[0]->total_rating / $res_rating[0]->count_row; 
                $products[$key]->product_ratings=$p_rating;
               }else{
                 $products[$key]->product_ratings='';
               }
            }

            return $products;
        }
        return false;
    }

}