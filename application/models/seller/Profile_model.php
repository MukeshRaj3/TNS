<?php



defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {

    var $order = array('ecom_sellers.id' => 'desc'); // default order

    public function __construct() {
        parent::__construct();
        $this->table = 'ecom_sellers';
        }

    public function create($data) {
        return $this->db->insert($this->table, $data);
    }

    public function profile_details($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

}