<?php

require_once('../../private/initialize.php');

require_login();
//require_admin();

if (!isset($_GET['id'])) {
    redirect_to(url_for('/users/index.php'));
}
$id = $_GET['id'];
$user = User::find_by_id($id);
if ($user == false) {
    redirect_to(url_for('/users/index.php'));
}

if (is_post_request()) {
    // Save record using post parameters
    $args = $_POST['user'];
    $user->merge_attributes($args);
    $result = $user->save();

    if ($result === true) {
        $session->message('The user was updated successfully.');
        redirect_to(url_for('/users/show.php?id=' . $id));
    } else {
        // show errors
    }
} else {
    // display the form
}

?>

<?php $page_title = 'Edit User'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>




<div class="user edit pt-5">
	<a class="backlink"
		href="<?php echo url_for('/users/index.php'); ?>">&laquo;
		Back to List</a>
	<h1>Edit User</h1>

	<?php echo display_errors($user->errors); ?>

	<form
		action="<?php echo url_for('/users/edit.php?id=' . h(u($id))); ?>"
		method="post">

		<?php include('form_fields.php'); ?>

		<button type="submit" class="btn btn-primary">Edit User</button>

	</form>

</div>



<?php include(SHARED_PATH . '/footer.php'); ?>