<?php

require_once('../../private/initialize.php');
require_login();
require_admin();


if (is_post_request()) {
    // Create record using post parameters
    $args = $_POST['address'];
    $address = new Address($args);
    $result = $address->save();
    // print_r($results->sanitized_attributes());


    if ($result === true) {
        $new_id = $item->id;
        $session->message('The address was added successfully.');
        redirect_to(url_for('/addresses/index.php?id=' . $id));
    } else {
        // show errors
    }
} else {
    // display the form
    $address = new Address();
}

?>

<?php $page_title = 'Add New Address'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div class="address new pt-5">

	<a class="back-link"
		href="<?php echo url_for('/addresses'); ?>">&laquo;
		Back to List</a>

	<div class="item new">
		<h1>Add New Address</h1>

		<?php echo display_errors($address->errors); ?>

		<form
			action="<?php echo url_for('/addresses/new.php'); ?>"
			method="post">

			<?php include('form_fields.php'); ?>

			<div id="operations">
				<input type="submit" class="btn btn-primary" value="Add Address" />
			</div>
		</form>

	</div>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>