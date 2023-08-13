<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Razorpay\Api\Api;

class Welcome extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		/* Load :: Model */
		$this->load->model('public/home_model');
		$this->load->library('encryption');
		$categories = $this->home_model->get_categories();
		if ($categories) {
			foreach ($categories as $key => $value) {
				$categories[$key]->subcategories = $this->home_model->get_subcategories($value->id);
			}
		}
		$this->data['categories'] = $categories;
		$this->data['products'] = $this->home_model->all_products();
		// $this->data['cart_count'] = $this->home_model->cart_count($this->session->userdata('user_id'));
	}

	public function index()
	{
		$products = $this->home_model->all_products();
		if (!empty($products)) {
			foreach ($products as $key => $value) {
				$products[$key]->image = $this->home_model->get_product_image($value->id);
			}
		}
		$this->data['products'] = $products;
		$this->template->public_render('public/web/index', $this->data);
	}

	public function subcategories($l1c_id)
	{
		$category_id = base64_decode(urldecode($l1c_id));
		$this->data['subcategories'] = $this->home_model->get_subcategories($category_id);
		$this->template->public_render('public/web/subcategories', $this->data);
	}

	public function all_product($id = null)
	{
		$products = $this->home_model->all_products();
		if (!empty($products)) {
			foreach ($products as $key => $value) {
				$products[$key]->image = $this->home_model->get_product_image($value->id);
			}
		}
		$this->data['products'] = $products;
		$this->template->public_render('public/web/all_product', $this->data);
	}

	public function product($id = null)
	{
		$subcategory_id = base64_decode(urldecode($id));
		$products = $this->home_model->get_products($subcategory_id);

		if (!empty($products)) {
			foreach ($products as $key => $value) {
				$products[$key]->image = $this->home_model->get_product_image($value->id);
			}
		}
		$this->data['products'] = $products;
		$this->template->public_render('public/web/product', $this->data);
	}
	
	public function product_detail($id)
	{
		$product_id = base64_decode(urldecode($id));
		$product = $this->home_model->get_product_details($product_id);
		if (!empty($product)) {
			$product->images = $this->home_model->get_all_product_images($product->id);
			// $product->bunches = $this->home_model->get_product_bunches($product->id);
		}
		$this->data['product'] = $product;
		$this->template->public_render('public/web/product_detail', $this->data);
	}
	public function show_cart_products()
	{
		$carts = $this->input->post('cart_id');
		if (!empty($carts)) {
			$html = '';
			$i = 0;
			foreach ($carts as $key => $value) {
				$product_id = explode('_', $value)[0];
				$varient_id = explode('_', $value)[1];
				$bunch_id = explode('_', $value)[2];
				$products[$key] = $this->home_model->get_cart_products($product_id);
				$image = $this->home_model->get_product_image($product_id);
				// print_r($image);
				// if ($bunch_id != '0') {
				// 	$products[$key]->bunch_data = $this->home_model->get_cart_bunch($bunch_id);
				// 	// print_r($products[$key]->bunch_data->id);exit;
				// }
				$html .= '<tr class="cart_item" id="listId' . $i . '">
				<td class="product-thumbnail">
					<a href="product-layout1.html">
						<img class="img-fluid" src="' . base_url() . 'uploads/products/' . $image->search_image . '" alt="product-img">
					</a>
				</td>
				<td class="product-name text-left" data-title="Product">
					<a href="product-layout1.html">' . $products[$key]->product_name . '</a>
					<span>' . $products[$key]->short_description . '</span>
				</td>';
				// if ($bunch_id != '0') {
				// 	$html .= '
				// 	<td class="product-name" data-title="Product">
				// 		<span class="badge bg-warning text-dark">' . $products[$key]->bunch_data->value . '</span>
				// 	</td>
				// 	<td class="product-price" data-title="Price">
				// 		<span class="Price-amount">
				// 			<span class="Price-currencySymbol">₹</span>' . $products[$key]->bunch_data->price . '
				// 		</span>
				// 	</td>';
				// } else {
					$html .= '
					<td class="product-price " data-title="Price">
						<span class="Price-amount ">
							₹' . $products[$key]->price . '
						</span>
					</td>';
				// }
				$html .= '<td class="product-quantity quantity_add' . $i . '">
				</td>
				<td class="product-subtotal" data-title="Total">
					<span class="Price-amount product_price' . $i . '">
					</span>
				</td>';
				if ($bunch_id != '0') {
					$html .= '<td class="product-remove">
						<a href="javascript:void(0)" class="remove" onclick="removeCart(' . $products[$key]->id . ', 0, ' . $products[$key]->bunch_data->id . ', ' . $i . ')">×</a>
					</td></tr>';
				} else {
					$html .= '<td class="product-remove">
					<a href="javascript:void(0)" class="remove" onclick="removeCart(' . $products[$key]->id . ', 0, 0, ' . $i . ')">×</a>
					</td></tr>';
				}
				$i++;
			}
			$response = [
				'status' => 1,
				'products' => $products,
				'html' => $html,
			];
		} else {
			$response = [
				'status' => 0
			];
		}
		echo json_encode($response);
	}

	public function show_checkout_products()
	{
		$carts = $this->input->post('cart_id');
		if (!empty($carts)) {
			$html = '';
			$i = 0;
			foreach ($carts as $key => $value) {
				$product_id = explode('_', $value)[0];
				$varient_id = explode('_', $value)[1];
				$bunch_id = explode('_', $value)[2];
				$products[$key] = $this->home_model->get_cart_products($product_id);
				if ($bunch_id != '0') {
					$products[$key]->bunch_data = $this->home_model->get_cart_bunch($bunch_id);
					// print_r($products[$key]->bunch_data->id);exit;
					$html .= '
					<tr class="cart_item">
						<td class="product-name text-left">' . $products[$key]->product_name . ' (' . $products[$key]->bunch_data->value . ') &nbsp;
						×<strong class="product-quantity"> 2</strong>
						</td>
						<td class="product-total ">
							<span class="Price-amount">
								<span class="Price-currencySymbol product_price' . $key . '"></span>
							</span>
						</td>
					</tr>
					';
				} else {
					$html .= '
					<tr class="cart_item">
						<td class="product-name text-left">' . $products[$key]->product_name . ' &nbsp;
						× &nbsp;<strong class="product-quantity qty'.$key.'"> </strong>
						</td>
						<td class="product-total ">
							<span class="Price-amount">
								<span class="Price-currencySymbol product_price' . $key . '"></span>
							</span>
						</td>
					</tr>';
				}


				$i++;
			}
			$response = [
				'status' => 1,
				'products' => $products,
				'html' => $html,
				'delivery_charge' => $this->config->item('delivery_charge')
			];
		} else {
			$response = [
				'status' => 0
			];
		}
		echo json_encode($response);
	}
	public function plan()
	{
		$this->data['plan'] = $this->home_model->get_user_plan($this->session->userdata('user_id'));
		//$this->data['subscriptions'] = $this->home_model->all_subscriptions();
		$this->data['cart_count'] = $this->home_model->cart_count($this->session->userdata('user_id'));
		// $this->data['contact_us_section'] = $this->load->view('public/contact_us_section', $this->data, TRUE);
		$this->template->public_render('public/web/plan', $this->data);
	}
	public function thankyou()
	{
		$this->data['order'] = $this->home_model->get_last_orders($this->session->userdata('user_id'));
		$this->template->public_render('public/web/thankyou', $this->data);
	}
	public function profile()
	{
		$this->data['orders'] = $this->home_model->get_all_orders($this->session->userdata('user_id'));
		$this->data['payments'] = $this->home_model->get_all_payments($this->session->userdata('user_id'));
		//$this->data['subscriptions'] = $this->home_model->get_all_subscriptions($this->session->userdata('user_id'));
		$this->template->public_render('public/web/profile', $this->data);
	}

	public function orders()
	{
		$this->data['orders'] = $this->home_model->get_all_orders($this->session->userdata('user_id'));
		//echo $this->db->last_query();
		//print_r($this->data['orders']); die;
		$this->template->public_render('public/web/orders', $this->data);
	}
	public function payments()
	{
		$this->data['payments'] = $this->home_model->get_all_payments($this->session->userdata('user_id'));
		//echo $this->db->last_query();

		$this->template->public_render('public/web/payments', $this->data);
	}
	public function order_processing()
	{
		$this->data['orders'] = $this->home_model->get_last_orders($this->session->userdata('user_id'));
		$this->template->public_render('public/web/order_processing', $this->data);
	}

	public function cancel_plan($plan_id)
	{
		$data = $this->home_model->get_plan_by_id($plan_id);
		if ($data) {
			$plan = $this->home_model->cancel_plan($plan_id);
			if ($plan) {
				$this->session->set_flashdata('message', [1, 'Successfully Cancel Subscription']);
				redirect('welcome/profile#profile_view', 'refresh');
			} else {
				$this->session->set_flashdata('message', [0, 'Unable to cancel Subscription']);
				redirect('welcome/profile#profile_view', 'refresh');
			}
		} else {
			$this->session->set_flashdata('message', [0, 'Subscription Not Found']);
			redirect('welcome/profile#profile_view', 'refresh');
		}
	}

	public function resume_plan($plan_id)
	{
		$data = $this->home_model->get_plan_by_id($plan_id);
		if ($data) {
			$plan = $this->home_model->resume_plan($plan_id);
			if ($plan) {
				$this->session->set_flashdata('message', [1, 'Successfully Resume Subscription']);
				redirect('welcome/profile#profile_view', 'refresh');
			} else {
				$this->session->set_flashdata('message', [0, 'Unable to Resume Subscription']);
				redirect('welcome/profile#profile_view', 'refresh');
			}
		} else {
			$this->session->set_flashdata('message', [0, 'Subscription Not Found']);
			redirect('welcome/profile#profile_view', 'refresh');
		}
	}
	public function pause_plan($plan_id)
	{
		$data = $this->home_model->get_plan_by_id($plan_id);
		if ($data) {
			$plan = $this->home_model->pause_plan($plan_id);
			if ($plan) {
				$this->session->set_flashdata('message', [1, 'Successfully Pause Subscription']);
				redirect('welcome/profile#profile_view', 'refresh');
			} else {
				$this->session->set_flashdata('message', [0, 'Unable to pause Subscription']);
				redirect('welcome/profile#profile_view', 'refresh');
			}
		} else {
			$this->session->set_flashdata('message', [0, 'Subscription Not Found']);
			redirect('welcome/profile#profile_view', 'refresh');
		}
	}

	public function cancel_order($order_id)
	{
		$today_date = date('Y-m-d');
		$data = $this->home_model->get_order_by_id($order_id);
		if ($data) {
			if (date('Y-m-d', strtotime($data->order_datetime)) == $today_date) {
				$order = $this->home_model->cancel_order($order_id);
				if ($order) {
					$this->session->set_flashdata('message', [1, 'Successfully Cancel Order']);
					redirect('welcome/profile', 'refresh');
				} else {
					$this->session->set_flashdata('message', [0, 'Unable to cancel order']);
					redirect('welcome/profile', 'refresh');
				}
			} else {
				$this->session->set_flashdata('message', [0, 'Order cannot be cancel']);
				redirect('welcome/profile', 'refresh');
			}
		} else {
			$this->session->set_flashdata('message', [0, 'Order Not Found']);
			redirect('welcome/profile', 'refresh');
		}
	}
	public function pause_order($order_id)
	{
		$order = $this->home_model->pause_order($order_id);
		if ($order) {
			$this->session->set_flashdata('message', [1, 'Successfully Pause Order']);
			redirect('welcome/profile', 'refresh');
		} else {
			$this->session->set_flashdata('message', [0, 'Unable to pause order']);
			redirect('welcome/profile', 'refresh');
		}
	}

	public function reschedule_order($order_id)
	{
		$this->data['order'] = $this->home_model->get_order_by_id($order_id);
		$this->template->public_render('public/web/reschedule', $this->data);
	}

	public function new_subscription($plan_id)
	{
		$this->home_model->delete_cart($this->session->userdata('user_id'));
		redirect('product/' . $plan_id, 'refresh');
	}

	// public function product($id = null) {
	// 	// $plan_id=base64_decode( urldecode( $id));
	// 	// $plan = $this->home_model->get_user_plan($this->session->userdata('user_id'));
	// 	// if ($plan) {
	// 	// 	$plan_id = $plan->plan_id;
	// 	// }
	// 	// if(empty($plan_id)) {
	// 	// 	echo '<script>alert("Select Plan First");window.location.href="'.base_url('plan').'#all"</script>';
	// 	// }
	// 	// $products = $this->home_model->all_products();
	// 	// if ($products) {
	// 	// 	foreach ($products as $key => $value) {
	// 	// 		$cart = $this->home_model->cart_products($this->session->userdata('user_id'), $value->id);
	// 	// 		if ($cart) {
	// 	// 			$products[$key]->quantity = $cart->quantity;
	// 	// 		} else {
	// 	// 			$products[$key]->quantity = null;
	// 	// 		}
	// 	// 	}
	// 	// 	$weights = $this->home_model->get_cart_weight($this->session->userdata('user_id'));
	// 	// 	$category1 = $this->home_model->get_cart_category1($this->session->userdata('user_id'));
	// 	// 	$category2 = $this->home_model->get_cart_category2($this->session->userdata('user_id'));
	// 	// 	$category3 = $this->home_model->get_cart_category3($this->session->userdata('user_id'));
	// 	// 	$subscription = $this->home_model->get_subscription_details($plan_id);
	// 	// }
	// 	// $this->data['plan_id'] = $plan_id;
	// 	// $this->data['products'] = $products;
	// 	// $this->data['carts']['weight'] = $weights->weight;
	// 	// $this->data['carts']['category1_weight'] = $weights->weight1;
	// 	// $this->data['carts']['category2_weight'] = $weights->weight2;
	// 	// $this->data['carts']['category3_weight'] = $weights->weight3;
	// 	// $this->data['carts']['category1'] = $category1;
	// 	// $this->data['carts']['category2'] = $category2;
	// 	// $this->data['carts']['category3'] = $category3;
	// 	// $this->data['carts']['weight_limit'] = (intval($subscription->order_qty) * 1000) - intval($weights->weight);
	// 	// $this->data['carts']['subscription'] = $subscription;
	// 	$this->data['products'] = $this->home_model->get_all_products();
	// 	$this->template->public_render('public/web/product', $this->data);
	// }



	// public function product_detail()
	// {

	// 	// $this->data['contact_us_section'] = $this->load->view('public/contact_us_section', $this->data, TRUE);
	// 	$this->template->public_render('public/web/product_detail', $this->data);
	// }

	public function auction()
	{

		// $this->data['contact_us_section'] = $this->load->view('public/contact_us_section', $this->data, TRUE);
		$this->template->public_render('public/web/auction', $this->data);
	}

	public function add_address()
	{
		$this->form_validation->set_rules('first_name', 'First_name', 'required', ['required' => 'Please Select %s.']);
		$this->form_validation->set_rules('last_name', 'Last_name', 'required', ['required' => 'Please Enter %s.']);
		$this->form_validation->set_rules('address', 'Address', 'required', ['required' => 'Please Enter %s.']);
		$this->form_validation->set_rules('land_mark', 'Land_mark', 'required', ['required' => 'Please Enter %s.']);
		$this->form_validation->set_rules('city', 'City', 'required', ['required' => 'Please Enter %s.']);
		$this->form_validation->set_rules('state', 'State', 'required', ['required' => 'Please Enter %s.']);
		$this->form_validation->set_rules('postcode', 'Postcode', 'required', ['required' => 'Please Enter %s.']);
		$this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]', ['required' => 'Please Enter %s.']);
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email', ['required' => 'Please Enter %s.']);
		if ($this->form_validation->run() === TRUE) {
			$additional_data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'address' => $this->input->post('address'),
				'land_mark' => $this->input->post('land_mark'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'postcode' => $this->input->post('postcode'),
				'phone' => $this->input->post('phone'),
				'user_id' => $this->session->userdata('user_id'),
				'email' => strtolower($this->input->post('email'))
			];
			$address = $this->home_model->insert_address($additional_data);
			if ($address) {
				$this->session->set_flashdata('message', [1, 'Successfully Add Address Please Select this Before continue']);
				redirect('checkout', 'refresh');
			}
		} else {
			$message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			// $this->template->public_render('public/web/checkout', $this->data);
			$this->session->set_flashdata('message', [0, $message]);
			redirect('checkout', 'refresh');
		}
	}

	

	public function add_to_cart()
	{

		$user_id = $this->session->userdata('user_id');
		$plan_id = $this->input->post('plan_id');
		$product_id = $this->input->post('product_id');
		$l2c_id = $this->input->post('l2c_id');
		// $unit_id = $this->input->post('unit_id');
		$quantity = $this->input->post('quantity');
		$data = [
			'user_id' => $this->session->userdata('user_id'),
			'product_id' => $this->input->post('product_id'),
			// 'unit_id' => $this->input->post('unit_id'),
			'quantity' => $this->input->post('quantity'),
			'l2c_id' => $this->input->post('l2c_id'),
		];
		$productcart = $this->home_model->get_product_cart($product_id, $user_id);
		$product = $this->home_model->get_product($product_id);
		$amount = 0;
		if ($productcart) {
			$weight = $this->home_model->get_cart_weight($this->session->userdata('user_id'));
			if ($weight) {
				$old_weight = intval($product->unit) * intval($productcart->quantity);
				$add_weight = intval($product->unit) * intval($quantity);
				$new_weight = intval($weight->weight) + intval($add_weight) - intval($old_weight);
				// print_r($new_weight);
				$plan_weight = $this->home_model->get_subscription_details($plan_id);
				$check_weight = $this->home_model->check_weight_limit($this->session->userdata('user_id'), $plan_id, $new_weight);
				if ($check_weight) {
					$update_bag = true;
				} else {
					$update_bag = false;
				}
			} else {
				$update_bag = true;
			}
			if ($update_bag) {
				$where = [
					'product_id' => $this->input->post('product_id'),
					'user_id' => $this->session->userdata('user_id')
				];
				if ($product->max_order_qty > $quantity) {
					$update = $this->home_model->update_product($where, $data);
					$weights = $this->home_model->get_cart_weight($this->session->userdata('user_id'));
					$category1_weight = $weights->weight1;
					$category2_weight = $weights->weight2;
					$category3_weight = $weights->weight3;
					if ($update) {
						$response = [
							'status' => 2,
							'message' => 'Successfully update',
							'weight' => $new_weight,
							'category1_weight' => $category1_weight,
							'category2_weight' => $category2_weight,
							'category3_weight' => $category3_weight,
							'weight_limit' => (intval($plan_weight->order_qty) * 1000) - $new_weight
						];
					} else {
						$response = [
							'status' => 0,
							'message' => 'Unable to update cart',
						];
					}
				} else {
					$response = [
						'status' => 0,
						'message' => 'Exceed limit to add cart',
					];
				}
			} else {
				$response = [
					'status' => 0,
					'message' => 'Exceed Weight Limit to add cart',
				];
			}
		} else {
			$check = $this->home_model->check_cart_limit($this->session->userdata('user_id'), $plan_id, $l2c_id);
			if ($check) {
				$weight = $this->home_model->get_cart_weight($this->session->userdata('user_id'));
				// print_r($weight);exit;
				if ($weight->weight > 0) {
					$add_weight = intval($product->unit) * intval($quantity);
					$new_weight = intval($weight->weight) + intval($add_weight);
					$check_weight = $this->home_model->check_weight_limit($this->session->userdata('user_id'), $plan_id, $new_weight);
					if ($check_weight) {
						$add_bag = true;
					} else {
						$add_bag = false;
					}
				} else {
					$add_bag = true;
				}
				if ($add_bag) {
					$insert = $this->home_model->add_to_cart($data);
					$weight = $this->home_model->get_cart_weight($this->session->userdata('user_id'));
					$plan_weight = $this->home_model->get_subscription_details($plan_id);
					$category1 = $this->home_model->get_cart_category1($this->session->userdata('user_id'));
					$category2 = $this->home_model->get_cart_category2($this->session->userdata('user_id'));
					$category3 = $this->home_model->get_cart_category3($this->session->userdata('user_id'));
					$subscription = $this->home_model->get_subscription_details($plan_id);
					$carts['subscription'] = $subscription;
					$cart['category1'] = $category1;
					$cart['category2'] = $category2;
					$cart['category3'] = $category3;
					$cart['weight'] = $weight->weight;
					$cart['category1_weight'] = $weight->weight1;
					$cart['category2_weight'] = $weight->weight2;
					$cart['category3_weight'] = $weight->weight3;
					$cart['weight_limit'] = (intval($plan_weight->order_qty) * 1000) - $weight->weight;
					if ($insert) {
						$response = [
							'status' => 1,
							'message' => 'Successfully added',
							'carts' => $cart
						];
					} else {
						$response = [
							'status' => 0,
							'message' => 'Unable to add cart',
						];
					}
				} else {
					$response = [
						'status' => 0,
						'message' => 'Exceed Weight Limit to add cart',
					];
				}
			} else {
				$response = [
					'status' => 0,
					'message' => 'Exceed Limit to add cart',
				];
			}
		}
		echo json_encode($response);
	}


	public function product_cart($id = null)
	{
		// $plan_id=base64_decode( urldecode( $id));
		// $plan = $this->home_model->get_user_plan($this->session->userdata('user_id'));
		// if ($plan) {
		// 	$plan_id = $plan->plan_id;
		// }
		// if(empty($plan_id)) {
		// 	echo '<script>window.location.href="'.base_url('plan').'#first"</script>';
		// }
		// $products = $this->home_model->get_all_product_cart($this->session->userdata('user_id'));

		// $weights = $this->home_model->get_cart_weight($this->session->userdata('user_id'));
		// $category1 = $this->home_model->get_cart_category1($this->session->userdata('user_id'));
		// $category2 = $this->home_model->get_cart_category2($this->session->userdata('user_id'));
		// $category3 = $this->home_model->get_cart_category3($this->session->userdata('user_id'));
		// $subscription = $this->home_model->get_subscription_details($plan_id);
		// $this->data['plan_id'] = $plan_id;
		// $this->data['products'] = $products;
		// $this->data['carts']['category1'] = $category1;
		// $this->data['carts']['category2'] = $category2;
		// $this->data['carts']['category3'] = $category3;
		// $this->data['carts']['weight'] = $weights->weight;
		// $this->data['carts']['category1_weight'] = $weights->weight1;
		// $this->data['carts']['category2_weight'] = $weights->weight2;
		// $this->data['carts']['category3_weight'] = $weights->weight3;
		// $this->data['carts']['weight_limit'] = (intval($subscription->order_qty) * 1000) - intval($weights->weight);
		// $this->data['carts']['subscription'] = $subscription;
		$this->template->public_render('public/web/cart', $this->data);
	}


	public function checkout($id = null) {
		if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
		$this->data['delivery_charge'] = $this->config->item('delivery_charge');
		$addresses = $this->home_model->get_ecom_addresses($this->session->userdata('user_id'));
		$this->data['carts']['addresses'] = $addresses;
		$this->template->public_render('public/web/checkout', $this->data);
	}



	
	public function place_order($id = null)
	{
		$this->form_validation->set_rules('address_id', 'Address', 'required', ['required' => 'Please Add  %s To Continue']);
		if ($this->form_validation->run() === TRUE) {
			$cart = $this->input->post('cart');
			$qty = $this->input->post('qty');
			$final_price = $this->input->post('final_price');
			if($cart){
				$carts = explode('#', $cart);
				if (!empty($carts)) {
					$total_amount = 0;
					foreach ($carts as $key => $value) {
						$product_id = explode('_', $value)[0];
						$varient_id = explode('_', $value)[1];
						// $bunch_id = explode('_', $value)[2];
						$products[$key] = $this->home_model->get_cart_products($product_id);
				
						$total_amount += $products[$key]->price * intval($qty);
						
					}
					$final_amount = ($total_amount + intval($this->config->item('delivery_charge')));
					// print_r($final_amount);
					// print_r($final_price);exit;
					if($final_amount != intval($final_price)){
						$this->session->set_flashdata('message', [0, 'price get change']);
					} else {

						$res =$this->general_model->getOne('convenience_fees',array('min_order_amt >='=>$final_amount,'max_order_amt <='=>$final_amount));
						$convenience_fees=$res->fees;
						// print_r($_POST);
						$order_no = rand(000000, 999999);
						$order_date = date('Y-m-d H:i:s');
						$cart_orders = serialize($products);
						$insert_data = [
									'order_no' => $order_no,
									'payment_method' => 'ONLINE',
									'order_datetime' => $order_date,
									'order_item_array' => $cart_orders,
									'address_id' => $this->input->post('address_id'),
									'user_id' => $this->session->userdata('user_id'),
									'convenience_fees'=>$convenience_fees,
									'gst_amount'=>$gst_amount
								];
						$order_id = $this->home_model->insert_cart_orders($insert_data);
						$user_id = $this->session->userdata('user_id');
						$apiUrl = getenv('PAYMENT_URL') . "api/v1/order/create";
						$cf_request = array(
							'appId' => getenv('API_ID'),
							'secretKey' => getenv('SECRET_KEY'),
							'orderId' => "TNS-" . $order_id,
							'orderAmount' => intval($final_price),
							'orderCurrency' => "INR",
							'orderNote' => "Product Payment",
							'customerEmail' => 'unknown@test.com',
							'customerName' => 'full_name',
							'customerPhone' => '7999252055',
							'returnUrl' => base_url()."welcome/update_payment_status/" .$user_id.'/'.$order_id
						);
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $apiUrl . "?");
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $cf_request);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
						$curl_result = curl_exec($ch);
						curl_close($ch);
						$jsonResponse = json_decode($curl_result);
						if ($jsonResponse->status == "OK") {
							echo "<script> window.location.href = '" . $jsonResponse->paymentLink . "'; </script>";
							exit;
						} else {
							echo $jsonResponse->reason;
						}
					}
	
				}
			} else {
				$this->session->set_flashdata('message', [0, 'cart data not found']);
			}
		} else {
			$message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('message', [0, $message]);
			$addresses = $this->home_model->get_ecom_addresses($this->session->userdata('user_id'));
			$this->data['carts']['addresses'] = $addresses;
			$this->template->public_render('public/web/checkout', $this->data);
		}
	}



	public function update_payment_status($user_id, $order_id)
	{
		$apiUrl = getenv('PAYMENT_URL') . "api/v1/order/info/status";
		$cf_request = array(
			'appId' => getenv('API_ID'),
			'secretKey' => getenv('SECRET_KEY'),
			'orderId' => "TNS-" . $order_id
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiUrl . "?");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $cf_request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$curl_result = curl_exec($ch);
		curl_close($ch);
		$jsonResponse = json_decode($curl_result);
		if ($jsonResponse->status == "OK") {
			if ($jsonResponse->orderStatus == "PAID"  || $jsonResponse->orderStatus == "ACTIVE" && $jsonResponse->txStatus != "CANCELLED") {
				$update_order = $this->home_model->update_order_status($order_id, ['payment_status' => 1, 'delivered' => 1]);
				if ($update_order) {
					$payment_time = date('Y-m-d H:i:s');
					$insert_payment = [
						'user_id' => $user_id,
						'order_id' => $order_id,
						'orderStatus' => $jsonResponse->orderStatus,
						'orderAmount' => $jsonResponse->orderAmount,
						'txStatus' => $jsonResponse->txStatus,
						'txTime' => $jsonResponse->txTime,
						'txMsg' => $jsonResponse->txMsg,
						'referenceId' => $jsonResponse->referenceId,
						'paymentMode' => $jsonResponse->paymentMode,
						'orderCurrency' => $jsonResponse->orderCurrency,
						'payment_time' => $payment_time
					];
					$this->home_model->insert_payment_details($insert_payment);
					// $this->home_model->delete_cart($user_id);
					$users = $this->home_model->get_user_details($user_id);
					$this->ion_auth->logout();
					$session = $this->ion_auth->set_session($users);
					if ($session) {
						echo '<script>
						localStorage.removeItem("printcart");
						localStorage.removeItem("printqty");
						window.location.href="' . base_url('welcome/thankyou') . '"</script>';
					}
				}
			} else {
				$update_order = $this->home_model->update_order_status($order_id, ['payment_status' => 2, 'delivered' => 0]);
				if ($update_order) {
					echo '<script>window.location.href="' . base_url('welcome/checkout') . '"</script>';
				}
			}
		}
	}

		public function change_password()
	{
		$identity = $this->session->userdata('email');
		$this->form_validation->set_rules('password', 'password', 'required', ['required' => 'Please Select %s.']);
		$this->form_validation->set_rules('new_password', 'new_password', 'required', ['required' => 'Please Enter %s.']);
		if ($this->form_validation->run() === TRUE) {
			$change = $this->ion_auth->change_password($identity, $this->input->post('password'), $this->input->post('new_password'));
			if ($change) {
				$this->session->set_flashdata('message', [1, 'Password Change Successfully']);
				redirect('change-password', 'refresh');
			} else {
				$this->session->set_flashdata('message', [0, 'Password Not Match']);
				redirect('change-password', 'refresh');
			}
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->template->public_render('public/web/change_password', $this->data);
		}
	}

	public function change_password_old()
	{
		$identity = $this->session->userdata('email');
		$change = $this->ion_auth->change_password($identity, $this->input->post('password'), $this->input->post('new_password'));
		if ($change) {
			$response = [
				'status' => 1,
				'message' => 'Password Changed Successfully'
			];
		} else {
			$response = [
				'status' => 0,
				'message' => 'Password Not Match With Old Password',
			];
		}
		echo json_encode($response);
	}

	public function order_details($id)
	{
		$order_id = $id;
		$order_details = $this->home_model->order_details($order_id);
		$this->data['order_details'] = $order_details[0];
		$this->template->public_render('public/web/order_details',$this->data);
	}

	public function remove_cart()
	{
		$data = [
			'user_id' => $this->session->userdata('user_id'),
			'product_id' => $this->input->post('product_id')
		];
		$plan_id = $this->input->post('plan_id');
		$remove = $this->home_model->remove_cart($data);
		if ($remove) {
			$products = $this->home_model->get_all_product_cart($this->session->userdata('user_id'));
			$amount = 0;
			if ($products) {
				foreach ($products as $key => $value) {
					$amount += intval($value->unit) * intval($value->quantity);
				}
			}
			$category1 = $this->home_model->get_cart_category1($this->session->userdata('user_id'));
			$category2 = $this->home_model->get_cart_category2($this->session->userdata('user_id'));
			$category3 = $this->home_model->get_cart_category3($this->session->userdata('user_id'));
			$weights = $this->home_model->get_cart_weight($this->session->userdata('user_id'));
			$subscription = $this->home_model->get_subscription_details($plan_id);
			$carts['plan_id'] = $plan_id;
			$carts['weight_limit'] = (intval($subscription->order_qty) * 1000) - intval($weights->weight);
			$carts['weight'] = $amount;
			if ($carts['weight']  == 0) {
				$carts['weight_limit'] = (intval($subscription->order_qty) * 1000);
			}
			$carts['subscription'] = $subscription;
			$carts['category1'] = $category1;
			$carts['category2'] = $category2;
			$carts['category3'] = $category3;
			$carts['category1_weight'] = $weights->weight1;
			$carts['category2_weight'] = $weights->weight2;
			$carts['category3_weight'] = $weights->weight3;
			$response = [
				'status' => 1,
				'message' => 'Product Remove Successfully',
				'carts' => $carts,
			];
		} else {
			$response = [
				'status' => 0,
				'message' => 'Unable to remove product',
			];
		}
		echo json_encode($response);
	}



	public function enquiry()
	{
		// $this->data['contact_us_section'] = $this->load->view('public/contact_us_section', $this->data, TRUE);
		$this->template->public_render('public/web/enquiry', $this->data);
	}

	public function terms_and_conditions()
	{
		$this->template->public_render('public/terms_and_conditions', $this->data);
	}

	public function privacy_policy()
	{
		$this->template->public_render('public/privacy_policy', $this->data);
	}

	public function b2b_terms_of_service()
	{
		$this->template->public_render('public/b2b_terms_of_service', $this->data);
	}

	function get_auto_product_list(){
        $product_name = $this->input->get_post('term');
        $product_data = $this->home_model->get_all_product($product_name);
        $product_list = array();
        if(isset($product_data) && !empty($product_data)){
            foreach ($product_data as $key => $value) {
                $data['id'] =$value->id;
                $data['p_url'] =base_url('product-detail').'/'.urlencode(base64_encode($value->id));

                $data['value'] = strtoupper($value->product_name);
                $data['label'] = strtoupper($value->product_name);
                array_push($product_list, $data);
            }
        }
        echo json_encode($product_list);
    }
}
