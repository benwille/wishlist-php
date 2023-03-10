<?php

require_once('../../private/initialize.php');
require_login();
require_admin();

if (is_post_request()) {
    // Create record using post parameters
    if($_POST['user']) {
        $args = $_POST['user'];
        $user = new User($args);
        $result = $user->save();
        // var_dump($result);
        // die;
        // print_r ($user->sanitized_attributes());
    
    
        if ($result === true) {
            $new_id = $user->id;
            $session->message('The user was created successfully.');
            if(!$_POST['address']) {

                redirect_to(url_for('/users/show.php?id=' . $new_id));
            }
        } else {
            // show errors
        }
    }
    if($_POST['address']) {
        $args = $_POST['address'];
        $address = new Address($args);
        $result = $address->save_address();
        $session->message('it worked');
        
        // if ($result === true) {
        //     // $new_id = $user->id;
        //     // $session->message('The user was created successfully.');
        //     redirect_to(url_for('/users/show.php?id=' . $new_id));
        // } else {
        //     // show errors
        // }

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

	<div class="row">
		<div class="col-md-6">

			<form
				action="<?php echo url_for('/users/new.php'); ?>"
				method="post">

				<?php include('form_fields.php'); ?>

				<button type="submit" class="btn btn-primary">Edit User</button>

			</form>

		</div>
		<div class="col-md-6">
			<form
				action="<?php echo url_for('/users/new.php'); ?>"
				method="post">

				<?php include('address_fields.php'); ?>

			</form>
            <p class="small muted ml-2">Don't see your address? Talk to the admin to get it added.</p>
		</div>
	</div>

</div>


<?php include(SHARED_PATH . '/footer.php'); ?>