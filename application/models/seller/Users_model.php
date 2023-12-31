<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    var $order = array('users.id' => 'desc'); // default order

    public function __construct() {
        parent::__construct();

        $this->table = 'users';
        
        $this->column_order = array('first_name', 'email', 'phone', 'last_login','created_on'); //set column field database for datatable orderable
        
        $this->column_search = array('first_name', 'email', 'phone', 'last_login','created_on'); //set column field database for datatable searchable 
    }

    private function _get_datatables_query() {
        //add custom filter here
        $this->db->select($this->table . '.*');
        if ($this->input->post('Name')) {
            $this->db->like($this->table . '.first_name', $this->input->post('Name'));
        }
        if ($this->input->post('Email')) {
            $this->db->like($this->table . '.email', $this->input->post('Email'));
        }
        if ($this->input->post('Phone')) {
            $this->db->like($this->table . '.phone', $this->input->post('Phone'));
        }

        $this->db->from($this->table);
        $this->db->where($this->table . '.role_id', 2);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables() {

        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_all() {
        $this->db->from('users');
        $this->db->where($this->table . '.role_id', 2);
        return $this->db->count_all_results();
    }

    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
}