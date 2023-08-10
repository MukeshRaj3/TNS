<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Seller_Controller
{

	public function __construct()
	{
		parent::__construct();

		/* Load :: Common */
		$this->load->model('seller/home_model');
	}

	public function index()
	{
		if(empty($this->session->userdata('user_id')))
    {
    redirect('account/seller_login', 'refresh');
    }
		/* Title Page */
		$this->page_title->push(lang('menu_users'));
		$this->data['pagetitle'] = $this->page_title->show();

		/* Load Template */
		$this->template->seller_render('seller/home/index', $this->data);
	}

	public function profile()
	{
		$this->page_title->push(lang('menu_users'));
		$this->data['pagetitle'] = $this->page_title->show();
		$id = $this->session->userdata('user_id');

		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('full_name', 'full_name', 'trim|required');
		$this->form_validation->set_rules('company_type', 'company_type', 'trim|required');
		$get_data = $this->home_model->profile($id);
		$tax_detail = $this->home_model->tax_details($id);
		if ($this->form_validation->run() == TRUE) {
			$insert = [
				'company_type' => $this->input->post('company_type'),
				'full_name' => $this->input->post('full_name'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'district' => $this->input->post('district'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country'),
				'pincode' => $this->input->post('pincode'),
				'phone' => $this->input->post('phone'),
				'telephone' => $this->input->post('telephone'),
				'fax_number' => $this->input->post('fax_number'),
				'contact_person' => $this->input->post('contact_person'),
				'designation' => $this->input->post('designation')
			];
			$tax_data = [
				'gstin' => $this->input->post('gstin'),
				'pan' => $this->input->post('pan'),
				'tan' => $this->input->post('tan'),
				'tds' => $this->input->post('tds'),
				'msme' => $this->input->post('msme'),
			];
			if (!empty($_FILES['gstin_doc']['name'])) {
				$file_name = 'gst_' . time() . rand(100, 999);
				$config = [
					'upload_path' => './upload/seller/',
					'file_name' => $file_name,
					'allowed_types' => 'gif|jpg|png|bmp|jpeg|pdf',
					'max_size' => 50480,
					'max_width' => 20480,
					'max_height' => 20480,
					'file_ext_tolower' => TRUE,
					'remove_spaces' => TRUE,
				];
				$this->load->library('upload/', $config);
				if ($this->upload->do_upload('gstin_doc')) {
					$uploadData = $this->upload->data();
					$tax_data['gstin_doc'] = 'upload/seller/' . $uploadData['file_name'];
					if (!empty($tax_detail)) {
						if (is_file($tax_detail->gstin_doc)) {
							unlink($tax_detail->gstin_doc);
						}
					}
				} else {
					$this->session->set_flashdata('message', ['0', 'File Not Support']);
					redirect('seller/home/profile', 'refresh');
				}
			}
			if (!empty($_FILES['pan_doc']['name'])) {
				$file_name = 'pan_' . time() . rand(100, 999);
				$config = [
					'upload_path' => './upload/seller/',
					'file_name' => $file_name,
					'allowed_types' => 'gif|jpg|png|bmp|jpeg|pdf',
					'max_size' => 50480,
					'max_width' => 20480,
					'max_height' => 20480,
					'file_ext_tolower' => TRUE,
					'remove_spaces' => TRUE,
				];
				$this->load->library('upload/', $config);
				if ($this->upload->do_upload('pan_doc')) {
					$uploadData = $this->upload->data();
					$tax_data['pan_doc'] = 'upload/seller/' . $uploadData['file_name'];
					if (!empty($tax_detail)) {
						if (is_file($tax_detail->pan_doc)) {
							unlink($tax_detail->pan_doc);
						}
					}
				} else {
					$this->session->set_flashdata('message', ['0', 'File Not Support']);
					redirect('seller/home/profile', 'refresh');
				}
			}
			if (!empty($_FILES['tan_doc']['name'])) {
				$file_name = 'pan_' . time() . rand(100, 999);
				$config = [
					'upload_path' => './upload/seller/',
					'file_name' => $file_name,
					'allowed_types' => 'gif|jpg|png|bmp|jpeg|pdf',
					'max_size' => 50480,
					'max_width' => 20480,
					'max_height' => 20480,
					'file_ext_tolower' => TRUE,
					'remove_spaces' => TRUE,
				];
				$this->load->library('upload/', $config);
				if ($this->upload->do_upload('tan_doc')) {
					$uploadData = $this->upload->data();
					$tax_data['tan_doc'] = 'upload/seller/' . $uploadData['file_name'];
					if (!empty($tax_detail)) {
						if (is_file($tax_detail->tan_doc)) {
							unlink($tax_detail->tan_doc);
						}
					}
				} else {
					$this->session->set_flashdata('message', ['0', 'File Not Support']);
					redirect('seller/home/profile', 'refresh');
				}
			}
			if (!empty($_FILES['tds_doc']['name'])) {
				$file_name = 'pan_' . time() . rand(100, 999);
				$config = [
					'upload_path' => './upload/seller/',
					'file_name' => $file_name,
					'allowed_types' => 'gif|jpg|png|bmp|jpeg|pdf',
					'max_size' => 50480,
					'max_width' => 20480,
					'max_height' => 20480,
					'file_ext_tolower' => TRUE,
					'remove_spaces' => TRUE,
				];
				$this->load->library('upload/', $config);
				if ($this->upload->do_upload('tds_doc')) {
					$uploadData = $this->upload->data();
					$tax_data['tds_doc'] = 'upload/seller/' . $uploadData['file_name'];
					if (!empty($tax_detail)) {
						if (is_file($tax_detail->tds_doc)) {
							unlink($tax_detail->tds_doc);
						}
					}
				} else {
					$this->session->set_flashdata('message', ['0', 'File Not Support']);
					redirect('seller/home/profile', 'refresh');
				}
			}
			if (!empty($_FILES['msme_doc']['name'])) {
				$file_name = 'msme_' . time() . rand(100, 999);
				$config = [
					'upload_path' => './upload/seller/',
					'file_name' => $file_name,
					'allowed_types' => 'gif|jpg|png|bmp|jpeg|pdf',
					'max_size' => 50480,
					'max_width' => 20480,
					'max_height' => 20480,
					'file_ext_tolower' => TRUE,
					'remove_spaces' => TRUE,
				];
				$this->load->library('upload/', $config);
				if ($this->upload->do_upload('msme_doc')) {
					$uploadData = $this->upload->data();
					$tax_data['msme_doc'] = 'upload/seller/' . $uploadData['file_name'];
					if (!empty($tax_detail)) {
						if (is_file($tax_detail->msme_doc)) {
							unlink($tax_detail->msme_doc);
						}
					}
				} else {
					$this->session->set_flashdata('message', ['0', 'File Not Support']);
					redirect('seller/home/profile', 'refresh');
				}
			}
			// $turn_over = [
			// 	'company_type' => $this->input->post('company_type'),
			// ];
			// $bank_detail = [
			// 	'company_type' => $this->input->post('company_type'),
			// ];
			if (!empty($_FILES['image']['name'])) {

				$file_name = 'seller_' . time() . rand(100, 999);
				$config = [
					'upload_path' => './upload/seller/',
					'file_name' => $file_name,
					'allowed_types' => 'png|jpg|jpeg',
					'max_size' => 50480,
					'max_width' => 20480,
					'max_height' => 20480,
					'file_ext_tolower' => TRUE,
					'remove_spaces' => TRUE,
				];
				$this->load->library('upload/', $config);
				if ($this->upload->do_upload('image')) {
					$uploadData = $this->upload->data();
					$insert['image'] = 'upload/seller/' . $uploadData['file_name'];
					if (!empty($get_data)) {
						if (is_file($get_data->image)) {
							unlink($get_data->image);
						}
					}
				} else {
					$this->session->set_flashdata('message', ['0', 'File Not Support']);
					redirect('seller/home/profile', 'refresh');
				}
			}
			$update = $this->home_model->update_profile($id, $insert, $tax_data);

			if ($update) {
				$this->session->set_flashdata('message', ['1', 'Profile has been updated successfully']);
				redirect('seller/home/profile', 'refresh');
			} else {
				$this->session->set_flashdata('message', ['0', 'unable to update profile']);
				redirect('seller/home/profile', 'refresh');
			}
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['profile'] = $this->home_model->profile($id);
			$this->data['company_types'] = $this->home_model->company_types();
			$this->data['tax_details'] = $this->home_model->tax_details($id);
			/* Load Template */
			$this->template->seller_render('seller/home/profile', $this->data);
		}
	}

	public function approved($id)
	{
		if (empty($id)) {
			redirect('seller/business', 'refresh');
		}

		$business = $this->general_model->getOne('business', array('id' => $id));
		$is_updated = $this->business_model->business_approve_reject($id, 1);

		if ($is_updated) {
			$this->data['business'] = $business;
			$this->send_business_email_notification($business->email);
			$message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_business_approved', 'ion_auth'), $this->data, true);

			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->Host = $this->config->item('aws_ses_host');
			$mail->SMTPAuth = true;
			$mail->Username = $this->config->item('aws_ses_username');
			$mail->Password = $this->config->item('aws_ses_password');
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;
			$mail->setFrom($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
			$mail->addAddress($business->email, $this->config->item('site_title', 'ion_auth'));
			$mail->isHTML(true);
			$mail->Subject = $this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('business_email_approved_subject');
			$mail->Body = $message;
			if ($mail->send()) {
				$this->session->set_flashdata('message', array('1', $this->lang->line('business_approved_success')));
				redirect('seller/business', 'refresh');
			} else {
				$this->session->set_flashdata('message', array('1', $this->lang->line('business_approved_email_sent_failed')));
				redirect('seller/business', 'refresh');
			}
		} else {
			$this->session->set_flashdata('message', array('0', $this->lang->line('business_approved_failed')));
			redirect('seller/business', 'refresh');
		}
	}

	public function rejected()
	{
		$business_id = $this->input->post('business_id');
		if (!empty($business_id)) {
			$business = $this->general_model->getOne('business', array('id' => $business_id));
			if (!empty($business)) {
				if ($business->business_status == 2) {
					$response = [
						'status' => 0,
						'message' => $this->lang->line('business_already_rejected')
					];
				} else {
					$is_rejected = $this->business_model->business_approve_reject($business_id, 2);

					if ($is_rejected) {
						$this->data['business'] = $business;
						$message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_business_rejected', 'ion_auth'), $this->data, true);

						$mail = new PHPMailer;
						$mail->isSMTP();
						$mail->Host = $this->config->item('aws_ses_host');
						$mail->SMTPAuth = true;
						$mail->Username = $this->config->item('aws_ses_username');
						$mail->Password = $this->config->item('aws_ses_password');
						$mail->SMTPSecure = 'ssl';
						$mail->Port = 465;
						$mail->setFrom($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
						$mail->addAddress($business->email, $this->config->item('site_title', 'ion_auth'));
						$mail->isHTML(true);
						$mail->Subject = $this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('business_email_rejected_subject');
						$mail->Body = $message;
						if ($mail->send()) {
							$response = array(
								'status' => 1,
								'message' => $this->lang->line('business_rejected_success')
							);
						} else {
							$response = array(
								'status' => 1,
								'message' => $this->lang->line('business_rejected_email_sent_failed')
							);
						}
					} else {
						$response = array(
							'status' => 0,
							'message' => $this->lang->line('business_rejected_failed')
						);
					}
				}
			} else {
				$response = array(
					'status' => 0,
					'message' => 'Business detail not found.'
				);
			}
		} else {
			$response = array(
				'status' => 0,
				'message' => 'Something went wrong.'
			);
		}
		echo json_encode($response);
	}

	public function deleted()
	{
		$business_id = $this->input->post('business_id');
		if (!empty($business_id)) {
			$business = $this->general_model->getOne('business', array('id' => $business_id));
			if (!empty($business)) {
				$is_deleted = $this->business_model->business_deleted($business_id);
				if ($is_deleted) {
					$this->data['business'] = $business;
					$message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_business_deleted', 'ion_auth'), $this->data, true);

					$mail = new PHPMailer;
					$mail->isSMTP();
					$mail->Host = $this->config->item('aws_ses_host');
					$mail->SMTPAuth = true;
					$mail->Username = $this->config->item('aws_ses_username');
					$mail->Password = $this->config->item('aws_ses_password');
					$mail->SMTPSecure = 'ssl';
					$mail->Port = 465;
					$mail->setFrom($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
					$mail->addAddress($business->email, $this->config->item('site_title', 'ion_auth'));
					$mail->isHTML(true);
					$mail->Subject = $this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('business_email_deleted');
					$mail->Body = $message;
					if ($mail->send()) {
						$response = array(
							'status' => 1,
							'message' => $this->lang->line('business_deleted_success')
						);
					} else {
						$response = array(
							'status' => 1,
							'message' => $this->lang->line('business_deleted_email_sent_failed')
						);
					}
				} else {
					$response = array(
						'status' => 0,
						'message' => $this->lang->line('business_deleted_failed')
					);
				}
			} else {
				$response = array(
					'status' => 0,
					'message' => 'Business detail not found.'
				);
			}
		} else {
			$response = array(
				'status' => 0,
				'message' => 'Something went wrong.'
			);
		}
		echo json_encode($response);
	}

	public function view($id = NULL)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		if (is_null($id)) {
			$this->session->set_flashdata('message', ['0', 'Business not found']);
			redirect('seller/business', 'refresh');
		}

		/* Title Page */
		$this->page_title->push(lang('menu_business'));
		$this->data['pagetitle'] = $this->page_title->show();

		$business = $this->business_model->fetch_business($id);
		if (is_null($business)) {
			$this->session->set_flashdata('message', ['0', 'Business not found']);
			redirect('seller/business', 'refresh');
		}

		$this->data['business'] = $business;
		$this->data['business_type'] = $this->business_model->fetch_business_type($business->type);
		$this->data['facility_data'] = $this->business_model->fetch_facility($business->facilities);
		$business_venues = $this->business_model->fetch_venue($id);
		$venue = [];
		if (!empty($business_venues)) {
			foreach ($business_venues as $business_venue) {
				$venue[] = $business_venue->venue_name;
			}
		}

		$this->data['stadium'] = implode(', ', $venue);
		// print_r($this->data['stadium']);exit;
		/* Load Template */
		$this->template->seller_render('seller/business/view', $this->data);
	}

	private function send_business_email_notification($email)
	{
		$this->data['name'] = "";
		$message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_business_live_profile', 'ion_auth'), $this->data, true);

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = $this->config->item('aws_ses_host');
		$mail->SMTPAuth = true;
		$mail->Username = $this->config->item('aws_ses_username');
		$mail->Password = $this->config->item('aws_ses_password');
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		$mail->setFrom($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
		$mail->addAddress($email, $this->config->item('site_title', 'ion_auth'));
		$mail->isHTML(true);
		$mail->Subject = 'Welcome to ' . $this->config->item('site_title', 'ion_auth');
		$mail->Body = $message;
		$mail->send();
	}

	public function edit($id = NULL)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		if (is_null($id)) {
			$this->session->set_flashdata('message', ['0', 'Business not found']);
			redirect('seller/business', 'refresh');
		}

		$business = $this->business_model->fetch_business($id);
		$business_venue = $this->business_model->fetch_venue($id);
		if (is_null($business)) {
			$this->session->set_flashdata('message', ['0', 'Business not found']);
			redirect('seller/business', 'refresh');
		}

		/* Title Page */
		$this->page_title->push(lang('menu_edit_business'));
		$this->data['pagetitle'] = $this->page_title->show();

		$this->form_validation->set_rules('business_address', 'Address', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$facilities = $this->input->post('facilities');
			if (!empty($facilities)) {
				$facilities = implode(",", $facilities);
			}
			$data = [
				'title' => $this->input->post('title'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'contact_number' => $this->input->post('contact_number'),
				'full_name' => $this->input->post('business_name'),
				'phone' => $this->input->post('business_phone'),
				'business_email' => $this->input->post('business_email'),
				'website' => $this->input->post('business_website'),
				'type' => $this->input->post('business_type'),
				'address' => $this->input->post('business_address'),
				'pincode' => $this->input->post('postcode'),
				'latitude' => $this->input->post('address_latitude'),
				'longitude' => $this->input->post('address_longitude'),
				// 'venue_id' => $this->input->post('stadium_id'),
				'facilities' => $facilities,
			];
			$update = $this->business_model->update_business($business->id, $data);
			$venues = $this->input->post('stadium_id');
			$this->business_model->update_venue($venues, $business->id);
			if ($update) {
				$this->session->set_flashdata('message', ['1', 'Business has been updated successfully']);
				redirect('seller/business', 'refresh');
			} else {
				$this->session->set_flashdata('message', ['0', 'unble to update business']);
				redirect('seller/business', 'refresh');
			}
		} else {
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['business'] = $business;
			$this->data['business_type_row'] = $this->general_model->getOne('business_types', array('bt_id' => $business->type));
			$this->data['business_types'] = $this->business_model->business_types();
			$this->data['stadium'] = $this->business_model->fetch_stadium($business_venue);

			/* Load Template */
			$this->template->seller_render('seller/business/edit', $this->data);
		}
	}
}
