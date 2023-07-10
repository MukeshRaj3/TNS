<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Seller_model extends CI_Model {



    var $order = array('ecom_sellers.id' => 'desc'); // default order



    public function __construct() {

        parent::__construct();



        $this->table = 'ecom_sellers';

        }

    public function login($username,$otp) {

        /* If Required to filter near by user */

        $this->db->select($this->table.'.*');
        $this->db->where($this->table.'.mobile_no', $username);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $data =  $query->row();
            return $data;
        }else{
            return false;
        }
    }



    public function check_city($full_name) {

        return $this->db->get_where($this->table, ['full_name' => $full_name])->row();

    }



    public function create($data) {

        return $this->db->insert($this->table, $data);

    }



    public function city_details($id) {

        return $this->db->get_where($this->table, ['id' => $id])->row();

    }



    public function update($id, $data) {

        return $this->db->update($this->table, $data, ['id' => $id]);

    }



    public function delete($id) {

        return $this->db->delete($this->table, ['id' => $id]);

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

    public function file_upload($file_name,$upload_path)
   {
     
                $file = $file_name.time().rand(100, 999);
                $config = array(
                'upload_path'       => $upload_path,
                'allowed_types' => 'png|jpg|jpeg',
                'file_name'         => $file,
                'overwrite'         => FALSE,
                'remove_spaces'     => TRUE,
                'quality'           => '100%',
                 );
                $this->load->library('upload'); //upload library
                $this->upload->initialize($config);
                if($this->upload->do_upload($file_name)) {
                   $uploadData = $this->upload->data();
                    return $uploadData['file_name'];
                }else{
                    return false;
                }        
   }

}