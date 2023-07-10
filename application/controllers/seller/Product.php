<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

  public function __construct() {
      parent::__construct();

      /* Load :: Common */
      $this->load->library('template');
      $this->load->model('seller/product_model');
  }

  public function index() {
    //echo "hello";  die;
    /* Title Page */
    $this->data['categories'] = $this->product_model->get_category($this->session->userdata('user_id'));
    $this->data['list'] = $this->product_model->product_details($this->session->userdata('user_id'));

    //echo $this->db->last_query();
    //echo "<pre>"; 
    //print_r($this->data['categories']); die;
    $this->template->seller_render_page('seller/product/list',$this->data);
  }

  public function add_product() {
       /* Validate form input */
            $validation = [
                [
                    'field' => 'product_name',
                    'label' => 'product_name',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'short_description',
                    'label' => 'short_description',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please select %s.']
                ],
                [
                    'field' => 'price',
                    'label' => 'price',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'mrp',
                    'label' => 'mrp',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'stock',
                    'label' => 'stock',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter %s.']
                ],
                [
                    'field' => 'l1c_id',
                    'label' => 'category',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please select %s.']
                ]
                
            ];

            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == true) {    
                //echo "<pre>";        
                // print_r($this->input->post());exit;
                $additional_data = ['product_name'=>$this->input->post('product_name'),
                'l1c_id'=>$this->input->post('l1c_id'),
                'l2c_id'=>$this->input->post('l2c_id'),
                'stock'=>$this->input->post('stock'),
                'quantity'=>$this->input->post('quantity'),
                'mrp'=>$this->input->post('mrp'),
                'price'=>$this->input->post('price'),
                'discount_percent'=>$this->input->post('discount_percent'),
                'purchase_price'=>$this->input->post('purchase_price'),
                'unit_id'=>$this->input->post('unit_id'),
                'hsn_code'=>$this->input->post('hsn_code'),
                'applicable_tax'=>$this->input->post('applicable_tax'),
                'price_for_seller'=>$this->input->post('price_for_seller'),
                'applicable_tax'=>$this->input->post('applicable_tax'),
                'short_description'=>$this->input->post('short_description'),
                'seller_id'=>$this->session->userdata('user_id')
              ];

                if(!empty(($_FILES['video']['name'])))
                     {
                       $product_video_path='./image/product/';
                       $new_file_name=$this->product_model->file_upload('video',$product_video_path);
                       $additional_data['video'] = 'image/product/'.$new_file_name;

                     }
                 //echo "<pre>";
                 //print_r($additional_data);exit;

                /* Register new business  */
                $insert_id = $this->product_model->insert($additional_data);
                if ($insert_id) {
                        /*-----------------profile_pic----------------------*/  
                   if(!empty(($_FILES['image']['name'])))
                     {
                       $product_img_path='./image/product/';
                       $new_file_name=$this->product_model->file_upload('pimg',$profile_pic_path);
                       $product_image = $new_file_name;
                       $this->product_model->img_insert(array('search_image'=>$product_image,'cart_image'=>$product_image,'catalog_image'=>$product_image,'pid'=>$insert_id));
                     }
                $this->session->set_flashdata('message', ['1','Product added successfully.']);
                            redirect('seller/product', 'refresh');
                } else {
                    $this->session->set_flashdata('message', ['0','Product added failed.']);
                    redirect('seller/product/add_product', 'refresh');
                }
            } else {
                $this->template->seller_render_page('seller/product/add_product');
            }
		
  }

  public function delete() {
      $delete = $this->product_model->delete($this->input->post('city_id'));
      if ($delete) {
        $response = [
          'status' => 1,
          'message' => 'city deleted successfully'
        ];
      } else {
        $response = [
          'status' => 0,
          'message' => 'unable to delete city'
        ];
      }
      echo json_encode($response);
  }
}
