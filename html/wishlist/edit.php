<?php
require_once('../../private/initialize.php');
require_login();
// require_admin();

if (!isset($_GET['id'])) {
    redirect_to(url_for('/index.php'));
}
$id = $_GET['id'];
$item_id = $_GET['item'];
$item = Wishlist::find_by_id($item_id);
if ($item == false) {
    redirect_to(url_for('/wishlist/index.php'));
}
// $list = Wishlist::find_by_user($user->id);

if (is_post_request()) {
    // Save record using post parameters
    $args = $_POST['item'];
    $item->merge_attributes($args);
    $result = $item->save();

    if ($result === true) {
        $session->message('The gift was updated successfully.');
        redirect_to(url_for('/wishlist/index.php?id=' . $id));
    } else {
        // show errors
    }
} else {
    // display the form
}

?>

<?php $page_title = 'Edit Item'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>



<div class="user edit pt-5">
	<a class="back-link"
		href="<?php echo url_for('/wishlist/index.php?id=' . $id); ?>">&laquo;
		Back to List</a>
	<h1>Edit Item</h1>

	<?php echo display_errors($user->errors); ?>

	<form
		action="<?php echo url_for('/wishlist/edit.php?id=' . h(u($id)) . '&item=' . h(u($item_id))); ?>"
		method="post">

		<?php include('form_fields.php'); ?>

		<div id="operations">
			<input type="submit" class="btn btn-primary" value="Edit Item" />
		</div>
	</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>