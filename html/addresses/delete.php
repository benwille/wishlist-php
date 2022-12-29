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
    // Delete item
    $result = $item->delete();
    $session->message('The address was deleted successfully.');
    redirect_to(url_for('/addresses/index.php?id=' . $id));
} else {
    // Display form
}

?>

<?php $page_title = 'Delete Address'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>



<div class="address delete pt-5">
	<a class="back-link"
		href="<?php echo url_for('/addresses/index.php?id=' . h($id)); ?>">&laquo;
		Back to List</a>
	<h1>Delete Address</h1>
	<p>Are you sure you want to delete this address?</p>
	<p class="item"><?php echo h($address->street); ?></p>

	<form
		action="<?php echo url_for('/wishlist/delete.php?id=' . h(u($id)) . '&item=' . h(u($item->id))); ?>"
		method="post">
		<div id="operations">
			<input type="submit" class="btn btn-primary" name="commit" value="Delete Address" />
		</div>
	</form>
</div>


<?php include(SHARED_PATH . '/footer.php'); ?>