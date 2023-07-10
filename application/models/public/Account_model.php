<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Account_model extends CI_Model {



    public function __construct() {

        parent::__construct();

        $this->radius_value = 3959; /* For Miles 3959 , For KM 6371 */

        $this->radius_distance = 5;

        $this->tables = [

           // 'business_venue' => 'business_venue',

            //'company_types' => 'company_types',

           // 'facilities' => 'facilities',

           // 'enet_venues' => 'enet_venues'
            'ecom_sellers' => 'ecom_sellers'


        ];



        $this->board = [

        	'business_signup' => 1428264517	

        ];



      /*  $this->auth_token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjExNTE4NTY4NiwidWlkIjoyMjczNzI2NywiaWFkIjoiMjAyMS0wNi0yOFQwODo0MzoxNy42MjhaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6OTI0OTg1OCwicmduIjoidXNlMSJ9.t6jCsKSoh5QjJQAhZbpYJPHZ-FWeSXXX7l6zHCCsnHg';*/

    }



    public function get_near_by_stadiums($latitude, $longitude)

    {

    	$this->db->select('enet_venues.*,( '.$this->radius_value.' * acos( cos( radians('.$latitude.') ) * cos( radians( enet_venues.latitude ) ) * cos( radians( enet_venues.longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( enet_venues.latitude ) ) ) ) AS distance');

        $this->db->having('distance <=', $this->radius_distance);

        $query = $this->db->get('enet_venues');



        return $query->result();

    }



    public function seller_login($mobile_no,$otp) {
        $query = $this->db->get_where($this->tables['ecom_sellers'], ['mobile_no' => $mobile_no,'otp'=>$otp]);
        if ($query->num_rows()) {
            return $query->row();
        }
        return FALSE;
    }

    public function register_seller($data)
    {
        return $this->db->insert($this->tables['ecom_sellers'],$data);
    }

   public function file_upload($file_name,$upload_path)
   {
     
                $file = $file_name.time().rand(100, 999);
                $config = array(
                'upload_path'       => $upload_path,
                'allowed_types' => 'png|jpg|jpeg',
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


    public function company_types() {

        $query = $this->db->get_where($this->tables['company_types'], ['active' => 1]);

        if ($query->num_rows()) {

            return $query->result();

        }

        return FALSE;

    }



	public function insert_venue($venues, $business_id) {

        $data = [];

        if(!empty($venues)) {

            foreach ($venues as $venue) {

                $data[] = [

                    'business_id' => $business_id,

                    'venue_id'    => $venue 

                ];

            }

            $query = $this->db->insert_batch($this->tables['business_venue'], $data);

            if($query) {

                return $query;

            }

            return FALSE;

        }

        return FALSE;

    }

	

    public function fetch_facility($facility_ids) {

        $facility_ids = explode(',', $facility_ids);

        $this->db->simple_query('SET SESSION group_concat_max_len=1000000000');

        $this->db->select('GROUP_CONCAT(facility SEPARATOR ", ") as facilities');

        $this->db->from($this->tables['facilities']);

        $this->db->where_in('id', $facility_ids);

        $query = $this->db->get()->row_array();

        return $query['facilities'];

    }



    public function fetch_stadium($venues) {

        $row = [];



        if (!empty($venues)) {

            foreach ( $venues as $venue ) {

                $query = $this->db->get_where($this->tables['enet_venues'], ['venue_id' => $venue])->row();

                $row[] = $query->venue_name; 

            }



            if (!empty($row)) {

                return implode(', ', $row);

            }

        }

        return '';

    }



    public function insert_monday_data($post_data) {

    	$item_name = $post_data['business_name'];  



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

    		CURLOPT_POSTFIELDS =>'{"query":"mutation {\\r\\n    create_item (board_id: '.$this->board['business_signup'].', item_name: \\"'.$item_name.'\\") {\\r\\n        id\\r\\n    }\\r\\n}","variables":{}}',

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

    				CURLOPT_POSTFIELDS =>'{"query":"mutation {\\r\\n    a1 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"text\\", value: \\"'.$post_data['email'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a2 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"text1\\", value: \\"'.$post_data['business_name'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a3 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"text6\\", value: \\"'.$post_data['phone'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a4 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"text9\\", value: \\"'.$post_data['address'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a5 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"text4\\", value: \\"'.$post_data['stadium'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a6 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"text3\\", value: \\"'.$post_data['business_type'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a7 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"text0\\", value: \\"'.$post_data['facilities'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a8 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"text97\\", value: \\"'.$post_data['website'].'\\") {\\r\\n        id\\r\\n    }\\r\\n    a9 : change_simple_column_value (board_id: '.$this->board['business_signup'].', item_id: '.$item_id.', column_id: \\"location\\", value: \\"'.$post_data['location'].'\\") {\\r\\n        id\\r\\n    }\\r\\n}","variables":{}}',

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

