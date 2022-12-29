<?php
require_once('../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if (is_post_request()) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validations
    if (is_blank($username)) {
        $errors[] = "Username cannot be blank.";
    }
    if (is_blank($password)) {
        $errors[] = "Password cannot be blank.";
    }

    // if there were no errors, try to login
    if (empty($errors)) {
        $user = User::find_by_username($username);
        // test if user found and password is correct
        if ($user != false && $user->verify_password($password)) {
            // Mark admin as logged in
            $session->login($user);
            // redirect_to(url_for('/users/show.php?id=' . h(u($session->admin_id()))));
            redirect_to(url_for('/'));
        } else {
            // username not found or password does not match
            $errors[] = "Log in was unsuccessful.";
        }
    }
}

?>

<?php $page_title = 'Log in'; ?>
<?php $page_classes[] = "login"; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<h1 class="pt-5">Log in</h1>

<?php echo display_errors($errors); ?>

<form action="login.php" method="post">
	<div class="form-group">
		<label for="inputUsername">Username</label>
		<input type="text" name="username" class="form-control"
			value="<?php echo h($username); ?>" id="inputUsername">
	</div>
	<div class="form-group">
		<label for="inputPassword">Password</label>
		<input type="password" name="password" value="" class="form-control" id="inputPassword">
	</div>
	<button type="submit" name="submit" class="btn btn-danger">Login</button>
</form>


<?php include(SHARED_PATH . '/footer.php'); ?>