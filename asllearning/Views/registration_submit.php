<?php
$title = 'ASL Learning | Registration_submit';
include ('../Controllers/control.php');
$obj = new control ();
include ('../Views/Header&Footer/header_login.php');

if (empty ( $_POST ) === false) {
	$required_fields = array (
			'name',
			'mailid',
			'phone',
			'uname',
			'password',
			'password_again',
			'con' 
	);
	foreach ( $_POST as $key => $value ) {
		if (empty ( $value ) && in_array ( $key, $required_fields ) === true) {
			$errors [] = 'All the fields are required!';
			break;
		}
	}
}

$error = false;

$insertErr = array ();
if (isset ( $_POST ['register'] )) {
	
	$name = mysqli_real_escape_string ( $obj->link, $_POST ['name'] );
	$email = mysqli_real_escape_string ( $obj->link, $_POST ['mailid'] );
	$phone = mysqli_real_escape_string ( $obj->link, $_POST ['phone'] );
	$uname = mysqli_real_escape_string ( $obj->link, $_POST ['uname'] );
	$password = mysqli_real_escape_string ( $obj->link, $_POST ['password'] );
	$password_again = mysqli_real_escape_string ( $obj->link, $_POST ['password_again'] );
	
	$password1 = md5 ( $_POST ['password'] );
	$mailcode = md5 ( $_POST ['uname'] . microtime () );
	$tocken = md5 ( $_POST ['uname'] . microtime () . $_POST ['phone'] );
	
	// echo $mailcode.'<br>';
	
	// echo $tocken;
	
	$unameVer = $obj->exists ( $uname );
	$countUname = mysqli_num_rows ( $unameVer );
	
	$emailVer = $obj->email_exists ( $email );
	$countVer = mysqli_num_rows ( $emailVer );
	
	if (! preg_match ( '/^[a-z]{2,30}$/i', $name )) {
		$error = true;
		$insertErr [] = "Your first name can contain only alphabets";
	}
	
	if (preg_match ( "/\\s/", $uname ) == true) {
		$error = true;
		$insertErr [] = "Your username cannot contain any spaces!";
	}
	
	if (! preg_match ( '/^[a-z][0-9a-z]{1,31}$/i', $uname )) {
		$error = true;
		$insertErr [] = "Your username can contain only alphabets and numbers!";
	}
	
	if (strlen ( $uname ) < 6) {
		$error = true;
		$insertErr [] = "Your username must be atleast 6 characters!";
	} 

	else {
		if ($countUname >= 1) {
			$error = true;
			$insertErr [] = "Sorry, such username has already been taken by another user!";
		}
	}
	
	if (! filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
		$error = true;
		$insertErr [] = "Provide a valid email";
	} 

	else {
		if ($countVer >= 1) {
			$error = true;
			$insertErr [] = "Email already exists";
		}
	}
	
	if (strlen ( $phone ) != 10) {
		$error = true;
		$insertErr [] = "Please recheck your phone number!";
	}
	
	if (strlen ( $password ) < 6) {
		$error = true;
		$insertErr [] = "Your password must be atleast 6 characters!";
	}
	
	if ($password_again != $password) {
		$error = true;
		$insertErr [] = "Your password do not match!";
	}
	
	if (! $error) {
		
		$obj->reg_user ( $name, $email, $phone, $uname, $password1, $mailcode, $tocken );
		
		//$obj->activation($name, $email, $mailcode);
		
		?>
		&nbsp;
<div class="container">
	<div class="alert alert-success alert-dismissible" role="alert"
		style="margin-right: auto%; margin-left: auto%;">
		<button type="button" class="close" data-dismiss="alert"
			aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<span class="glyphicon glyphicon-thumbs-up">&nbsp;&nbsp;</span><strong>Success!</strong>
		Successfully Registered! Please Check Your E-Mail For Activation
		Link!.
	</div>
</div>
<script type="text/javascript">
			      
				setTimeout("location.href = 'index.php';",2000);	// Page Dillay 5 Second
				
				</script>

<?php
	} else {
		?>
		&nbsp;
<div class="container">
	<div class="alert alert-danger alert-dismissible" role="alert"
		style="margin-left: auto; margin-right: auto;">
		<button type="button" class="close" data-dismiss="alert"
			aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;<strong>Error!</strong><?php echo $obj->output_errors($insertErr);?>
	            
	            </div>
</div>
<script type="text/javascript">
			      
				setTimeout("location.href = 'registration.php';",3000);	// Page Dillay 2 Second
				
				</script>
<?php
	}
}
?>						
&nbsp;
<!-- including footer -->

<?php include ('../Views/Header&Footer/footer.php'); ?>
	