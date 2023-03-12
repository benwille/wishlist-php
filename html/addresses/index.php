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

<div class="addresses index pt-5">
	<?php  if ($admin->is_admin()) {?>
	<div class="actions">
		<a class="action"
			href="<?php echo url_for('/addresses/new.php'); ?>">Add
			Address</a>
	</div>
	<?php }?>
	<h1>Addresses</h1>
	<div class="row justify-content-center">
		<div class="col-md-8 col-xl-4">

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
					<?php if ($admin->is_admin()) { ?>
					<tr class="card-footer text-center">
						<td>

							<a class="card-link"
								href="<?php echo url_for('/addresses/edit.php?id=' . h(u($user->id))); ?>">Edit</a>
							<a class="card-link"
								href="<?php echo url_for('/addresses/delete.php?id=' . h(u($user->id))); ?>">Delete</a>
						</td>
					</tr>
					<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>

	</div>

</div>
	<?php include(SHARED_PATH . '/footer.php'); ?>