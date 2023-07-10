<?php
/**
 * Name:    Ion Auth Model
 * Author:  Ben Edmunds
 *           ben.edmunds@gmail.com
 * @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization. This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 * @package    CodeIgniter-Ion-Auth
 * @author     Ben Edmunds
 * @link       http://github.com/benedmunds/CodeIgniter-Ion-Auth
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Ion Auth Model
 * @property Bcrypt $bcrypt The Bcrypt library
 * @property Ion_auth $ion_auth The Ion_auth library
 */
class Ion_auth_model extends CI_Model
{
	/**
	 * Max cookie lifetime constant
	 */
	const MAX_COOKIE_LIFETIME = 63072000; // 2 years = 60*60*24*365*2 = 63072000 seconds;

	/**
	 * Max password size constant
	 */
	const MAX_PASSWORD_SIZE_BYTES = 4096;
	/**
	 * Holds an array of tables used
	 *
	 * @var array
	 */
	public $tables = array();

	/**
	 * activation code
	 *
	 * @var string
	 */
	public $activation_code;

	/**
	 * forgotten password key
	 *
	 * @var string
	 */
	public $forgotten_password_code;

	/**
	 * new password
	 *
	 * @var string
	 */
	public $new_password;

	/**
	 * Identity
	 *
	 * @var string
	 */
	public $identity;

	/**
	 * Where
	 *
	 * @var array
	 */
	public $_ion_where = array();

	/**
	 * Select
	 *
	 * @var array
	 */
	public $_ion_select = array();

	/**
	 * Like
	 *
	 * @var array
	 */
	public $_ion_like = array();

	/**
	 * Limit
	 *
	 * @var string
	 */
	public $_ion_limit = NULL;

	/**
	 * Offset
	 *
	 * @var string
	 */
	public $_ion_offset = NULL;

	/**
	 * Order By
	 *
	 * @var string
	 */
	public $_ion_order_by = NULL;

	/**
	 * Order
	 *
	 * @var string
	 */
	public $_ion_order = NULL;

	/**
	 * Hooks
	 *
	 * @var object
	 */
	protected $_ion_hooks;

	/**
	 * Response
	 *
	 * @var string
	 */
	protected $response = NULL;

	/**
	 * message (uses lang file)
	 *
	 * @var string
	 */
	protected $messages;

	/**
	 * error message (uses lang file)
	 *
	 * @var string
	 */
	protected $errors;

	/**
	 * error start delimiter
	 *
	 * @var string
	 */
	protected $error_start_delimiter;

	/**
	 * error end delimiter
	 *
	 * @var string
	 */
	protected $error_end_delimiter;

	/**
	 * caching of users and their groups
	 *
	 * @var array
	 */
	public $_cache_user_in_group = array();

	/**
	 * caching of groups
	 *
	 * @var array
	 */
	protected $_cache_groups = array();

	/**
	 * Database object
	 *
	 * @var object
	 */
	protected $db;

	public function __construct()
	{
		$this->config->load('ion_auth', TRUE);
		$this->load->helper('cookie', 'date');
		$this->lang->load('ion_auth');

		// initialize the database
		$group_name = $this->config->item('database_group_name', 'ion_auth');

		if (empty($group_name)) 
		{
			// By default, use CI's db that should be already loaded
			$CI =& get_instance();
			$this->db = $CI->db;
		}
		else
		{
			// For specific group name, open a new specific connection
			$this->db = $this->load->database($group_name, TRUE, TRUE);
		}

		// initialize db tables data
		$this->tables = $this->config->item('tables', 'ion_auth');
		$this->table_sellers = 'sellers';
		$this->table_seller_login_attempts = 'seller_login_attempts';
		$this->table_buyers = 'buyers';
		$this->table_buyer_login_attempts = 'seller_login_attempts';

		// initialize data
		$this->identity_column = $this->config->item('identity', 'ion_auth');
		$this->store_salt = $this->config->item('store_salt', 'ion_auth');
		$this->salt_length = $this->config->item('salt_length', 'ion_auth');
		$this->join = $this->config->item('join', 'ion_auth');

		// initialize hash method options (Bcrypt)
		$this->hash_method = $this->config->item('hash_method', 'ion_auth');
		$this->default_rounds = $this->config->item('default_rounds', 'ion_auth');
		$this->random_rounds = $this->config->item('random_rounds', 'ion_auth');
		$this->min_rounds = $this->config->item('min_rounds', 'ion_auth');
		$this->max_rounds = $this->config->item('max_rounds', 'ion_auth');

		// initialize messages and error
		$this->messages    = array();
		$this->errors      = array();
		$delimiters_source = $this->config->item('delimiters_source', 'ion_auth');

		// load the error delimeters either from the config file or use what's been supplied to form validation
		if ($delimiters_source === 'form_validation')
		{
			// load in delimiters from form_validation
			// to keep this simple we'll load the value using reflection since these properties are protected
			$this->load->library('form_validation');
			$form_validation_class = new ReflectionClass("CI_Form_validation");

			$error_prefix = $form_validation_class->getProperty("_error_prefix");
			$error_prefix->setAccessible(TRUE);
			$this->error_start_delimiter = $error_prefix->getValue($this->form_validation);
			$this->message_start_delimiter = $this->error_start_delimiter;

			$error_suffix = $form_validation_class->getProperty("_error_suffix");
			$error_suffix->setAccessible(TRUE);
			$this->error_end_delimiter = $error_suffix->getValue($this->form_validation);
			$this->message_end_delimiter = $this->error_end_delimiter;
		}
		else
		{
			// use delimiters from config
			$this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
			$this->message_end_delimiter = $this->config->item('message_end_delimiter', 'ion_auth');
			$this->error_start_delimiter = $this->config->item('error_start_delimiter', 'ion_auth');
			$this->error_end_delimiter = $this->config->item('error_end_delimiter', 'ion_auth');
		}

		// initialize our hooks object
		$this->_ion_hooks = new stdClass;

		// load the bcrypt class if needed
		if ($this->hash_method == 'bcrypt')
		{
			if ($this->random_rounds)
			{
				$rand = rand($this->min_rounds,$this->max_rounds);
				$params = array('rounds' => $rand);
			}
			else
			{
				$params = array('rounds' => $this->default_rounds);
			}

			$params['salt_prefix'] = $this->config->item('salt_prefix', 'ion_auth');
			$this->load->library('bcrypt',$params);
		}

		$this->trigger_events('model_constructor');
	}

	public function hash_password($password, $salt = FALSE, $use_sha1_override = FALSE)
	{
		if (empty($password))
		{
			return FALSE;
		}

		// bcrypt
		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt')
		{
			return $this->bcrypt->hash($password);
		}


		if ($this->store_salt && $salt)
		{
			return sha1($password . $salt);
		}
		else
		{
			$salt = $this->salt();
			return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}
	}

	public function hash_password_db($id, $password, $use_sha1_override = FALSE)
	{
		if (empty($id) || empty($password))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('password, salt')
		                  ->where('id', $id)
		                  ->limit(1)
		                  ->order_by('id', 'desc')
		                  ->get($this->tables['users']);

		$hash_password_db = $query->row();

		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}

		// bcrypt
		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt')
		{
			if ($this->bcrypt->verify($password,$hash_password_db->password))
			{
				return TRUE;
			}

			return FALSE;
		}

		// sha1
		if ($this->store_salt)
		{
			$db_password = sha1($password . $hash_password_db->salt);
		}
		else
		{
			$salt = substr($hash_password_db->password, 0, $this->salt_length);

			$db_password =  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}

		if($db_password == $hash_password_db->password)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	public function hash_code($password)
	{
		return $this->hash_password($password, FALSE, TRUE);
	}

	public function salt()
	{
		$raw_salt_len = 16;

		$buffer = '';
		$buffer_valid = FALSE;

		if (function_exists('random_bytes'))
		{
			$buffer = random_bytes($raw_salt_len);
			if ($buffer)
			{
				$buffer_valid = TRUE;
			}
		}

		if (!$buffer_valid && function_exists('mcrypt_create_iv') && !defined('PHALANGER'))
		{
			$buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
			if ($buffer)
			{
				$buffer_valid = TRUE;
			}
		}

		if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes'))
		{
			$buffer = openssl_random_pseudo_bytes($raw_salt_len);
			if ($buffer)
			{
				$buffer_valid = TRUE;
			}
		}

		if (!$buffer_valid && @is_readable('/dev/urandom'))
		{
			$f = fopen('/dev/urandom', 'r');
			$read = strlen($buffer);
			while ($read < $raw_salt_len)
			{
				$buffer .= fread($f, $raw_salt_len - $read);
				$read = strlen($buffer);
			}
			fclose($f);
			if ($read >= $raw_salt_len)
			{
				$buffer_valid = TRUE;
			}
		}

		if (!$buffer_valid || strlen($buffer) < $raw_salt_len)
		{
			$bl = strlen($buffer);
			for ($i = 0; $i < $raw_salt_len; $i++)
			{
				if ($i < $bl)
				{
					$buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
				}
				else
				{
					$buffer .= chr(mt_rand(0, 255));
				}
			}
		}

		$salt = $buffer;

		// encode string with the Base64 variant used by crypt
		$base64_digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
		$bcrypt64_digits = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$base64_string = base64_encode($salt);
		$salt = strtr(rtrim($base64_string, '='), $base64_digits, $bcrypt64_digits);

		$salt = substr($salt, 0, $this->salt_length);

		return $salt;
	}

