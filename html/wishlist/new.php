<?php

require_once('../../private/initialize.php');
require_login();
// require_admin();


if (!isset($_GET['id'])) {
    redirect_to(url_for('/index.php'));
}
$id = $_GET['id'];


if (is_post_request()) {
    // Create record using post parameters
    $args = $_POST['item'];
    $item = new Wishlist($args);
    $result = $item->save();
    // print_r($results->sanitized_attributes());


    if ($result === true) {
        $new_id = $item->id;
        $session->message('The gift idea was added successfully.');
        redirect_to(url_for('/wishlist/index.php?id=' . $id));
    } else {
        // show errors
    }
} else {
    // display the form
    $item = new Wishlist();
}

?>

<?php $page_title = 'Add Gift Idea'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div class="item new pt-5">

	<a class="back-link"
		href="<?php echo url_for('/wishlist/index.php?id=' . $id); ?>">&laquo;
		Back to List</a>
	<h1 class="">Add Gift</h1>

	<?php echo display_errors($user->errors); ?>

	<form
		action="<?php echo url_for('/wishlist/new.php?id=' . h($id)); ?>"
		method="post">

		<?php include('form_fields.php'); ?>

		<div id="operations">
			<input type="submit" class="btn btn-primary" value="Add Gift" />
		</div>
	</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>