<?php

require_once('../../private/initialize.php');
require_login();
require_admin();

if (is_post_request()) {
    // Create record using post parameters
    $args = $_POST['user'];
    $user = new User($args);
    $admin = User::find_by_username($session->username);
    $result = $user->save();
    // var_dump($result);
    // die;
    // print_r ($user->sanitized_attributes());


    if ($result === true) {
        $new_id = $user->id;
        // $session->message('The user was created successfully.');
        redirect_to(url_for('/users/show.php?id=' . $new_id));
    } else {
        // show errors
    }
} else {
    // display the form
    $user = new User();
}

?>

<?php $page_title = 'Create User'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>



<div class="user new pt-5">
	<a class="backlink"
		href="<?php echo url_for('/users/index.php'); ?>">&laquo;
		Back to List</a>
	<h1>Create User</h1>

	<?php echo display_errors($user->errors); ?>

	<form
		action="<?php echo url_for('/users/new.php'); ?>"
		method="post">

		<?php include('form_fields.php'); ?>

		<button type="submit" class="btn btn-primary">Create User</button>

	</form>

</div>


<?php include(SHARED_PATH . '/footer.php'); ?>