	public function activate($id, $code = FALSE)
	{
		$this->trigger_events('pre_activate');

		if ($code !== FALSE)
		{
			$query = $this->db->select($this->identity_column)
			                  ->where('activation_code', $code)
			                  ->where('id', $id)
			                  ->limit(1)
			                  ->order_by('id', 'desc')
			                  ->get($this->tables['users']);

			$query->row();

			if ($query->num_rows() !== 1)
			{
				$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
				$this->set_error('activate_unsuccessful');
				return FALSE;
			}

			$data = array(
			    'activation_code' => NULL,
			    'active'          => 1
			);

			$this->trigger_events('extra_where');
			$this->db->update($this->tables['users'], $data, array('id' => $id));
		}
		else
		{
			$data = array(
			    'activation_code' => NULL,
			    'active'          => 1
			);

			$this->trigger_events('extra_where');
			$this->db->update($this->tables['users'], $data, array('id' => $id));
		}

		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->trigger_events(array('post_activate', 'post_activate_successful'));
			$this->set_message('activate_successful');
		}
		else
		{
			$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
			$this->set_error('activate_unsuccessful');
		}

		return $return;
	}

	public function deactivate($id = NULL) {
		$this->trigger_events('deactivate');

		if (!isset($id))
		{
			$this->set_error('deactivate_unsuccessful');
			return FALSE;
		}
		else if ($this->ion_auth->logged_in() && $this->user()->row()->id == $id)
		{
			$this->set_error('deactivate_current_user_unsuccessful');
			return FALSE;
		}

		$activation_code = sha1(md5(microtime()));
		$this->activation_code = $activation_code;

		$data = array(
		    'activation_code' => $activation_code,
		    'active'          => 0
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users'], $data, array('id' => $id));

		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->set_message('deactivate_successful');
		}
		else
		{
			$this->set_error('deactivate_unsuccessful');
		}

		return $return;
	}

	public function clear_forgotten_password_code($code) {

		if (empty($code))
		{
			return FALSE;
		}

		$this->db->where('forgotten_password_code', $code);

		if ($this->db->count_all_results($this->tables['users']) > 0)
		{
			$data = array(
			    'forgotten_password_code' => NULL,
			    'forgotten_password_time' => NULL
			);

			$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));

			return TRUE;
		}

		return FALSE;
	}

	public function reset_password($identity, $new) {
		$this->trigger_events('pre_change_password');

		if (!$this->identity_check($identity)) {
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('id, password, salt')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
		                  ->order_by('id', 'desc')
		                  ->get($this->tables['users']);

		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$result = $query->row();

		$new = $this->hash_password($new, $result->salt);

		// store the new password and reset the remember code so all remembered instances have to re-login
		// also clear the forgotten password code
		$data = array(
		    'password' => $new,
		    'remember_code' => NULL,
		    'forgotten_password_code' => NULL,
		    'forgotten_password_time' => NULL,
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));

		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_successful'));
			$this->set_message('password_change_successful');
		}
		else
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
		}

		return $return;
	}

	public function change_password($identity, $old, $new) {
		$this->trigger_events('pre_change_password');

		$this->trigger_events('extra_where');

		$query = $this->db->select('id, password, salt')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
		                  ->order_by('id', 'desc')
		                  ->get($this->tables['users']);
		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$user = $query->row();

		$old_password_matches = $this->hash_password_db($user->id, $old);

		if ($old_password_matches === TRUE)
		{
			// store the new password and reset the remember code so all remembered instances have to re-login
			$hashed_new_password  = $this->hash_password($new, $user->salt);
			$data = array(
			    'password' => $hashed_new_password,
			    'remember_code' => NULL,
			);

			$this->trigger_events('extra_where');

			$successfully_changed_password_in_db = $this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));
			if ($successfully_changed_password_in_db)
			{
				$this->trigger_events(array('post_change_password', 'post_change_password_successful'));
				$this->set_message('password_change_successful');
			}
			else
			{
				$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
				$this->set_error('password_change_unsuccessful');
			}

			return $successfully_changed_password_in_db;
		}
		
		$this->set_error('password_change_unsuccessful');
		return FALSE;
	}

	public function check_password($old, $id)
	{
		$query = $this->db->select('id, password,email')
		->where('id', $id)
		->limit(1)
		->order_by('id', 'desc')
		->get($this->tables['users']);

		if ($query->num_rows() !== 1)
		{
			return 0;
		}

		$user = $query->row();
		
		if ($this->verify_password($old, $user->password, NULL))
		{
			return 1;
		}else{
			return 2;
		}
	}

	public function username_check($username = ''){
		$this->trigger_events('username_check');

		if (empty($username))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		return $this->db->where('username', $username)
						->limit(1)
						->count_all_results($this->tables['users']) > 0;
	}
	


	public function email_check($email = ''){
		$this->trigger_events('email_check');

		if (empty($email))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		return $this->db->where('email', $email)
						->limit(1)
						->count_all_results($this->tables['users']) > 0;
	}

	public function identity_check($identity = ''){
		$this->trigger_events('identity_check');

		if (empty($identity))
		{
			return FALSE;
		}

		return $this->db->where($this->identity_column, $identity)
						->limit(1)
						->count_all_results($this->tables['users']) > 0;
	}

	public function forgotten_password($identity){
		if (empty($identity))
		{
			$this->trigger_events(['post_forgotten_password', 'post_forgotten_password_unsuccessful']);
			return FALSE;
		}

		// Generate random token: smaller size because it will be in the URL
		$token = $this->_generate_selector_validator_couple(20, 80);

		$update = [
			'forgotten_password_selector' => $token->selector,
			'forgotten_password_code' => $token->validator_hashed,
			'forgotten_password_time' => time()
		];

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users'], $update, [$this->identity_column => $identity]);

		if ($this->db->affected_rows() === 1)
		{
			$this->trigger_events(['post_forgotten_password', 'post_forgotten_password_successful']);
			return $token->user_code;
		}
		else
		{
			$this->trigger_events(['post_forgotten_password', 'post_forgotten_password_unsuccessful']);
			return FALSE;
		}
	}

	public function get_user_by_forgotten_password_code($user_code){
		// Retrieve the token object from the code
		$token = $this->_retrieve_selector_validator_couple($user_code);

		if($token) {
			// Retrieve the user according to this selector
			$user = $this->where('forgotten_password_selector', $token->selector)->users()->row();

			if ($user)
			{
				// Check the hash against the validator
				if ($this->verify_password($token->validator, $user->forgotten_password_code))
				{
					return $user;
				}
			}
		}

		return FALSE;
	}

	protected function _generate_selector_validator_couple($selector_size = 40, $validator_size = 128){
		// The selector is a simple token to retrieve the user
		$selector = $this->_random_token($selector_size);

		// The validator will strictly validate the user and should be more complex
		$validator = $this->_random_token($validator_size);

		// The validator is hashed for storing in DB (avoid session stealing in case of DB leaked)
		$validator_hashed = $this->hash_password($validator);

		// The code to be used user-side
		$user_code = "$selector.$validator";

		return (object) [
			'selector' => $selector,
			'validator_hashed' => $validator_hashed,
			'user_code' => $user_code,
		];
	}

	protected function _random_token($result_length = 32){
		if(!isset($result_length) || intval($result_length) <= 8 ){
			$result_length = 32;
		}

		// Try random_bytes: PHP 7
		if (function_exists('random_bytes')) {
			return bin2hex(random_bytes($result_length / 2));
		}

		// Try mcrypt
		if (function_exists('mcrypt_create_iv')) {
			return bin2hex(mcrypt_create_iv($result_length / 2, MCRYPT_DEV_URANDOM));
		}

		// Try openssl
		if (function_exists('openssl_random_pseudo_bytes')) {
			return bin2hex(openssl_random_pseudo_bytes($result_length / 2));
		}

		// No luck!
		return FALSE;
	}

	public function forgotten_password_complete($code, $salt = FALSE){
		$this->trigger_events('pre_forgotten_password_complete');

		if (empty($code))
		{
			$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
			return FALSE;
		}

		$profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if ($profile)
		{

			if ($this->config->item('forgot_password_expiration', 'ion_auth') > 0)
			{
				//Make sure it isn't expired
				$expiration = $this->config->item('forgot_password_expiration', 'ion_auth');
				if (time() - $profile->forgotten_password_time > $expiration)
				{
					//it has expired
					$this->set_error('forgot_password_expired');
					$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
					return FALSE;
				}
			}

			$password = $this->salt();

			$data = array(
				'password' => $this->hash_password($password, $salt),
				'forgotten_password_code' => NULL,
				'active' => 1,
			);

			$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));

			$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_successful'));
			return $password;
		}

		$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
		return FALSE;
	}

	
	protected function _retrieve_selector_validator_couple($user_code){
		// Check code
		if ($user_code)
		{
			$tokens = explode('.', $user_code);

			// Check tokens
			if (count($tokens) === 2)
			{
				return (object) [
					'selector' => $tokens[0],
					'validator' => $tokens[1]
				];
			}
		}

		return FALSE;
	}

	
	public function verify_password($password, $hash_password_db, $identity = NULL){
		// Check for empty id or password, or password containing null char, or password above limit
		// Null char may pose issue: http://php.net/manual/en/function.password-hash.php#118603
		// Long password may pose DOS issue (note: strlen gives size in bytes and not in multibyte symbol)
		if (empty($password) || empty($hash_password_db) || strpos($password, "\0") !== FALSE
			|| strlen($password) > self::MAX_PASSWORD_SIZE_BYTES)
		{
			return FALSE;
		}

		// password_hash always starts with $
		if (strpos($hash_password_db, '$') === 0)
		{
			return password_verify($password, $hash_password_db);
		}
		else
		{
			// Handle legacy SHA1 @TODO to delete in later revision
			return $this->_password_verify_sha1_legacy($identity, $password, $hash_password_db);
		}
	}

	

	public function register($identity, $password, $email, $additional_data = array(), $groups = array()){
		$this->trigger_events('pre_register');

		$manual_activation = $this->config->item('manual_activation', 'ion_auth');

		if ($this->identity_check($identity))
		{
			$this->set_error('account_creation_duplicate_identity');
			return FALSE;
		}
		else if (!$this->config->item('default_group', 'ion_auth') && empty($groups))
		{
			$this->set_error('account_creation_missing_default_group');
			return FALSE;
		}

		// check if the default set in config exists in database
		$query = $this->db->get_where($this->tables['groups'], array('name' => $this->config->item('default_group', 'ion_auth')), 1)->row();
		if (!isset($query->id) && empty($groups))
		{
			$this->set_error('account_creation_invalid_default_group');
			return FALSE;
		}

		// capture default group details
		$default_group = $query;

		// IP Address
		$ip_address = $this->_prepare_ip($this->input->ip_address());
		$salt = $this->store_salt ? $this->salt() : FALSE;
		$password = $this->hash_password($password, $salt);
		$activation_code = sha1(md5(microtime()));

		// Users table.
		$data = array(
			$this->identity_column => $identity,
			'username' => $identity,
			'password' => $password,
			'email' => $email,
			'ip_address' => $ip_address,
			'created_on' => time(),
			'active' => ($manual_activation === FALSE ? 1 : 0)
		);

		if ($this->store_salt)
		{
			$data['salt'] = $salt;
		}

		if (array_key_exists('facebook_id', $additional_data) || array_key_exists('google_id', $additional_data) || array_key_exists('social_id', $additional_data)) {
            if ($social_activation == true) {
                $data['active'] = 0;
                $data['activation_code'] = $activation_code;
            } else {
                $data['active'] = 1;
            }
        } else {
            if ($manual_activation == true) {
                $data['active'] = 0;
                $data['activation_code'] = $activation_code;
            } else {
                $data['active'] = 1;
            }
        }

		$user_data = array_merge($this->_filter_data($this->tables['users'], $additional_data), $data);

		$this->trigger_events('extra_set');

		$this->db->insert($this->tables['users'], $user_data);

		$id = $this->db->insert_id($this->tables['users'] . '_id_seq');

		// add in groups array if it doesn't exists and stop adding into default group if default group ids are set
		if (isset($default_group->id) && empty($groups))
		{
			$groups[] = $default_group->id;
		}

		if (!empty($groups))
		{
			// add to groups
			foreach ($groups as $group)
			{
				$this->add_to_group($group, $id);
			}
		}

		$this->trigger_events('post_register');

		if (isset($id)) {
            $register = array(
                'success' => 1,
                'id' => $id,
                'activation_code' => $activation_code
            );
        } else {
            $register = array(
                'success' => 0
            );
        }

        return $register;
	}

	public function login($identity, $password, $remember=FALSE){
		$this->trigger_events('pre_login');

		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select($this->identity_column . ', email, id, password, active, last_login,first_name,last_name, role_id')
						  ->where($this->identity_column, $identity)
						  ->limit(1)
						  ->order_by('id', 'desc')
						  ->get($this->tables['users']);

		if ($this->is_max_login_attempts_exceeded($identity))
		{
			// Hash something anyway, just to take up time
			$this->hash_password($password);

			$this->trigger_events('post_login_unsuccessful');
			$this->set_error('login_timeout');

			return FALSE;
		}

		if ($query->num_rows() === 1)
		{
			$user = $query->row();

			$password = $this->hash_password_db($user->id, $password);

			if ($password === TRUE)
			{
				if ($user->active == 0)
				{
					$this->trigger_events('post_login_unsuccessful');
					$this->set_error('login_unsuccessful_not_active');

					return FALSE;
				}

				$this->set_session($user);

				$this->update_last_login($user->id);

				$this->clear_login_attempts($identity);

				if ($remember && $this->config->item('remember_users', 'ion_auth'))
				{
					$this->remember_user($user->id);
				}
                
				// Regenerate the session (for security purpose: to avoid session fixation)
				$this->_regenerate_session();

				$this->trigger_events(array('post_login', 'post_login_successful'));
				$this->set_message('login_successful');

				return TRUE;
			}
		}

		// Hash something anyway, just to take up time
		$this->hash_password($password);

		$this->increase_login_attempts($identity);

		$this->trigger_events('post_login_unsuccessful');
		$this->set_error('login_unsuccessful');

		return FALSE;
	}

	public function set_verification_session($user)
	{
		$this->trigger_events('pre_set_session');

		$session_data = [
			'identity'             => $user->{$this->identity_column},
			$this->identity_column => $user->{$this->identity_column},
			'email'                => $user->email,
			// 'first_name'           => $user->first_name,
			// 'last_name'            => $user->last_name,
		    'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id
		    'old_last_login'       => $user->last_login,
		    'restaurant_name'       => $user->restaurant_name,
		    'restaurant_description'       => $user->restaurant_description,
		    'restaurant_address'       => $user->restaurant_address,
		    'restaurant_latitude'       => $user->restaurant_latitude,
		    'restaurant_longitude'       => $user->restaurant_longitude,
		    'contact_person_mobile'       => $user->contact_person_mobile,
		    'delivery'       => $user->delivery,
		    'takeaway'       => $user->takeaway,
		    'unique_id'      => $user->unique_id,
		    'last_check'           => time(),
		];

		$this->session->set_userdata($session_data);

		$this->trigger_events('post_set_session');

		return TRUE;
	}

	public function clear_remember_code($identity) {

		if (empty($identity))
		{
			return FALSE;
		}

		$data = [
			'remember_selector' => NULL,
			'remember_code' => NULL
		];

		$this->db->update($this->tables['users'], $data, [$this->identity_column => $identity]);

		return TRUE;
	}

	public function rehash_password_if_needed($hash, $identity, $password)
	{
		$algo = $this->_get_hash_algo();
		$params = $this->_get_hash_parameters($identity);

		if ($algo !== FALSE && $params !== FALSE)
		{
			if (password_needs_rehash($hash, $algo, $params))
			{
				if ($this->_set_password_db($identity, $password))
				{
					$this->trigger_events(['rehash_password', 'rehash_password_successful']);
				}
				else
				{
					$this->trigger_events(['rehash_password', 'rehash_password_unsuccessful']);
				}
			}
		}
	}

	protected function _get_hash_algo()
	{
		$algo = FALSE;
		switch ($this->hash_method)
		{
			case 'bcrypt':
			$algo = PASSWORD_BCRYPT;
			break;

			case 'argon2':
			$algo = PASSWORD_ARGON2I;
			break;

			default:
				// Do nothing
		}

		return $algo;
	}


	protected function _get_hash_parameters($identity = NULL)
	{
		// Check if user is administrator or not
		$is_admin = FALSE;
		if ($identity)
		{
			$user_id = $this->get_user_id_from_identity($identity);
			if ($user_id && $this->in_group($this->config->item('admin_group', 'ion_auth'), $user_id))
			{
				$is_admin = TRUE;
			}
		}

		$params = FALSE;
		switch ($this->hash_method)
		{
			case 'bcrypt':
			$params = [
				'cost' => $is_admin ? $this->config->item('bcrypt_admin_cost', 'ion_auth')
				: $this->config->item('bcrypt_default_cost', 'ion_auth')
			];
			break;

			case 'argon2':
			$params = $is_admin ? $this->config->item('argon2_admin_params', 'ion_auth')
			: $this->config->item('argon2_default_params', 'ion_auth');
			break;

			default:
				// Do nothing
		}

		return $params;
	}

	public function get_user_id_from_identity($identity = '')
	{
		if (empty($identity))
		{
			return FALSE;
		}

		$query = $this->db->select('id')
		->where($this->identity_column, $identity)
		->limit(1)
		->get($this->tables['users']);

		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}

		$user = $query->row();

		return $user->id;
	}

	public function login_social($social_id) {
        $this->trigger_events('pre_login');

        $this->trigger_events('extra_where');

        $query = $this->db->select('id,activation_code, active, email, id, password, active, last_login, first_name, last_name,username, pincode, sport_id, team_id, first_time, dob')
                ->where('social_id', $social_id)
                ->limit(1)
                ->order_by('id', 'desc')
                ->get($this->tables['users']);

        if ($query->num_rows() === 1) {
            $user = $query->row();
            // Regenerate the session (for security purpose: to avoid session fixation)
        	$this->session->sess_regenerate(FALSE);
            $this->update_last_login($user->id);
            if ($user->active == 0 && $user->activation_code != NULL) {
                $this->trigger_events('post_login_unsuccessful');
                $this->set_error('login_unsuccessful_not_active');

                $response = array(
                    'success' => 0,
                    'message' => 'You are not activated user. Please confirm activation link from your email'
                );
                return $response;
            }

            $this->update_last_login($user->id);

            $this->trigger_events(array('post_login', 'post_login_successful'));
            $this->set_message('login_successful');

            $response = array(
                'success' => 1,
                'data' => $user
            );
            return $response;
        } else {
            $response = array(
                'success' => 2,
                'message' => 'That account doesn\'t exists'
            );
            return $response;
        }
    }

    public function social_register($identity, $password, $email, $additional_data = array(), $groups = array()) {
        $this->trigger_events('pre_register');

        $manual_activation = $this->config->item('manual_activation', 'ion_auth');
        $social_activation = $this->config->item('social_activation', 'ion_auth');


        // check if the default set in config exists in database
        $query = $this->db->get_where($this->tables['groups'], array('name' => $this->config->item('default_group', 'ion_auth')), 1)->row();
        if (!isset($query->id) && empty($groups)) {
            $this->set_error('account_creation_invalid_default_group');
            return FALSE;
        }

        // capture default group details
        $default_group = $query;

        // IP Address
        $ip_address = $this->_prepare_ip($this->input->ip_address());
        $salt = $this->store_salt ? $this->salt() : FALSE;
        $activation_code = sha1(md5(microtime()));
        $password = $this->hash_password($password, $salt);

        // Users table.
        $data = array(
            $this->identity_column => $identity,
            'password' => $password,
            'email' => $email,
            'ip_address' => $ip_address,
            'created_on' => time()
        );

        if ($this->store_salt) {
            $data['salt'] = $salt;
        }

        if (array_key_exists('facebook_id', $additional_data) || array_key_exists('google_id', $additional_data) || array_key_exists('social_id', $additional_data)) {
            if ($social_activation == true) {
                $data['active'] = 0;
                $data['activation_code'] = $activation_code;
            } else {
                $data['active'] = 1;
            }
        } else {
            if ($manual_activation == true) {
                $data['active'] = 0;
                $data['activation_code'] = $activation_code;
            } else {
                $data['active'] = 1;
            }
        }

        // filter out any data passed that doesnt have a matching column in the users table
        // and merge the set user data and the additional data
        $user_data = array_merge($this->_filter_data($this->tables['users'], $additional_data), $data);

        $this->trigger_events('extra_set');

        $this->db->insert($this->tables['users'], $user_data);

        $id = $this->db->insert_id();
        // add in groups array if it doesn't exists and stop adding into default group if default group ids are set
        if (isset($default_group->id) && empty($groups)) {
            $groups[] = $default_group->id;
        }

        if (!empty($groups)) {
            // add to groups
            foreach ($groups as $group) {
                $this->add_to_group($group, $id);
            }
        }

        $this->trigger_events('post_register');
        if (isset($id)) {
            $register = array(
                'success' => 1,
                'id' => $id,
                'activation_code' => $activation_code
            );
        } else {
            $register = array(
                'success' => 0
            );
        }
        return $register;
    }


	public function recheck_session()
	{
		$recheck = (NULL !== $this->config->item('recheck_timer', 'ion_auth')) ? $this->config->item('recheck_timer', 'ion_auth') : 0;

		if ($recheck !== 0)
		{
			$last_login = $this->session->userdata('last_check');
			if ($last_login + $recheck < time())
			{
				$query = $this->db->select('id')
								  ->where(array($this->identity_column => $this->session->userdata('identity'), 'active' => '1'))
								  ->limit(1)
								  ->order_by('id', 'desc')
								  ->get($this->tables['users']);
				if ($query->num_rows() === 1)
				{
					$this->session->set_userdata('last_check', time());
				}
				else
				{
					$this->trigger_events('logout');

					$identity = $this->config->item('identity', 'ion_auth');

					if (substr(CI_VERSION, 0, 1) == '2')
					{
						$this->session->unset_userdata(array($identity => '', 'id' => '', 'user_id' => ''));
					}
					else
					{
						$this->session->unset_userdata(array($identity, 'id', 'user_id'));
					}
					return FALSE;
				}
			}
		}

		return (bool)$this->session->userdata('identity');
	}

	public function is_max_login_attempts_exceeded($identity, $ip_address = NULL)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$max_attempts = $this->config->item('maximum_login_attempts', 'ion_auth');
			if ($max_attempts > 0)
			{
				$attempts = $this->get_attempts_num($identity, $ip_address);
				return $attempts >= $max_attempts;
			}
		}
		return FALSE;
	}

	public function get_attempts_num($identity, $ip_address = NULL)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$this->db->select('1', FALSE);
			$this->db->where('login', $identity);
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
			{
				if (!isset($ip_address))
				{
					$ip_address = $this->_prepare_ip($this->input->ip_address());
				}
				$this->db->where('ip_address', $ip_address);
			}
			$this->db->where('time >', time() - $this->config->item('lockout_time', 'ion_auth'), FALSE);
			$qres = $this->db->get($this->tables['login_attempts']);
			return $qres->num_rows();
		}
		return 0;
	}

	public function is_time_locked_out($identity, $ip_address = NULL)
	{
		return $this->is_max_login_attempts_exceeded($identity, $ip_address);
	}



	public function get_last_attempt_time($identity, $ip_address = NULL)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$this->db->select('time');
			$this->db->where('login', $identity);
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
			{
				if (!isset($ip_address))
				{
					$ip_address = $this->_prepare_ip($this->input->ip_address());
				}
				$this->db->where('ip_address', $ip_address);
			}
			$this->db->order_by('id', 'desc');
			$qres = $this->db->get($this->tables['login_attempts'], 1);

			if ($qres->num_rows() > 0)
			{
				return $qres->row()->time;
			}
		}

		return 0;
	}


	public function get_last_attempt_ip($identity)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth') && $this->config->item('track_login_ip_address', 'ion_auth'))
		{
			$this->db->select('ip_address');
			$this->db->where('login', $identity);
			$this->db->order_by('id', 'desc');
			$qres = $this->db->get($this->tables['login_attempts'], 1);

			if ($qres->num_rows() > 0)
			{
				return $qres->row()->ip_address;
			}
		}

		return '';
	}

	public function increase_login_attempts($identity)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$data = array('ip_address' => '', 'login' => $identity, 'time' => time());
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
			{
				$data['ip_address'] = $this->_prepare_ip($this->input->ip_address());
			}
			return $this->db->insert($this->tables['login_attempts'], $data);
		}
		return FALSE;
	}

	public function clear_login_attempts($identity, $old_attempts_expire_period = 86400, $ip_address = NULL)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			// Make sure $old_attempts_expire_period is at least equals to lockout_time
			$old_attempts_expire_period = max($old_attempts_expire_period, $this->config->item('lockout_time', 'ion_auth'));

			$this->db->where('login', $identity);
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
			{
				if (!isset($ip_address))
				{
					$ip_address = $this->_prepare_ip($this->input->ip_address());
				}
				$this->db->where('ip_address', $ip_address);
			}
			// Purge obsolete login attempts
			$this->db->or_where('time <', time() - $old_attempts_expire_period, FALSE);

			return $this->db->delete($this->tables['login_attempts']);
		}
		return FALSE;
	}

	public function limit($limit)
	{
		$this->trigger_events('limit');
		$this->_ion_limit = $limit;

		return $this;
	}


	public function offset($offset)
	{
		$this->trigger_events('offset');
		$this->_ion_offset = $offset;

		return $this;
	}


	public function where($where, $value = NULL)
	{
		$this->trigger_events('where');

		if (!is_array($where))
		{
			$where = array($where => $value);
		}

		array_push($this->_ion_where, $where);

		return $this;
	}


	public function like($like, $value = NULL, $position = 'both')
	{
		$this->trigger_events('like');

		array_push($this->_ion_like, array(
			'like'     => $like,
			'value'    => $value,
			'position' => $position
		));

		return $this;
	}


	public function select($select)
	{
		$this->trigger_events('select');

		$this->_ion_select[] = $select;

		return $this;
	}


	public function order_by($by, $order='desc')
	{
		$this->trigger_events('order_by');

		$this->_ion_order_by = $by;
		$this->_ion_order    = $order;

		return $this;
	}

	public function row()
	{
		$this->trigger_events('row');

		$row = $this->response->row();

		return $row;
	}


	public function row_array()
	{
		$this->trigger_events(array('row', 'row_array'));

		$row = $this->response->row_array();

		return $row;
	}


	public function result()
	{
		$this->trigger_events('result');

		$result = $this->response->result();

		return $result;
	}

	public function result_array()
	{
		$this->trigger_events(array('result', 'result_array'));

		$result = $this->response->result_array();

		return $result;
	}


	public function num_rows()
	{
		$this->trigger_events(array('num_rows'));

		$result = $this->response->num_rows();

		return $result;
	}


	public function users($groups = NULL)
	{
		$this->trigger_events('users');

		if (isset($this->_ion_select) && !empty($this->_ion_select))
		{
			foreach ($this->_ion_select as $select)
			{
				$this->db->select($select);
			}

			$this->_ion_select = array();
		}
		else
		{
			// default selects
			$this->db->select(array(
			    $this->tables['users'].'.*',
			    $this->tables['users'].'.id as id',
			    $this->tables['users'].'.id as user_id'
			));
		}

		// filter by group id(s) if passed
		if (isset($groups))
		{
			// build an array if only one group was passed
			if (!is_array($groups))
			{
				$groups = Array($groups);
			}

			// join and then run a where_in against the group ids
			if (isset($groups) && !empty($groups))
			{
				$this->db->distinct();
				$this->db->join(
				    $this->tables['users_groups'],
				    $this->tables['users_groups'].'.'.$this->join['users'].'='.$this->tables['users'].'.id',
				    'inner'
				);
			}

			// verify if group name or group id was used and create and put elements in different arrays
			$group_ids = array();
			$group_names = array();
			foreach($groups as $group)
			{
				if(is_numeric($group)) $group_ids[] = $group;
				else $group_names[] = $group;
			}
			$or_where_in = (!empty($group_ids) && !empty($group_names)) ? 'or_where_in' : 'where_in';
			// if group name was used we do one more join with groups
			if(!empty($group_names))
			{
				$this->db->join($this->tables['groups'], $this->tables['users_groups'] . '.' . $this->join['groups'] . ' = ' . $this->tables['groups'] . '.id', 'inner');
				$this->db->where_in($this->tables['groups'] . '.name', $group_names);
			}
			if(!empty($group_ids))
			{
				$this->db->{$or_where_in}($this->tables['users_groups'].'.'.$this->join['groups'], $group_ids);
			}
		}

		$this->trigger_events('extra_where');

		// run each where that was passed
		if (isset($this->_ion_where) && !empty($this->_ion_where))
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}

			$this->_ion_where = array();
		}

		if (isset($this->_ion_like) && !empty($this->_ion_like))
		{
			foreach ($this->_ion_like as $like)
			{
				$this->db->or_like($like['like'], $like['value'], $like['position']);
			}

			$this->_ion_like = array();
		}

		if (isset($this->_ion_limit) && isset($this->_ion_offset))
		{
			$this->db->limit($this->_ion_limit, $this->_ion_offset);

			$this->_ion_limit  = NULL;
			$this->_ion_offset = NULL;
		}
		else if (isset($this->_ion_limit))
		{
			$this->db->limit($this->_ion_limit);

			$this->_ion_limit  = NULL;
		}

		// set the order
		if (isset($this->_ion_order_by) && isset($this->_ion_order))
		{
			$this->db->order_by($this->_ion_order_by, $this->_ion_order);

			$this->_ion_order    = NULL;
			$this->_ion_order_by = NULL;
		}

		$this->response = $this->db->get($this->tables['users']);

		return $this;
	}

	public function user($id = NULL)
	{
		$this->trigger_events('user');

		// if no id was passed use the current users id
		$id = isset($id) ? $id : $this->session->userdata('user_id');

		$this->limit(1);
		$this->order_by($this->tables['users'].'.id', 'desc');
		$this->where($this->tables['users'].'.id', $id);

		$this->users();

		return $this;
	}

	public function get_users_groups($id = FALSE)
	{
		$this->trigger_events('get_users_group');

		// if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');

		return $this->db->select($this->tables['users_groups'].'.'.$this->join['groups'].' as id, '.$this->tables['groups'].'.name, '.$this->tables['groups'].'.description')
		                ->where($this->tables['users_groups'].'.'.$this->join['users'], $id)
		                ->join($this->tables['groups'], $this->tables['users_groups'].'.'.$this->join['groups'].'='.$this->tables['groups'].'.id')
		                ->get($this->tables['users_groups']);
	}


	public function add_to_group($group_ids, $user_id = FALSE)
	{
		$this->trigger_events('add_to_group');

		// if no id was passed use the current users id
		$user_id || $user_id = $this->session->userdata('user_id');

		if(!is_array($group_ids))
		{
			$group_ids = array($group_ids);
		}

		$return = 0;

		// Then insert each into the database
		foreach ($group_ids as $group_id)
		{
			// Cast to float to support bigint data type
			if ($this->db->insert(
								  $this->tables['users_groups'],
								  array(
								  	$this->join['groups'] => (float)$group_id,
									$this->join['users']  => (float)$user_id
								  )
								)
			)
			{
				if (isset($this->_cache_groups[$group_id]))
				{
					$group_name = $this->_cache_groups[$group_id];
				}
				else
				{
					$group = $this->group($group_id)->result();
					$group_name = $group[0]->name;
					$this->_cache_groups[$group_id] = $group_name;
				}
				$this->_cache_user_in_group[$user_id][$group_id] = $group_name;

				// Return the number of groups added
				$return++;
			}
		}

		return $return;
	}


	public function remove_from_group($group_ids = FALSE, $user_id = FALSE)
	{
		$this->trigger_events('remove_from_group');

		// user id is required
		if (empty($user_id))
		{
			return FALSE;
		}

		// if group id(s) are passed remove user from the group(s)
		if (!empty($group_ids))
		{
			if (!is_array($group_ids))
			{
				$group_ids = array($group_ids);
			}

			foreach ($group_ids as $group_id)
			{
				// Cast to float to support bigint data type
				$this->db->delete(
					$this->tables['users_groups'],
					array($this->join['groups'] => (float)$group_id, $this->join['users'] => (float)$user_id)
				);
				if (isset($this->_cache_user_in_group[$user_id]) && isset($this->_cache_user_in_group[$user_id][$group_id]))
				{
					unset($this->_cache_user_in_group[$user_id][$group_id]);
				}
			}

			$return = TRUE;
		}
		// otherwise remove user from all groups
		else
		{
			// Cast to float to support bigint data type
			if ($return = $this->db->delete($this->tables['users_groups'], array($this->join['users'] => (float)$user_id)))
			{
				$this->_cache_user_in_group[$user_id] = array();
			}
		}
		return $return;
	}


	public function groups()
	{
		$this->trigger_events('groups');

		// run each where that was passed
		if (isset($this->_ion_where) && !empty($this->_ion_where))
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}
			$this->_ion_where = array();
		}

		if (isset($this->_ion_limit) && isset($this->_ion_offset))
		{
			$this->db->limit($this->_ion_limit, $this->_ion_offset);

			$this->_ion_limit  = NULL;
			$this->_ion_offset = NULL;
		}
		else if (isset($this->_ion_limit))
		{
			$this->db->limit($this->_ion_limit);

			$this->_ion_limit  = NULL;
		}

		// set the order
		if (isset($this->_ion_order_by) && isset($this->_ion_order))
		{
			$this->db->order_by($this->_ion_order_by, $this->_ion_order);
		}

		$this->response = $this->db->get($this->tables['groups']);

		return $this;
	}


	public function group($id = NULL)
	{
		$this->trigger_events('group');

		if (isset($id))
		{
			$this->where($this->tables['groups'].'.id', $id);
		}

		$this->limit(1);
		$this->order_by('id', 'desc');

		return $this->groups();
	}


	public function update($id, array $data)
	{
		$this->trigger_events('pre_update_user');

		$user = $this->user($id)->row();

		$this->db->trans_begin();

		if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column])
		{
			$this->db->trans_rollback();
			$this->set_error('account_creation_duplicate_identity');

			$this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
			$this->set_error('update_unsuccessful');

			return FALSE;
		}

		// Filter the data passed
		$data = $this->_filter_data($this->tables['users'], $data);

		if (array_key_exists($this->identity_column, $data) || array_key_exists('password', $data) || array_key_exists('email', $data))
		{
			if (array_key_exists('password', $data))
			{
				if( ! empty($data['password']))
				{
					$data['password'] = $this->hash_password($data['password'], $user->salt);
				}
				else
				{
					// unset password so it doesn't effect database entry if no password passed
					unset($data['password']);
				}
			}
		}

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users'], $data, array('id' => $user->id));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
			$this->set_error('update_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->trigger_events(array('post_update_user', 'post_update_user_successful'));
		$this->set_message('update_successful');
		return TRUE;
	}

	public function delete_user($id)
	{
		$this->trigger_events('pre_delete_user');

		$this->db->trans_begin();

		// remove user from groups
		$this->remove_from_group(NULL, $id);

		// delete user from users table should be placed after remove from group
		$this->db->delete($this->tables['users'], array('id' => $id));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->trigger_events(array('post_delete_user', 'post_delete_user_unsuccessful'));
			$this->set_error('delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->trigger_events(array('post_delete_user', 'post_delete_user_successful'));
		$this->set_message('delete_successful');
		return TRUE;
	}


	public function update_last_login($id)
	{
		$this->trigger_events('update_last_login');

		$this->load->helper('date');

		$this->trigger_events('extra_where');

		$this->db->update($this->tables['users'], array('last_login' => time()), array('id' => $id));

		return $this->db->affected_rows() == 1;
	}

	public function set_lang($lang = 'en')
	{
		$this->trigger_events('set_lang');

		// if the user_expire is set to zero we'll set the expiration two years from now.
		if($this->config->item('user_expire', 'ion_auth') === 0)
		{
			$expire = (60*60*24*365*2);
		}
		// otherwise use what is set
		else
		{
			$expire = $this->config->item('user_expire', 'ion_auth');
		}

		set_cookie(array(
			'name'   => 'lang_code',
			'value'  => $lang,
			'expire' => $expire
		));

		return TRUE;
	}

	public function set_session($user)
	{
		$this->trigger_events('pre_set_session');

		$session_data = array(
		    'first_name'             => $user->first_name,
		    'last_name'             => $user->last_name,
		    'identity'             => $user->{$this->identity_column},
		    $this->identity_column => $user->{$this->identity_column},
		    'email'                => $user->email,
		    'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id
		    'old_last_login'       => $user->last_login,
		    'role_id'       => !empty($user->role_id) ? $user->role_id : "0",
		    'last_check'           => time(),
		);

		$this->session->set_userdata($session_data);

		$this->trigger_events('post_set_session');

		return TRUE;
	}

	public function remember_user($id)
	{
		$this->trigger_events('pre_remember_user');

		if (!$id)
		{
			return FALSE;
		}

		$user = $this->user($id)->row();

		$salt = $this->salt();

		$this->db->update($this->tables['users'], array('remember_code' => $salt), array('id' => $id));

		if ($this->db->affected_rows() > -1)
		{
			// if the user_expire is set to zero we'll set the expiration two years from now.
			if($this->config->item('user_expire', 'ion_auth') === 0)
			{
				$expire = (60*60*24*365*2);
			}
			// otherwise use what is set
			else
			{
				$expire = $this->config->item('user_expire', 'ion_auth');
			}

			set_cookie(array(
			    'name'   => $this->config->item('identity_cookie_name', 'ion_auth'),
			    'value'  => $user->{$this->identity_column},
			    'expire' => $expire
			));

			set_cookie(array(
			    'name'   => $this->config->item('remember_cookie_name', 'ion_auth'),
			    'value'  => $salt,
			    'expire' => $expire
			));

			$this->trigger_events(array('post_remember_user', 'remember_user_successful'));
			return TRUE;
		}

		$this->trigger_events(array('post_remember_user', 'remember_user_unsuccessful'));
		return FALSE;
	}

	public function login_remembered_user()
	{
		$this->trigger_events('pre_login_remembered_user');

		// check for valid data
		if (!get_cookie($this->config->item('identity_cookie_name', 'ion_auth'))
			|| !get_cookie($this->config->item('remember_cookie_name', 'ion_auth'))
			|| !$this->identity_check(get_cookie($this->config->item('identity_cookie_name', 'ion_auth'))))
		{
			$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
			return FALSE;
		}

		// get the user
		$this->trigger_events('extra_where');
		$query = $this->db->select($this->identity_column . ', id, email, last_login')
						  ->where($this->identity_column, urldecode(get_cookie($this->config->item('identity_cookie_name', 'ion_auth'))))
						  ->where('remember_code', get_cookie($this->config->item('remember_cookie_name', 'ion_auth')))
						  ->where('active', 1)
						  ->limit(1)
						  ->order_by('id', 'desc')
						  ->get($this->tables['users']);

		// if the user was found, sign them in
		if ($query->num_rows() == 1)
		{
			$user = $query->row();

			$this->update_last_login($user->id);

			$this->set_session($user);

			// extend the users cookies if the option is enabled
			if ($this->config->item('user_extend_on_login', 'ion_auth'))
			{
				$this->remember_user($user->id);
			}
            
			// Regenerate the session (for security purpose: to avoid session fixation)
			$this->_regenerate_session();

			$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_successful'));
			return TRUE;
		}

		$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
		return FALSE;
	}

	public function create_group($group_name = FALSE, $group_description = '', $additional_data = array())
	{
		// bail if the group name was not passed
		if(!$group_name)
		{
			$this->set_error('group_name_required');
			return FALSE;
		}

		// bail if the group name already exists
		$existing_group = $this->db->get_where($this->tables['groups'], array('name' => $group_name))->num_rows();
		if($existing_group !== 0)
		{
			$this->set_error('group_already_exists');
			return FALSE;
		}

		$data = array('name'=>$group_name,'description'=>$group_description);

		// filter out any data passed that doesnt have a matching column in the groups table
		// and merge the set group data and the additional data
		if (!empty($additional_data)) $data = array_merge($this->_filter_data($this->tables['groups'], $additional_data), $data);

		$this->trigger_events('extra_group_set');

		// insert the new group
		$this->db->insert($this->tables['groups'], $data);
		$group_id = $this->db->insert_id($this->tables['groups'] . '_id_seq');

		// report success
		$this->set_message('group_creation_successful');
		// return the brand new group id
		return $group_id;
	}

	public function update_group($group_id = FALSE, $group_name = FALSE, $additional_data = array())
	{
		if (empty($group_id))
		{
			return FALSE;
		}

		$data = array();

		if (!empty($group_name))
		{
			// we are changing the name, so do some checks

			// bail if the group name already exists
			$existing_group = $this->db->get_where($this->tables['groups'], array('name' => $group_name))->row();
			if (isset($existing_group->id) && $existing_group->id != $group_id)
			{
				$this->set_error('group_already_exists');
				return FALSE;
			}

			$data['name'] = $group_name;
		}

		// restrict change of name of the admin group
		$group = $this->db->get_where($this->tables['groups'], array('id' => $group_id))->row();
		if ($this->config->item('admin_group', 'ion_auth') === $group->name && $group_name !== $group->name)
		{
			$this->set_error('group_name_admin_not_alter');
			return FALSE;
		}

		// TODO Third parameter was string type $description; this following code is to maintain backward compatibility
		if (is_string($additional_data))
		{
			$additional_data = array('description' => $additional_data);
		}

		// filter out any data passed that doesnt have a matching column in the groups table
		// and merge the set group data and the additional data
		if (!empty($additional_data))
		{
			$data = array_merge($this->_filter_data($this->tables['groups'], $additional_data), $data);
		}

		$this->db->update($this->tables['groups'], $data, array('id' => $group_id));

		$this->set_message('group_update_successful');

		return TRUE;
	}

	public function delete_group($group_id = FALSE)
	{
		// bail if mandatory param not set
		if(!$group_id || empty($group_id))
		{
			return FALSE;
		}
		$group = $this->group($group_id)->row();
		if($group->name == $this->config->item('admin_group', 'ion_auth'))
		{
			$this->trigger_events(array('post_delete_group', 'post_delete_group_notallowed'));
			$this->set_error('group_delete_notallowed');
			return FALSE;
		}

		$this->trigger_events('pre_delete_group');

		$this->db->trans_begin();

		// remove all users from this group
		$this->db->delete($this->tables['users_groups'], array($this->join['groups'] => $group_id));
		// remove the group itself
		$this->db->delete($this->tables['groups'], array('id' => $group_id));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->trigger_events(array('post_delete_group', 'post_delete_group_unsuccessful'));
			$this->set_error('group_delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->trigger_events(array('post_delete_group', 'post_delete_group_successful'));
		$this->set_message('group_delete_successful');
		return TRUE;
	}

	public function set_hook($event, $name, $class, $method, $arguments)
	{
		$this->_ion_hooks->{$event}[$name] = new stdClass;
		$this->_ion_hooks->{$event}[$name]->class     = $class;
		$this->_ion_hooks->{$event}[$name]->method    = $method;
		$this->_ion_hooks->{$event}[$name]->arguments = $arguments;
	}

	public function remove_hook($event, $name)
	{
		if (isset($this->_ion_hooks->{$event}[$name]))
		{
			unset($this->_ion_hooks->{$event}[$name]);
		}
	}

	public function remove_hooks($event)
	{
		if (isset($this->_ion_hooks->$event))
		{
			unset($this->_ion_hooks->$event);
		}
	}

	protected function _call_hook($event, $name)
	{
		if (isset($this->_ion_hooks->{$event}[$name]) && method_exists($this->_ion_hooks->{$event}[$name]->class, $this->_ion_hooks->{$event}[$name]->method))
		{
			$hook = $this->_ion_hooks->{$event}[$name];

			return call_user_func_array(array($hook->class, $hook->method), $hook->arguments);
		}

		return FALSE;
	}

	public function trigger_events($events)
	{
		if (is_array($events) && !empty($events))
		{
			foreach ($events as $event)
			{
				$this->trigger_events($event);
			}
		}
		else
		{
			if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events))
			{
				foreach ($this->_ion_hooks->$events as $name => $hook)
				{
					$this->_call_hook($events, $name);
				}
			}
		}
	}


	public function set_message_delimiters($start_delimiter, $end_delimiter)
	{
		$this->message_start_delimiter = $start_delimiter;
		$this->message_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	public function set_error_delimiters($start_delimiter, $end_delimiter)
	{
		$this->error_start_delimiter = $start_delimiter;
		$this->error_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	public function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}

	public function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
			$_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
		}

		return $_output;
	}


	public function messages_array($langify = TRUE)
	{
		if ($langify)
		{
			$_output = array();
			foreach ($this->messages as $message)
			{
				$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
				$_output[] = $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
			}
			return $_output;
		}
		else
		{
			return $this->messages;
		}
	}


	public function clear_messages()
	{
		$this->messages = array();

		return TRUE;
	}

	public function set_error($error)
	{
		$this->errors[] = $error;

		return $error;
	}

	public function errors()
	{
		$_output = '';
		foreach ($this->errors as $error)
		{
			$errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
			$_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
		}

		return $_output;
	}

	public function errors_array($langify = TRUE)
	{
		if ($langify)
		{
			$_output = array();
			foreach ($this->errors as $error)
			{
				$errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
				$_output[] = $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
			}
			return $_output;
		}
		else
		{
			return $this->errors;
		}
	}


	public function clear_errors()
	{
		$this->errors = array();

		return TRUE;
	}


	protected function _filter_data($table, $data)
	{
		$filtered_data = array();
		$columns = $this->db->list_fields($table);

		if (is_array($data))
		{
			foreach ($columns as $column)
			{
				if (array_key_exists($column, $data))
					$filtered_data[$column] = $data[$column];
			}
		}

		return $filtered_data;
	}


	protected function _prepare_ip($ip_address) {
		return $ip_address;
	}


	protected function _regenerate_session() {

		if (substr(CI_VERSION, 0, 1) == '2')
		{
			// Save sess_time_to_update and set it temporarily to 0
			// This is done in order to forces the sess_update method to regenerate
			$old_sess_time_to_update = $this->session->sess_time_to_update;
			$this->session->sess_time_to_update = 0;

			// Call the sess_update method to actually regenerate the session ID
			$this->session->sess_update();

			// Restore sess_time_to_update
			$this->session->sess_time_to_update = $old_sess_time_to_update;
		}
		else
		{
			$this->session->sess_regenerate(FALSE);
		}
	}

	
	public function seller_activate($id, $code = FALSE)
	{
		$this->trigger_events('pre_activate');

		if ($code !== FALSE)
		{
			$query = $this->db->select($this->identity_column)
			                  ->where('activation_code', $code)
			                  ->where('id', $id)
			                  ->limit(1)
			                  ->order_by('id', 'desc')
			                  ->get($this->table_sellers);

			$query->row();

			if ($query->num_rows() !== 1)
			{
				$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
				$this->set_error('activate_unsuccessful');
				return FALSE;
			}

			$data = array(
			    'activation_code' => NULL,
			    'active'          => 1
			);

			$this->trigger_events('extra_where');
			$this->db->update($this->table_sellers, $data, array('id' => $id));
		}
		else
		{
			$data = array(
			    'activation_code' => NULL,
			    'active'          => 1
			);

			$this->trigger_events('extra_where');
			$this->db->update($this->table_sellers, $data, array('id' => $id));
		}

		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->trigger_events(array('post_activate', 'post_activate_successful'));
			$this->set_message('activate_successful');
		}
		else
		{
			$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
			$this->set_error('activate_unsuccessful');
		}

		return $return;
	}

	public function seller_reset_password($identity, $new) {
		$this->trigger_events('pre_change_password');

		if (!$this->admin_identity_check($identity)) {
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('id, password, salt')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
		                  ->order_by('id', 'desc')
		                  ->get($this->table_sellers);

		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$result = $query->row();

		$new = $this->hash_password($new, $result->salt);

		// store the new password and reset the remember code so all remembered instances have to re-login
		// also clear the forgotten password code
		$data = array(
		    'password' => $new,
		    'remember_code' => NULL,
		    'forgotten_password_code' => NULL,
		    'forgotten_password_time' => NULL,
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['buyers'], $data, array($this->identity_column => $identity));

		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_successful'));
			$this->set_message('password_change_successful');
		}
		else
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
		}

		return $return;
	}

	public function seller_identity_check($identity = '')
	{
		$this->trigger_events('identity_check');

		if (empty($identity))
		{
			return FALSE;
		}

		return $this->db->where($this->identity_column, $identity)
		->limit(1)
		->count_all_results($this->table_sellers) > 0;
	}
	public function check_password_seller($old, $id){
		$query = $this->db->select('id, password,email')
		->where('id', $id)
		->limit(1)
		->order_by('id', 'desc')
		->get($this->table_sellers);

		if ($query->num_rows() !== 1)
		{
			return 0;
		}

		$user = $query->row();
		
		if ($this->verify_password($old, $user->password, NULL))
		{
			return 1;
		}else{
			return 2;
		}
	}

	public function get_seller_forgotten_password_code($user_code) {
		// Retrieve the token object from the code
		$token = $this->_retrieve_selector_validator_couple($user_code);

		if($token) {
			// Retrieve the user according to this selector
			// $user = $this->where('forgotten_password_selector', $token->selector)->users()->row();
			$user = $this->db->select('*')->where('forgotten_password_selector',$token->selector)->get($this->table_sellers)->row();
			if ($user)
			{
				// Check the hash against the validator
				if ($this->verify_password($token->validator, $user->forgotten_password_code))
				{
					return $user;
				}
			}
		}

		return FALSE;
	}

	public function register_seller($identity, $password, $email, $additional_data = array(), $groups = array()) {
		$this->trigger_events('pre_register');

		$manual_activation = $this->config->item('manual_activation', 'ion_auth');

		// IP Address
		$ip_address = $this->_prepare_ip($this->input->ip_address());
		$salt = $this->store_salt ? $this->salt() : FALSE;
		$password = $this->hash_password($password, $salt);
		$activation_code = sha1(md5(microtime()));

		// Users table.
		$data = array(
			$this->identity_column => $identity,
			'username' => $identity,
			'password' => $password,
			'email' => $email,
			'ip_address' => $ip_address,
			'created_on' => time(),
			'active' => ($manual_activation === FALSE ? 1 : 0),
			'activation_code' => $activation_code
		);
		if ($this->store_salt)
		{
			$data['salt'] = $salt;
		}

		// filter out any data passed that doesnt have a matching column in the users table
		// and merge the set user data and the additional data
		$user_data = array_merge($this->_filter_data($this->table_sellers, $additional_data), $data);

		$this->trigger_events('extra_set');

		$this->db->insert($this->table_sellers, $user_data);

		$id = $this->db->insert_id($this->table_sellers . '_id_seq');

		$this->trigger_events('post_register');

		if (isset($id)) {
            $register = array(
                'success' => 1,
                'id' => $id,
                'activation_code' => $activation_code
            );
        } else {
            $register = array(
                'success' => 0
            );
        }
        return $register;
	}

	public function seller_login($identity, $password, $remember=FALSE){
		$this->trigger_events('pre_login');

		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select($this->identity_column . ', email, id, password, active, last_login, status')
						  ->where($this->identity_column, $identity)
						  ->limit(1)
						  ->order_by('id', 'desc')
						  ->get($this->table_sellers);

		if ($this->is_seller_max_login_attempts_exceeded($identity))
		{
			// Hash something anyway, just to take up time
			$this->hash_password($password);

			$this->trigger_events('post_login_unsuccessful');
			$this->set_error('login_timeout');

			return FALSE;
		}

		if ($query->num_rows() === 1)
		{
			$business = $query->row();

			$password = $this->hash_password_seller_db($business->id, $password);

			if ($password === TRUE)
			{
				if ($business->active == 0)
				{
					$this->trigger_events('post_login_unsuccessful');
					$this->set_error('login_unsuccessful_not_active');

					return FALSE;
				}

				if($business->status == 0) {
					$this->trigger_events('login_unsuccessful_business_not_approved');
					$this->set_error('login_unsuccessful_business_not_approved');

		            return FALSE;
		        }

				$this->set_seller_session($business);

				$this->update_last_login_sellers($business->id);

				$this->clear_seller_login_attempts($identity);

				if ($remember && $this->config->item('remember_users', 'ion_auth'))
				{
					$this->remember_user($business->id);
				}
                
				// Regenerate the session (for security purpose: to avoid session fixation)
				$this->_regenerate_session();

				$this->trigger_events(array('post_login', 'post_login_successful'));
				$this->set_message('login_successful');

				return TRUE;
			}
		}

		// Hash something anyway, just to take up time
		$this->hash_password($password);

		$this->increase_seller_login_attempts($identity);

		$this->trigger_events('post_login_unsuccessful');
		$this->set_error('login_unsuccessful');

		return FALSE;
	}

	public function set_seller_session($user)
	{
		$this->trigger_events('pre_set_session');

		$session_data = array(
		    'identity'             => $user->{$this->identity_column},
		    $this->identity_column => $user->{$this->identity_column},
		    'email'                => $user->email,
		    'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id
		    'old_last_login'       => $user->last_login,
		    'last_check'           => time(),
		);

		$this->session->set_userdata($session_data);

		$this->trigger_events('post_set_session');

		return TRUE;
	}

	public function update_last_login_sellers($id)
	{
		$this->trigger_events('update_last_login');

		$this->load->helper('date');

		$this->trigger_events('extra_where');

		$this->db->update($this->table_sellers, array('last_login' => time()), array('id' => $id));

		return $this->db->affected_rows() == 1;
	}

    public function checkSellerChangePassword($identity, $password, $remember = FALSE) {

        $query = $this->db->select('email, id, username, activation_code, password, active, last_login')
                ->where('id', $identity)
                ->limit(1)
                ->order_by('id', 'desc')
                ->get($this->table_sellers);

        if ($query->num_rows() === 1) {
            $user = $query->row();
            $password = $this->hash_password_db_sellers($user->id, $password);
            
            if ($password === TRUE) {
                $response = array(
                    'success' => 1,
                    'message' => 'Current Password match successfully'
                );
                return $response;
            } else {
                $response = array(
                    'success' => 0,
                    'message' => "Current password is incorrect"
                );
                return $response;
            }
        } else {
            $response = array(
                'success' => 0,
                'message' => "That account doesn't exists"
            );
            return $response;
        }
    }

    public function hash_password_db_sellers($id, $password, $use_sha1_override = FALSE)
	{
		if (empty($id) || empty($password))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('password, salt')
		                  ->where('id', $id)
		                  ->limit(1)
		                  ->order_by('id', 'desc')
		                  ->get($this->table_sellers);

		$hash_password_db = $query->row();

		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}

		// bcrypt
		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt')
		{
			if ($this->bcrypt->verify($password,$hash_password_db->password))
			{
				return TRUE;
			}

			return FALSE;
		}

		// sha1
		if ($this->store_salt)
		{
			$db_password = sha1($password . $hash_password_db->salt);
		}
		else
		{
			$salt = substr($hash_password_db->password, 0, $this->salt_length);

			$db_password =  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}

		if($db_password == $hash_password_db->password)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

    public function setSellerNewPassword($admin_id,$new_password)
    {
        $salt = $this->store_salt ? $this->salt() : FALSE;
        $activation_code = sha1(md5(microtime()));
        $password = $this->hash_password($new_password, $salt);

        return $this->db->update($this->table_sellers,array('password'=>$password), array('id' => $admin_id));
    }

	public function hash_password_seller_db($id, $password, $use_sha1_override = FALSE)
	{
		if (empty($id) || empty($password))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('password, salt')
		                  ->where('id', $id)
		                  ->limit(1)
		                  ->order_by('id', 'desc')
		                  ->get($this->table_sellers);

		$hash_password_db = $query->row();
		
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}

		// bcrypt
		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt')
		{	
			if ($this->bcrypt->verify($password,$hash_password_db->password))
			{
				return TRUE;
			}

			return FALSE;
		}

		// sha1
		if ($this->store_salt)
		{
			$db_password = sha1($password . $hash_password_db->salt);
		}
		else
		{
			$salt = substr($hash_password_db->password, 0, $this->salt_length);

			$db_password =  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}

		if($db_password == $hash_password_db->password)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function clear_seller_forgotten_password_code($code) {

		if (empty($code))
		{
			return FALSE;
		}

		$this->db->where('forgotten_password_code', $code);

		if ($this->db->count_all_results($this->table_sellers) > 0)
		{
			$data = array(
			    'forgotten_password_code' => NULL,
			    'forgotten_password_time' => NULL
			);

			$this->db->update($this->table_sellers, $data, array('forgotten_password_code' => $code));

			return TRUE;
		}

		return FALSE;
	}

	public function reset_seller_password($identity, $new) {
		$this->trigger_events('pre_change_password');

		if (!$this->identity_check($identity)) {
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('id, password, salt')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
		                  ->order_by('id', 'desc')
		                  ->get($this->table_sellers);

		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$result = $query->row();

		$new = $this->hash_password($new, $result->salt);

		// store the new password and reset the remember code so all remembered instances have to re-login
		// also clear the forgotten password code
		$data = array(
		    'password' => $new,
		    'remember_code' => NULL,
		    'forgotten_password_code' => NULL,
		    'forgotten_password_time' => NULL,
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->table_sellers, $data, array($this->identity_column => $identity));

		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_successful'));
			$this->set_message('password_change_successful');
		}
		else
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
		}

		return $return;
	}

	public function seller_change_password($identity, $old, $new)
	{
		$this->trigger_events('pre_change_password');

		$this->trigger_events('extra_where');

		$query = $this->db->select('id, password, salt')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
		                  ->order_by('id', 'desc')
		                  ->get($this->table_sellers);
		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$business = $query->row();

		$old_password_matches = $this->hash_password_seller_db($business->id, $old);

		if ($old_password_matches === TRUE)
		{
			// store the new password and reset the remember code so all remembered instances have to re-login
			$hashed_new_password  = $this->hash_password($new, $business->salt);
			$data = array(
			    'password' => $hashed_new_password,
			    'remember_code' => NULL,
			);

			$this->trigger_events('extra_where');

			$successfully_changed_password_in_db = $this->db->update($this->table_sellers, $data, array($this->identity_column => $identity));
			if ($successfully_changed_password_in_db)
			{
				$this->trigger_events(array('post_change_password', 'post_change_password_successful'));
				$this->set_message('password_change_successful');
			}
			else
			{
				$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
				$this->set_error('password_change_unsuccessful');
			}

			return $successfully_changed_password_in_db;
		}
		
		$this->set_error('password_change_unsuccessful');
		return FALSE;
	}

	public function seller_forgotten_password($identity)
	{
		if (empty($identity))
		{
			$this->trigger_events(['post_forgotten_password', 'post_forgotten_password_unsuccessful']);
			return FALSE;
		}

		// Generate random token: smaller size because it will be in the URL
		$token = $this->_generate_selector_validator_couple(20, 80);

		$update = [
			'forgotten_password_selector' => $token->selector,
			'forgotten_password_code' => $token->validator_hashed,
			'forgotten_password_time' => time()
		];

		$this->trigger_events('extra_where');
		$this->db->update($this->table_sellers, $update, [$this->identity_column => $identity]);

		if ($this->db->affected_rows() === 1)
		{
			$this->trigger_events(['post_forgotten_password', 'post_forgotten_password_successful']);
			return $token->user_code;
		}
		else
		{
			$this->trigger_events(['post_forgotten_password', 'post_forgotten_password_unsuccessful']);
			return FALSE;
		}
	}

	public function get_seller_by_forgotten_password_code($user_code)
	{
		// Retrieve the token object from the code
		$token = $this->_retrieve_selector_validator_couple($user_code);

		if($token) {
			// Retrieve the user according to this selector
			$business = $this->db->where('forgotten_password_selector', $token->selector)->get($this->table_sellers)->row();

			if ($business)
			{
				// Check the hash against the validator
				if ($this->verify_password($token->validator, $business->forgotten_password_code))
				{
					return $business;
				}
			}
		}

		return FALSE;
	}

	public function recheck_seller_session()
	{
		if (empty($this->session->userdata('identity')))
		{
			return FALSE;
		}

		$business = $this->db->select('*')
				  ->where([
					  $this->identity_column => $this->session->userdata('identity'),
					  'id' => $this->session->userdata('user_id'),
					  'active' => '1',
					  'status' => 1
				  ])
				  ->limit(1)
				  ->order_by('id', 'desc')
				  ->get($this->table_sellers)->row();

		$recheck = (NULL !== $this->config->item('recheck_timer', 'ion_auth')) ? $this->config->item('recheck_timer', 'ion_auth') : 0;

		if ($recheck !== 0)
		{
			$last_login = $this->session->userdata('last_check');
			if ($last_login + $recheck < time())
			{
				if (!empty($business))
				{
					$this->session->set_userdata('last_check', time());
				}
				else
				{
					$this->trigger_events('logout');

					$identity = $this->config->item('identity', 'ion_auth');

					$this->session->unset_userdata([$identity, 'id', 'user_id']);

					return FALSE;
					
				}
			}
		}

		return $business;
	}

	public function is_seller_max_login_attempts_exceeded($identity, $ip_address = NULL)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$max_attempts = $this->config->item('maximum_login_attempts', 'ion_auth');
			if ($max_attempts > 0)
			{
				$attempts = $this->get_seller_attempts_num($identity, $ip_address);
				return $attempts >= $max_attempts;
			}
		}
		return FALSE;
	}


	public function is_seller_time_locked_out($identity, $ip_address = NULL)
	{
		return $this->is_seller_max_login_attempts_exceeded($identity, $ip_address);
	}

	public function get_seller_attempts_num($identity, $ip_address = NULL)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$this->db->select('1', FALSE);
			$this->db->where('login', $identity);
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
			{
				if (!isset($ip_address))
				{
					$ip_address = $this->_prepare_ip($this->input->ip_address());
				}
				$this->db->where('ip_address', $ip_address);
			}
			$this->db->where('time >', time() - $this->config->item('lockout_time', 'ion_auth'), FALSE);
			$qres = $this->db->get($this->table_seller_login_attempts);
			return $qres->num_rows();
		}
		return 0;
	}

	public function increase_seller_login_attempts($identity)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			$data = array('ip_address' => '', 'login' => $identity, 'time' => time());
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
			{
				$data['ip_address'] = $this->_prepare_ip($this->input->ip_address());
			}
			return $this->db->insert($this->table_seller_login_attempts, $data);
		}
		return FALSE;
	}

	public function clear_seller_login_attempts($identity, $old_attempts_expire_period = 86400, $ip_address = NULL)
	{
		if ($this->config->item('track_login_attempts', 'ion_auth'))
		{
			// Make sure $old_attempts_expire_period is at least equals to lockout_time
			$old_attempts_expire_period = max($old_attempts_expire_period, $this->config->item('lockout_time', 'ion_auth'));

			$this->db->where('login', $identity);
			if ($this->config->item('track_login_ip_address', 'ion_auth'))
			{
				if (!isset($ip_address))
				{
					$ip_address = $this->_prepare_ip($this->input->ip_address());
				}
				$this->db->where('ip_address', $ip_address);
			}
			// Purge obsolete login attempts
			$this->db->or_where('time <', time() - $old_attempts_expire_period, FALSE);

			return $this->db->delete($this->table_seller_login_attempts);
		}
		return FALSE;
	}

	public function update_seller_last_login($id)
	{
		$this->trigger_events('update_last_login');

		$this->load->helper('date');

		$this->trigger_events('extra_where');

		$this->db->update($this->table_sellers, array('last_login' => time()), array('id' => $id));

		return $this->db->affected_rows() == 1;
	}

	public function login_remembered_seller()
	{
		$this->trigger_events('pre_login_remembered_user');

		// check for valid data
		if (!get_cookie($this->config->item('identity_cookie_name', 'ion_auth'))
			|| !get_cookie($this->config->item('remember_cookie_name', 'ion_auth'))
			|| !$this->identity_check(get_cookie($this->config->item('identity_cookie_name', 'ion_auth'))))
		{
			$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
			return FALSE;
		}

		// get the user
		$this->trigger_events('extra_where');
		$query = $this->db->select($this->identity_column . ', id, email, last_login')
						  ->where($this->identity_column, urldecode(get_cookie($this->config->item('identity_cookie_name', 'ion_auth'))))
						  ->where('remember_code', get_cookie($this->config->item('remember_cookie_name', 'ion_auth')))
						  ->where('business_status', 1)
						  ->limit(1)
						  ->order_by('id', 'desc')
						  ->get($this->table_sellers);

		// if the user was found, sign them in
		if ($query->num_rows() == 1)
		{
			$business = $query->row();

			$this->update_seller_last_login($business->id);

			$this->set_session($business);

			// extend the users cookies if the option is enabled
			if ($this->config->item('user_extend_on_login', 'ion_auth'))
			{
				$this->remember_user($business->id);
			}
            
			// Regenerate the session (for security purpose: to avoid session fixation)
			$this->_regenerate_session();

			$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_successful'));
			return TRUE;
		}

		$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
		return FALSE;
	}

    public function seller($email)
	{
		$this->db->select('*');
		$this->db->where('email',$email);
		$query = $this->db->get($this->table_sellers);
		return $query->row();
	}
}
