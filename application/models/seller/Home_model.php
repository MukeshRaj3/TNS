<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->tables = [
			'sellers' => 'sellers',
			'company_types' => 'company_types',
			'tax_details' => 'tax_details'
		];

    }

	public function profile($id) {
        return $this->db->get_where($this->tables['sellers'], ['id' => $id])->row();
    }

	public function company_types() {
        return $this->db->get_where($this->tables['company_types'], ['active' => 1])->result();
    }	

	public function tax_details($id) {
        return $this->db->get_where($this->tables['tax_details'], ['seller_id' => $id])->row();
    }
	
    public function update_profile($id, $insert, $tax_data) {
        $update = $this->db->update($this->tables['sellers'], $insert, ['id' => $id]);
        if ($update) {
            return $this->db->update($this->tables['tax_details'], $tax_data, ['seller_id' => $id]);
        }
        return false;
    }

    public function business_offer($id) {
        return $this->db->get_where($this->table_business_offers, ['business_id' => $id, 'is_deleted' => 0]);
    }

    public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    public function offer_delete($offer_id) {
        return $this->db->update($this->table_business_offers, ['is_deleted' => 1], ['id' => $offer_id]);
    }

    public function change_offer_status($offer_id, $status) {
        $this->db->update($this->table_business_offers, ['active' => $status], ['id' => $offer_id]);
        echo json_encode($status);
    }

    public function business_approve_reject($id, $status)
    {
        if ($status == 1) {
            return $this->db->update($this->table, ['business_status' => $status], ['id' => $id]);
        } else {
            $this->db->select($this->table_business_images.'.*');
            $this->db->where($this->table_business_images.'.business_id', $id);
            $query = $this->db->get($this->table_business_images);

            if ($query->num_rows() > 0 ) {
                $images = $query->result();

                foreach ($images as $key => $row) {
                    if (!empty($row->image)) {
                        unlink($row->image);
                    }
                }
                /* Delete all business images */
                $this->db->delete($this->table_business_images, ['business_id' => $id]);
            }
            $this->db->delete($this->table_business_timing, ['business_id' => $id]);
            /* Delete all business offer */
            $this->db->delete($this->table_business_offers, ['business_id' => $id]);
            /* Delete all business offer */
            $this->db->delete($this->table_business_ratings, ['business_id' => $id]);


            $this->db->select($this->table.'.*');
            $this->db->where($this->table.'.id', $id);
            $query1 = $this->db->get($this->table);

            if ($query1->num_rows() > 0) {
                $business = $query1->row();
                if (!empty($business->menu_image)) {
                    unlink($business->menu_image);
                }

                return $this->db->delete($this->table, ['id' => $id]);
            } else {
                return false;
            }
        }
    }

    public function business_deleted($id)
    {
        if (!empty($id)) {
            $this->db->select($this->table_business_images.'.*');
            $this->db->where($this->table_business_images.'.business_id', $id);
            $query = $this->db->get($this->table_business_images);

            if ($query->num_rows() > 0 ) {
                $images = $query->result();

                foreach ($images as $key => $row) {
                    if (!empty($row->image)) {
                        unlink($row->image);
                    }
                }
                /* Delete all business images */
                $this->db->delete($this->table_business_images, ['business_id' => $id]);
            }

            /* Delete all business timing */
            $this->db->delete($this->table_business_timing, ['business_id' => $id]);
            /* Delete all business offer */
            $this->db->delete($this->table_business_offers, ['business_id' => $id]);
            /* Delete all business offer */
            $this->db->delete($this->table_business_ratings, ['business_id' => $id]);


            $this->db->select($this->table.'.*');
            $this->db->where($this->table.'.id', $id);
            $query1 = $this->db->get($this->table);

            if ($query1->num_rows() > 0) {
                $business = $query1->row();
                if (!empty($business->menu_image)) {
                    unlink($business->menu_image);
                }
            return $this->db->delete($this->table, ['id' => $id]);
            } else {
                return false;
            }
        }else {
            return FALSE;
        }
    }

   
    public function fetch_business($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function fetch_business_type($type) {
        return $this->db->get_where($this->table_business_type, ['bt_id' => $type])->row();   
    }

    public function business_types() {
        $query = $this->db->get_where($this->table_business_type, ['business_type_active' => 1]);
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }

    public function update_business($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }



    public function fetch_business_type_name($type) {
        $query = $this->db->get_where($this->table_business_type, ['bt_id' => $type])->row();
        if (!is_null($query)) {
            return $query->business_name;
        }
    }

}
