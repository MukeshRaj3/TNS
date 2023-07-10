<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';

$route['all-product'] = 'welcome/all_product';
$route['subcategories'] = 'welcome/subcategories';
$route['product-detail'] = 'welcome/product_detail';
$route['product-cart'] = 'welcome/product_cart';
$route['checkout'] = 'welcome/checkout';
$route['plan'] = 'welcome/plan';

$route['product-cart/(:any)'] = 'welcome/product_cart/$1';
$route['product/(:any)'] = 'welcome/product/$1';
$route['subcategories/(:any)'] = 'welcome/subcategories/$1';
$route['new-product/(:any)'] = 'welcome/new_subscription/$1';
$route['checkout/(:any)'] = 'welcome/checkout/$1';

$route['product-detail/(:any)'] = 'welcome/product_detail/$1';
$route['thank-you'] = 'welcome/thankyou';
$route['profile'] = 'welcome/profile';
$route['auction'] = 'welcome/auction';
$route['enquiry'] = 'welcome/enquiry';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
