<?php



defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    var $order = array('ecom_products.id' => 'desc'); // default order

    public function __construct() {
        parent::__construct();
        $this->table = 'ecom_products';
        $this->table_product_images='ecom_product_images';
        $this->table_level1_category='ecom_level1_category';
        }

    public function insert($data) {
         $this->db->insert($this->table, $data);
          $insert_id = $this->db->insert_id();
          return  $insert_id;
    }

    public function img_insert($data) {
         $this->db->insert($this->table_product_images, $data);
          $insert_id = $this->db->insert_id();
          return  $insert_id;
    }

    public function product_details($id) {
        $res= $this->db->get_where($this->table, ['seller_id' => $id])->result_array();
        if(!empty($res))
        {
            foreach ($res as $key => $value) {

                 $res_pimage= $this->db->get_where($this->table_product_images, ['pid' => $value['id']])->result_array();
               if(!empty($res_pimage))
                 {
                   $res[$key]['product_image']=base_url('images/product/'.$res_pimage[0]['search_image']);
                 }else{
                    $res[$key]['product_image']='';
                 }  
                
            }
        }
        return $res;
    }

    public function get_category() {
        return $this->db->get_where($this->table_level1_category, ['is_deleted' =>'0','active' =>'1'])->result_array();
    }

    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
    public function file_upload($file_name,$upload_path)
   {
     
                $file = $file_name.time().rand(100, 999);
                $config = array(
                'upload_path'       => $upload_path,
                'allowed_types' => 'png|jpg|jpeg|mp4',
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