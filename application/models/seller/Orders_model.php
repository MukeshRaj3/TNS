<?php



defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {

    var $order = array('ecom_orders.id' => 'desc'); // default order

    public function __construct() {
        parent::__construct();
        $this->table = 'ecom_orders';
        $this->table_product_images='ecom_product_images';
        $this->table_level1_category='ecom_level1_category';
        $this->table_level2_category='ecom_level2_category';
        $this->table_order_items='ecom_order_items';
        $this->table_ecom_addresses='ecom_addresses';
        
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

    public function order_details($id) {
  
        $where=array('id'=>$id);
        $res= $this->db->get_where($this->table,$where)->result_array();
        //echo $this->db->last_query(); die;
        if(!empty($res))
        {
            foreach ($res as $key => $value) {
                   $res[$key]['order_details']=unserialize($value['order_item_array']);
                   //echo "<pre>";
                 //print_r($res[$key]['order_details']); die;
                foreach ($res[$key]['order_details'] as $key_p => $value_p) {
                   /*----------------------Product Image Get----------------------*/ 
                   $res_pimage= $this->db->get_where($this->table_product_images, ['pid' => $value_p->id])->result_array();
                  if(!empty($res_pimage))
                   {
                   $res[$key]['order_details'][$key_p]->product_image=base_url('images/product/'.$res_pimage[0]['search_image']);
                   }else{
                    $res[$key]['order_details'][$key_p]->product_image='';
                   }

                   /*----------------------Product Category Get----------------------*/ 
                   $res_cat1= $this->db->get_where($this->table_level1_category, ['id' => $value_p->id])->result_array();
                  if(!empty($res_cat1))
                   {
                   $res[$key]['order_details'][$key_p]->cat_name=$res_cat1[0]['l1_category'];
                   }else{
                    $res[$key]['order_details'][$key_p]->cat_name='';
                   }

                   /*----------------------Product Sub Category Get----------------------*/ 
                   $res_cat2= $this->db->get_where($this->table_level2_category, ['id' => $value_p->id])->result_array();
                  if(!empty($res_cat2))
                   {
                   $res[$key]['order_details'][$key_p]->cat_sub_name=$res_cat2[0]['l2_category'];
                   }else{
                    $res[$key]['order_details'][$key_p]->cat_sub_name='';
                   }

                   /*----------------------Product Price Get----------------------*/ 
                   $res_pirce= $this->db->get_where($this->table_order_items, ['pid' => $value_p->id,'order_id' => $id])->result_array();
                  if(!empty($res_pirce))
                   {
                   $res[$key]['order_details'][$key_p]->unit_price=$res_pirce[0]['unit_price'];
                   $res[$key]['order_details'][$key_p]->product_qty=$res_pirce[0]['quantity'];

                   }else{
                    $res[$key]['order_details'][$key_p]->unit_price=0;
                   $res[$key]['order_details'][$key_p]->product_qty=0;

                   }

                }

                $res_address= $this->db->get_where($this->table_ecom_addresses, ['id' => $value['address_id'],'user_id'=>$value['user_id']])->result_array();
                //print_r($res_address); die;
               if(!empty($res_address))
                 {
                   $res[$key]['customer_address']=$res_address[0];
                 }else{
                    $res[$key]['customer_address']=array();
                 } 
                
            }
        }
       // echo "<pre>";
       // print_r($res); die;
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