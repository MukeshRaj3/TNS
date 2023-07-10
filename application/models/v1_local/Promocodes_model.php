<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Promocodes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->tables = [
            'promocodes' => 'ecom_promocodes',
            'promocode_usage_history' => 'promocode_usage_history'
        ];
        
    }

    public function get_promo($user_id)
    {
    
                    $this->db->select('id, promocode, promocode_title, promocode_description, number_of_time_usage, promocode_type, discount, expiry_date, per_user');
                    $this->db->where('expiry_date >=', date('Y-m-d'));
                    $this->db->where('is_expired', 0);
                    $this->db->order_by('expiry_date','ASC');
                    $query = $this->db->get($this->tables['promocodes']);
                    if ($query->num_rows() > 0) {
                         return $query->result();
                    }else{
                         return false;
                    }
    }

    
    public function check_promocode($promocode, $restaurant_id, $user_id)
    {
        $this->db->select('*');
        $this->db->where('promocode', $promocode);
        $this->db->where('restaurant_id', $restaurant_id);
        $this->db->where('is_expired', 0);
        $this->db->where('expiry_date >= ', date('Y-m-d'));
        $query = $this->db->get($this->tables['promocodes']);
        
        if(!empty($query->row())){
            $result = $query->row();
            
            $this->db->select('COUNT(promocode_id) AS total_usage');
            $this->db->where('promocode_id', $result->promocode_id);
            $this->db->where('restaurant_id', $restaurant_id);
            $this->db->where('is_used', 1);
            $count_data = $this->db->get($this->tables['promocode_usage_history'])->row();
            
            if ($count_data->total_usage < $result->number_of_time_usage) {   
                return $result;
            } else {
                $this->db->update('promocodes', ['is_expired' => 1], ['promocode_id' => $result->promocode_id]);
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    public function get_promocode_usage_count( $number_of_time_usage, $promocode, $promocode_id, $user_id)
    {
        $this->db->select('COUNT(promocode_id) AS total_usage');
        $this->db->where('promocode_id', $promocode_id);
        $this->db->where('is_used', 1);
        $count_data = $this->db->get($this->tables['promocode_usage_history'])->row();
        
        if($count_data->total_usage < $number_of_time_usage){
            return array('status' => 1,'count' => $number_of_time_usage - $count_data->total_usage);
        }else{
            return array('status' => 0,'count' => 0);
        }
    }

    public function check_user_usage($promocode_id, $user_id)
    {
        $this->db->select('COUNT(promocode_id) AS total_usage');
        $this->db->where('promocode_id',$promocode_id);
        $this->db->where('user_id',$user_id);
        $this->db->where('is_used',1);
        $count_data = $this->db->get($this->tables['promocode_usage_history'])->row();
        
        return $count_data->total_usage;
    }

    public function apply_promocode($promocode,$promocode_id,$user_id, $restaurant_id)
    {
        $data = [
            'promocode'     => $promocode,
            'user_id'       => $user_id,
            'promocode_id'  => $promocode_id,
            'restaurant_id' => $restaurant_id
        ];
        $this->db->insert($this->tables['promocode_usage_history'], $data);
        return $this->db->insert_id();
    }
}