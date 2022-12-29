<?php
require_once('../../private/initialize.php');
require_login();
require_admin();

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

<div id="content">

	<a class="back-link"
		href="<?php echo url_for('/wishlist/index.php?id=' . $id); ?>">&laquo;
		Back to List</a>

	<div class="user edit">
		<h1>Edit User</h1>

		<?php echo display_errors($user->errors); ?>

		<form
			action="<?php echo url_for('/wishlist/edit.php?id=' . h(u($id)) . '&item=' . h(u($item_id))); ?>"
			method="post">

			<?php include('form_fields.php'); ?>

			<div id="operations">
				<input type="submit" value="Edit Item" />
			</div>
		</form>

	</div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>