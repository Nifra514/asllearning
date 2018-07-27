<?php
require_once '../Models/mysqldb.php';
class control extends mysqldb {
	public function __construct() {
		parent::__construct ();
	}
	function write_log($user_id, $type, $data, $action, $status, $risk) {
		$encoded_data = json_encode ( $data );
		$query = "INSERT INTO `log_details` (`u_id`, `type`, `data`, `action`, `status`, `risk`, `timestamp`) VALUES ('$user_id', '$type', '$encoded_data', '$action', '$status', '$risk', NOW())";
		$this->comq ( $query );
	}
	function get_user_from_token($token) {
		$sql = "SELECT * FROM user_details WHERE token='" . $token . "'";
		return $this->comq ( $sql );
	}
	function token_up($token, $uname) {
		$sql = "UPDATE user_details SET token='$token' WHERE username='$uname'";
		return $this->comq ( $sql );
	}
	function exists($uname) {
		$sql = "SELECT u_id FROM user_details WHERE username = '$uname'";
		return $this->comq ( $sql );
	}
	function pwd_exists($password) {
		$sql = "SELECT u_id FROM user_details WHERE password = '$password'";
		return $this->comq ( $sql );
	}
	function email_exists($email) {
		$sql = "SELECT u_id FROM user_details WHERE email_id = '$email'";
		return $this->comq ( $sql );
	}
	function output_errors($errors = array()) {
		return '<ul><li>' . implode ( '</li><li>', $errors ) . '</li></ul>';
	}
	public function reg_user($name, $email, $phone, $uname, $password1) {
		$sql = "INSERT INTO `user_details`(`name`, `email_id`,`tp_no`, `username`, `password`, `user_type`,`date`)
		VALUES ('$name','$email','$phone','$uname','$password1', 'user',NOW())";
		
		return $this->comq ( $sql );
	}
	function login($uname, $password1) {
		$sql = "SELECT * FROM user_details WHERE username = '$uname' AND password = '$password1'";
		
		return $this->comq ( $sql );
	}
	function logged_in() {
		return (isset ( $_SESSION ['id'] )) ? true : false;
	}
	function protect_page() {
		if ($this->logged_in () === false) {
			header ( 'Location: index.php' );
			exit ();
		}
	}
	function logged_in_redirect() {
		if ($this->logged_in () === true) {
			header ( 'Location: download.php' );
			exit ();
		}
	}
	function select_log() {
			
			$sql = "SELECT * FROM log_details";
			
			return $this->comq ( $sql );
		
	}
}

?>
