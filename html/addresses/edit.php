<?php
require_once('../../private/initialize.php');
require_login();
require_admin();

if (!isset($_GET['id'])) {
    redirect_to(url_for('/addresses/index.php'));
}
$id = $_GET['id'];
$address = Address::find_by_id($id);

if ($address == false) {
    redirect_to(url_for('/addresses/index.php'));
}


if (is_post_request()) {
    // Save record using post parameters
    $args = $_POST['address'];
    $address->merge_attributes($args);
    $result = $address->save();

    if ($result === true) {
        $session->message('The address was updated successfully.');
        redirect_to(url_for('/addresses/index.php?id=' . $id));
    } else {
        // show errors
    }
} else {
    // display the form
}

?>

<?php $page_title = 'Edit Address'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>



<div class="address edit pt-5">
	<a class="back-link"
		href="<?php echo url_for('/addresses/index.php?id=' . $id); ?>">&laquo;
		Back to List</a>
	<h1>Edit Address</h1>

	<?php echo display_errors($user->errors); ?>

	<form
		action="<?php echo url_for('/addresses/edit.php?id=' . h(u($id)) . '&item=' . h(u($item_id))); ?>"
		method="post">

		<?php include('form_fields.php'); ?>

		<div id="operations">
			<input type="submit" class="btn btn-primary" value="Edit Address" />
		</div>
	</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>