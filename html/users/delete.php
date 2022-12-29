<?php

require_once('../../private/initialize.php');
require_login();
require_admin();

if (!isset($_GET['id'])) {
    redirect_to(url_for('/users/index.php'));
}
$id = $_GET['id'];
$user = User::find_by_id($id);
if ($user == false) {
    redirect_to(url_for('/users/index.php'));
}

if (is_post_request()) {
    // Delete task
    $user->delete();
    $session->message('The user was deleted successfully.');
    redirect_to(url_for('/users/index.php'));
} else {
    // Display form
}

?>

<?php $page_title = 'Delete User'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>




<div class="users delete pt-5">
	<a class="backlink"
		href="<?php echo url_for('/users/index.php'); ?>">&laquo;
		Back to List</a>
	<h1>Delete User</h1>
	<p>Are you sure you want to delete this user?</p>
	<p class="item font-weight-bold">
		<?php echo h($user->full_name()); ?>
	</p>

	<form
		action="<?php echo url_for('/users/delete.php?id=' . h(u($id))); ?>"
		method="post">
		<div class="form-group row" id="operations">
			<div class="col-auto">
				<button class="btn btn-primary" type="submit" name="commit" value="Delete User">Delete User</button>
			</div>
		</div>
	</form>
</div>



<?php include(SHARED_PATH . '/footer.php'); ?>