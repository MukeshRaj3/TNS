<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function admin_render($content, $data = NULL) {
        if (!$content) {
            return NULL;
        } else {
            $this->template['header'] = $this->CI->load->view('admin/_templates/header', $data, TRUE);
            $this->template['main_header'] = $this->CI->load->view('admin/_templates/main_header', $data, TRUE);
            $this->template['main_sidebar'] = $this->CI->load->view('admin/_templates/main_sidebar', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['control_sidebar'] = $this->CI->load->view('admin/_templates/control_sidebar', $data, TRUE);
            $this->template['footer'] = $this->CI->load->view('admin/_templates/footer', $data, TRUE);

            return $this->CI->load->view('admin/_templates/template', $this->template);
        }
    }

    public function seller_render($content, $data = NULL) {
        if (!$content) {
            return NULL;
        } else {
           
             $this->template['header'] = $this->CI->load->view('seller/_templates/header', $data, TRUE);
            $this->template['main_header'] = $this->CI->load->view('seller/_templates/main_header', $data, TRUE);
            $this->template['main_footer'] = $this->CI->load->view('seller/_templates/main_footer', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer'] = $this->CI->load->view('seller/_templates/footer', $data, TRUE);

            return $this->CI->load->view('seller/_templates/template', $this->template);
        }
    }

    public function auth_render($content, $data = NULL) {
        if (!$content) {
            return NULL;
        } else {
            $this->template['header'] = $this->CI->load->view('auth/_templates/header', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer'] = $this->CI->load->view('auth/_templates/footer', $data, TRUE);

            return $this->CI->load->view('auth/_templates/template', $this->template);
        }
    }
    
    public function render_page($content, $data = NULL) {
        if (!$content) {
            return NULL;
        } else {
            $this->template['header'] = $this->CI->load->view('auth_original/_templates/header', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer'] = $this->CI->load->view('auth_original/_templates/footer', $data, TRUE);

            return $this->CI->load->view('auth_original/_templates/template', $this->template);
        }
    }
    
    public function public_render($content, $data = NULL) {
        if (!$content) {
            return NULL;
        } else {
            $this->template['header'] = $this->CI->load->view('public/_templates/header', $data, TRUE);
            $this->template['main_header'] = $this->CI->load->view('public/_templates/main_header', $data, TRUE);
            $this->template['main_footer'] = $this->CI->load->view('public/_templates/main_footer', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer'] = $this->CI->load->view('public/_templates/footer', $data, TRUE);

            return $this->CI->load->view('public/_templates/template', $this->template);
        }
    }

    public function seller_render_page($content, $data = NULL) {
        if (!$content) {
            return NULL;
        } else {
            $this->template['header'] = $this->CI->load->view('seller/seller_inside_templates/header', $data, TRUE);
            $this->template['main_header'] = $this->CI->load->view('seller/seller_inside_templates/sidebar', $data, TRUE);
            
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer'] = $this->CI->load->view('seller/seller_inside_templates/footer', $data, TRUE);

            return $this->CI->load->view('seller/seller_inside_templates/template', $this->template);
        }
    }

}
