<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';

$route['product'] = 'welcome/product';
$route['all-product'] = 'welcome/all_product';
$route['subcategories/(:any)'] = 'welcome/subcategories/$1';
$route['product-detail/(:any)'] = 'welcome/product_detail/$1';
$route['product-cart'] = 'welcome/product_cart';
$route['checkout'] = 'welcome/checkout';

$route['plan'] = 'welcome/plan';
$route['product-cart/(:any)'] = 'welcome/product_cart/$1';
$route['product-cart-upload'] = 'welcome/product_cart_upload';
// $route['product'] = 'welcome/product';
$route['product/(:any)'] = 'welcome/product/$1';
$route['new-product/(:any)'] = 'welcome/new_subscription/$1';
$route['checkout/(:any)'] = 'welcome/checkout/$1';
$route['product-detail'] = 'welcome/product_detail/$1';
$route['thank-you'] = 'welcome/thankyou';
$route['profile/(:any)'] = 'welcome/profile/$1';
$route['orders'] = 'welcome/orders';
$route['order-details/(:any)'] = 'welcome/order_details/$1';
$route['payments'] = 'welcome/payments';
$route['change-password'] = 'welcome/change_password';
$route['auction'] = 'welcome/auction';
$route['page1'] = 'welcome/page1';
$route['page2'] = 'welcome/page2';
$route['page3'] = 'welcome/page3';
$route['page4'] = 'welcome/page4';
$route['page5'] = 'welcome/page5';
$route['t-shirt-green'] = 'welcome/t_shirt_green';
$route['t-shirt-gray'] = 'welcome/t_shirt_gray';
$route['bottel'] = 'welcome/bottel';
$route['pen'] = 'welcome/pen';
$route['letter-head'] = 'welcome/letter_head';
$route['contact-us'] = 'welcome/contact_us';
$route['send-contact'] = 'welcome/send_contact';

$route['enquiry'] = 'welcome/enquiry';
$route['save-product-image'] = 'welcome/save_product_image';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*---------------Seller Section----------------------*/
$route['seller-dashboard'] = 'seller/seller/dashboard';

