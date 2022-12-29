<?php require_once('../../private/initialize.php'); ?>
<?php
require_login();


// if (!isset($_GET['id'])) {
//     redirect_to(url_for('/index.php'));
// }
// $id = $_GET['id'];
// $user = User::find_by_id($id);
// if ($user == false) {
//     redirect_to(url_for('/index.php'));
// }


?>
<?php $page_title = 'Addresses';
$page_classes[] = '';
$container = '';
?>
<?php include(SHARED_PATH . '/header.php'); ?>
<?php

// var_dump($user);

$addresses = Address::find_all();

?>

<div class="row justify-content-center">
	<div class="col-4">

		<table class="table table-striped table-bordered my-5">
			<!-- <thead>
				<tr>
					<th>People</th>
					<th>Street</th>
					<th>State</th>
					<th>Zip</th>
				</tr>
			</thead> -->
			<tbody>
				<?php foreach ($addresses as $address) {
				    $u_id = Address::find_users_by_id($address->id);
				    $family = [];
				    foreach ($u_id as $u) {
				        $user = User::find_by_id($u->user_id);
				        $family[] = $user->full_name();
				    } ?>
				<tr>
					<td><b><?php echo implode(", ", $family)?></b>
					</td>
				</tr>
				<tr>
					<td><?php echo $address->street; ?><br>
						<?php echo $address->city . ", " . $address->state . " " . $address->zip;?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

</div>


<?php include(SHARED_PATH . '/footer.php'); ?>