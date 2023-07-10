<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

  public function __construct() {
      parent::__construct();

      /* Load :: Common */
      $this->load->library('template');
      $this->load->model('seller/subscription_model');
  }

  public function index() {
    //echo "hello";  die;
    /* Title Page */
    //$this->page_title->push(lang('menu_users'));
    //$this->data['pagetitle'] = $this->page_title->show();
    $this->template->seller_render_page('seller/subscription/subscription');
  }


}
