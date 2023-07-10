<?php defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH . '/third_party/PHPMailer/PHPMailerAutoload.php';
class Contact_us_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->tables = [
            'business_enquires' => 'business_enquires',
            'contact_us' => 'contact_us'
        ];
        $this->board = [
            'business_enquiry' => 1244747461,
            'contact_us' => 1398354886,
            'partners' => 1271080608
        ];

        $this->auth_token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjExMzE1ODAwMCwidWlkIjoyMTcyNDc4MywiaWFkIjoiMjAyMS0wNi0xMFQwNDoyMzowOS4xNDVaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6NjY3Mzc1MCwicmduIjoidXNlMSJ9.FlH8Nxn8vaaIw2RBDXerFnd8DmPuT0RzUsyDxZ5pEBw';
    }

    public function save_enquiry($post_data)
    {
      $enquiry_data = [
          'first_name' => $post_data['first_name'],
          'last_name' => $post_data['last_name'],
          'email' => $post_data['email'],
          'contact_number' => $post_data['contact_number'],
          'business_name' => $post_data['business_name'],
          'business_type' => $post_data['business_type'],
          'business_address' => $post_data['business_address'],
          'postcode' => $post_data['postcode'],
          'hear_about_us' => $post_data['hear_about_us'],
          'message' => $post_data['message'],
          'latitude' => $post_data['address_latitude'],
          'longitude' => $post_data['address_longitude'],
          'created_on' => now()
      ];

      $is_insert = $this->db->insert($this->tables['business_enquires'], $enquiry_data);

      if ($is_insert) {
          $item_name = $post_data['first_name'].' '.$post_data['last_name'];
          /* Send Email Notification */
          $this->send_email_notification($post_data, 1);

          $finaladdress =   $post_data['address_latitude'].' '.$post_data['address_longitude'].' '.$post_data['business_address'];  

          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.monday.com/v2/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"query":"mutation {\\r\\n    create_item (board_id: '.$this->board['business_enquiry'].', item_name: \\"'.$item_name.'\\") {\\r\\n        id\\r\\n    }\\r\\n}","variables":{}}',
            CURLOPT_HTTPHEADER => array(
              'Authorization:'.$this->auth_token,
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);
          
          curl_close($curl);
          
          if (!empty($response)) {
              $data = json_decode($response);

              if (!empty($data->data->create_item->id)) {
                  $item_id = $data->data->create_item->id;

                  $curl = curl_init();
                  curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.monday.com/v2/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{"query":"mutation {\\r\\n    a1 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"text_1\\", value: \\"'.$post_data['first_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a2 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"text\\", value: \\"'.$post_data['last_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a3 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"text9\\", value: \\"'.$post_data['email'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a4 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"phone_1\\", value: \\"'.$post_data['contact_number'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a5 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"text96\\", value: \\"'.$post_data['business_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a6 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"status_14\\", value: \\"'.$post_data['business_type'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a7 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"text6\\", value: \\"'.$post_data['business_address'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a8 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"text34\\", value: \\"'.$post_data['postcode'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a9 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"status\\", value: \\"New Enquiry\\") {\\r\\n        id\\r\\n    }\\r\\n    a10 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"text7\\", value: \\"'.$post_data['message'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a11 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"location2\\", value: \\"'.$finaladdress.'\\") {\\r\\n        id\\r\\n    }\\r\\n    a12 : change_simple_column_value (board_id: '.$this->board['business_enquiry'].', item_id: '.$item_id.', column_id: \\"text71\\", value: \\"'.$post_data['hear_about_us'].'\\") {\\r\\n        id\\r\\n    }\\r\\n}","variables":{}}',
                    CURLOPT_HTTPHEADER => array(
                      'Authorization: '.$this->auth_token,
                      'Content-Type: application/json'
                    ),
                  ));

                  $response = curl_exec($curl);

                  curl_close($curl);

                  return TRUE;
              }
          }
      }
    }

    public function partnerships($post_data)
    {
        $enquiry_data = [
            'first_name' => $post_data['first_name'],
            'last_name' => $post_data['last_name'],
            'email' => $post_data['email'],
            'contact_number' => $post_data['contact_number'],
            'business_name' => $post_data['business_name'],
            'position' => $post_data['position'],
            'is_partnership' => 1,
            'created_on' => now()
        ];

        $is_insert = $this->db->insert($this->tables['business_enquires'], $enquiry_data);

        if ($is_insert) {
            /* Send Email Notification */
            $this->send_email_notification($post_data, 2);

            $item_name = $post_data['first_name'].' '.$post_data['last_name'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.monday.com/v2/',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{"query":"mutation {\\r\\n    create_item (board_id: '.$this->board['partners'].', item_name: \\"'.$item_name.'\\") {\\r\\n        id\\r\\n    }\\r\\n}","variables":{}}',
              CURLOPT_HTTPHEADER => array(
                'Authorization:'.$this->auth_token,
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            
            if (!empty($response)) {
                $data = json_decode($response);

                if (!empty($data->data->create_item->id)) {
                    $item_id = $data->data->create_item->id;

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.monday.com/v2/',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'POST',
                      CURLOPT_POSTFIELDS =>'{"query":"mutation {\\r\\n    a1 : change_simple_column_value (board_id: '.$this->board['partners'].', item_id: '.$item_id.', column_id: \\"text2\\", value: \\"'.$post_data['first_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a2 : change_simple_column_value (board_id: '.$this->board['partners'].', item_id: '.$item_id.', column_id: \\"text3\\", value: \\"'.$post_data['last_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a3 : change_simple_column_value (board_id: '.$this->board['partners'].', item_id: '.$item_id.', column_id: \\"text\\", value: \\"'.$post_data['business_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a4 : change_simple_column_value (board_id: '.$this->board['partners'].', item_id: '.$item_id.', column_id: \\"text33\\", value: \\"'.$post_data['position'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a5 : change_simple_column_value (board_id: '.$this->board['partners'].', item_id: '.$item_id.', column_id: \\"phone\\", value: \\"'.$post_data['contact_number'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a6 : change_simple_column_value (board_id: '.$this->board['partners'].', item_id: '.$item_id.', column_id: \\"text7\\", value: \\"'.$post_data['email'].'\\") {\\r\\n        id\\r\\n    }\\r\\n}","variables":{}}',
                      CURLOPT_HTTPHEADER => array(
                        'Authorization: '.$this->auth_token,
                        'Content-Type: application/json'
                      ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    return TRUE;
                }
            }
        }
    }

    public function save_contactus($post_data) {
      $enquiry_data = [
          'first_name' => $post_data['first_name'],
          'last_name' => $post_data['last_name'],
          'email' => $post_data['email'],
          'message' => $post_data['message'],
          'created_on' => now()
      ];

      $is_insert = $this->db->insert($this->tables['contact_us'], $enquiry_data);

      if ($is_insert) {
          /* Send Email Notification */
          $this->send_email_notification($post_data, 3);

          $item_name = $post_data['first_name'].' '.$post_data['last_name'];
          
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.monday.com/v2/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"query":"mutation {\\r\\n    create_item (board_id: '.$this->board['contact_us'].', item_name: \\"'.$item_name.'\\") {\\r\\n        id\\r\\n    }\\r\\n}","variables":{}}',
            CURLOPT_HTTPHEADER => array(
              'Authorization:'.$this->auth_token,
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);
          
          curl_close($curl);
          
          if (!empty($response)) {
              $data = json_decode($response);

              if (!empty($data->data->create_item->id)) {
                  $item_id = $data->data->create_item->id;

                  $curl = curl_init();
                  curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.monday.com/v2/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{"query":"mutation {\\r\\n    a1 : change_simple_column_value (board_id: '.$this->board['contact_us'].', item_id: '.$item_id.', column_id: \\"text\\", value: \\"'.$post_data['first_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a2 : change_simple_column_value (board_id: '.$this->board['contact_us'].', item_id: '.$item_id.', column_id: \\"text6\\", value: \\"'.$post_data['last_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a3 : change_simple_column_value (board_id: '.$this->board['contact_us'].', item_id: '.$item_id.', column_id: \\"text65\\", value: \\"'.$post_data['email'].'\\") {\\r\\n        id\\r\\n    }\\r\\n  a4 : change_simple_column_value (board_id: '.$this->board['contact_us'].', item_id: '.$item_id.', column_id: \\"text7\\", value: \\"'.$post_data['message'].'\\") {\\r\\n        id\\r\\n    }\\r\\n}","variables":{}}',
                    CURLOPT_HTTPHEADER => array(
                      'Authorization: '.$this->auth_token,
                      'Content-Type: application/json'
                    ),
                  ));

                  $response = curl_exec($curl);

                  curl_close($curl);

                  return TRUE;
              }
          }
      }
    }

    private function send_email_notification($user_data, $type) {
        if ($type == 1) {
          $message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_business_enquiry', 'ion_auth'), $this->data, true);
          $title = 'Business Enquiry';
        } else if ($type == 2) {
          $message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_partnership', 'ion_auth'), $this->data, true);
          $title = 'Partnership Enquiry';
        } else if ($type == 3) {
          $message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_contact_us', 'ion_auth'), $this->data, true);
          $title = 'Contact Us';
        }
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $this->config->item('aws_ses_host');
        $mail->SMTPAuth = true;
        $mail->Username = $this->config->item('aws_ses_username');
        $mail->Password = $this->config->item('aws_ses_password');
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
        $mail->addAddress($user_data['email'], $this->config->item('site_title', 'ion_auth'));
        $mail->isHTML(true);
        $mail->Subject = $this->config->item('site_title', 'ion_auth') . '-' .$title;
        $mail->Body = $message;
        $mail->send();
    }
}
