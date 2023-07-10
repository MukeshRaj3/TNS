<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->tables = [
        	'cities' => 'cities',
        	'ecom_level1_category' => 'ecom_level1_category',
            'ecom_level2_category' => 'ecom_level2_category',
        	'banners' => 'ecom_bannerimages',
            'ecom_delivery_charges'=>'ecom_delivery_charges',
        	'users' => 'users'
        ];
        $this->limit = 20;
        $this->radius_value = getenv('RADIUS_VALUE'); /* For Miles 3959 , For KM 6371 */
        $this->radius_distance = getenv('RADIUS_RANGE');
    }

    public function get_all_banners() {
    	$this->db->select($this->tables['banners'].'.*');
        //$this->db->where($this->tables['banners'].'.is_active_banner', 1);
        //$this->db->order_by($this->tables['banners'].'.order_number', 'ASC');
    	$query = $this->db->get($this->tables['banners']);

    	if ($query->num_rows() > 0) {
             $banners = $query->result();
             foreach ($banners as $key => $value) {
                   $banners[$key]->bannerimg=base_url('images/slides/'.$value->bannerimg);
            }
            return $banners; 
        }

        return FALSE;
    }

    public function get_categories() {
        $this->db->select($this->tables['ecom_level1_category'].'.l1_category as name,image_file,id');
        $this->db->where($this->tables['ecom_level1_category'].'.active', 1);
        $this->db->where($this->tables['ecom_level1_category'].'.is_deleted',0);
        $query = $this->db->get($this->tables['ecom_level1_category']);
        if ($query->num_rows() > 0) {
            $categories = $query->result();
             foreach ($categories as $key => $value) {
               
                   $categories[$key]->image_file=base_url('uploads/categories/'.$value->image_file);
                
               
            }
            return $categories;
        }
        return false;
    }

  public function get_sub_categories($category_id) {
        $this->db->select($this->tables['ecom_level2_category'].'.l2_category as name,image_file,id');
        $this->db->where($this->tables['ecom_level2_category'].'.l1c_id',$category_id);
        $this->db->where($this->tables['ecom_level2_category'].'.active', 1);
        $this->db->where($this->tables['ecom_level2_category'].'.is_deleted',0);
        $query = $this->db->get($this->tables['ecom_level2_category']);
        if ($query->num_rows() > 0) {
            $sub_categories = $query->result();
            foreach ($sub_categories as $key => $value) {
                if(file_exists(base_url('uploads/subcategories/'.$value->image_file)))
                {
                   $sub_categories[$key]->image_file=base_url('uploads/subcategories/'.$value->image_file);
                }else{
                $sub_categories[$key]->image_file=base_url('uploads/images.png');
                }
              
               
            }
            return $sub_categories;
        }
        return false;
    }

  public function get_delivery_charges() {
        $this->db->select($this->tables['ecom_delivery_charges'].'.*');
        $this->db->where($this->tables['ecom_delivery_charges'].'.status','1');
        $query = $this->db->get($this->tables['ecom_delivery_charges']);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
}