<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Seller_Controller {

  public function __construct() {
      parent::__construct();

      /* Load :: Common */
      $this->load->model('seller/users_model');
  }

  public function index() {
    /* Title Page */
    $this->page_title->push(lang('menu_users'));
    $this->data['pagetitle'] = $this->page_title->show();
    
    /* Load Template */
    $this->template->seller_render('seller/users/index', $this->data);
  }

  public function ajax_list() {
    
    $list = $this->users_model->get_datatables();
    $data = array();
    //$no = $_POST['start'];
    foreach ($list as $key => $user) {
        $user->last_login = is_null($user->last_login) ? "-" : date('d-m-Y H:i', $user->last_login);
        $user->created_on = date('d-m-Y H:i', $user->created_on);
        //$no++;
        $row = array();
        $row[] = $user->first_name;
        $row[] = $user->email;
        $row[] = $user->phone;
        $row[] = $user->last_login;
        $row[] = $user->created_on;
        $data[] = $row;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->users_model->count_all(),
        "recordsFiltered" => $this->users_model->count_filtered(),
        "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
}
