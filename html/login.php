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
      redirect_to(url_for('/users/pokemon.php?id=' . h(u($session->admin_id()))));
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

<h1 class="text-white mt-5">Log in</h1>

<?php echo display_errors($errors); ?>

<a class="back-link" href="<?php echo url_for('/index.php'); ?>" style="bottom: 65px"><svg id="Layer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 384"><title>close</title><path d="M256,64C150.13,64,64,150.13,64,256s86.13,192,192,192,192-86.13,192-192S361.87,64,256,64Zm0,352c-88.22,0-160-71.78-160-160S167.78,96,256,96s160,71.78,160,160S344.22,416,256,416Z" transform="translate(-64 -64)"/><path d="M315.31,196.69a16,16,0,0,0-22.62,0L256,233.38l-36.69-36.69a16,16,0,0,0-22.62,22.62L233.38,256l-36.69,36.69a16,16,0,1,0,22.62,22.62L256,278.62l36.69,36.69a16,16,0,0,0,22.62-22.62L278.62,256l36.69-36.69a16,16,0,0,0,0-22.62Z" transform="translate(-64 -64)"/></svg></a>

<form action="login.php" method="post">
  <div class="form-group">
    <label for="inputUsername">Username</label>
    <input type="text" name="username" class="form-control" value="<?php echo h($username); ?>" id="inputUsername">
  </div>
  <div class="form-group">
    <label for="inputPassword">Password</label>
    <input type="password" name="password" value="" class="form-control" id="inputPassword">
  </div>
  <button type="submit" name="submit" class="btn btn-danger">Login</button>
</form>


<?php include(SHARED_PATH . '/footer.php'); ?>