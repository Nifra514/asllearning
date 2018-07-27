<?php
ob_start ();
session_start ();
$title = 'ASL Learning | Log Details';
include ('../Controllers/control.php');
$obj = new control ();
include ('Header&Footer/header.php');

$obj->protect_page ();

if (($obj->logged_in () === true) && ($_SESSION ['utype'] !== "admin")) {
	?>
&nbsp;
<div class="container">
	<div class="alert alert-danger alert-dismissible" role="alert"
		style="margin-left: auto; margin-right: auto;">
		<button type="button" class="close" data-dismiss="alert"
			aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;<strong>Permission Denied!</strong><?php echo "YOU ARE NOT ALLOWED TO VIEW THIS PAGE";?>
	            
	            </div>
</div>

<?php 

$user_id = $_SESSION ['id'];
$type = "Warning"; // log, warning,error
$data = array (
		'action' => "Permission denied for user: " . $user_id . " from asllearning.info"
);
$action = "Permission";
$status = 1;
$risk = "High";
	
$obj->write_log ( $user_id, $type, $data, $action, $status, $risk );

?>

<script type="text/javascript">
			      
				setTimeout("location.href = 'logout.php';",2000);	// Page Dillay 2 Second
				
				</script>


<?php  } else { 

	$user_id = $_SESSION ['id'];
	$type = "log"; // log, warning,error
	$data = array (
			'action' => "Log data loaded for the admin user: " . $user_id . " at asllearning.info"
	);
	$action = "Permission";
	$status = 1;
	$risk = "None";
	
	$obj->write_log ( $user_id, $type, $data, $action, $status, $risk );
	
	?>



<div class="container">
	<div class="row">
		<div class="col-md-12">

			<div style="overflow-x: auto;">
				<table>
					<tr>
						<th>Id.</th>
						<th>User</th>
						<th>Type</th>
						<th>Log Data</th>
						<th>Action</th>
						<th>Status</th>
						<th>Risk</th>
						<th>Date & Time</th>
					</tr>
							<?php
	$log_data = $obj->select_log ();
	$i = 1;
	while ( $full_log = mysqli_fetch_array ( $log_data ) ) {
		
		$log_u_id = $full_log ['u_id'];
		$type = $full_log ['type'];
		$data = $full_log ['data'];
		$action = $full_log ['action'];
		$status = $full_log ['status'];
		$risk = $full_log ['risk'];
		$timestamp = $full_log ['timestamp'];
		
		?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $log_u_id;?></td>
						<td><?php echo $type;?></td>
						<td><?php echo $data;?></td>
						<td><?php echo $action;?></td>
						<td><?php echo $status;?></td>
						<td><?php echo $risk;?></td>
						<td><?php echo $timestamp;?></td>


					</tr>
							<?php
		$i ++;
	}
	
}
?>
					
				</table>
				&nbsp;
			</div>


		</div>

	</div>
</div>

<!-- including footer -->

<?php include ('Header&Footer/footer.php'); ?>
	