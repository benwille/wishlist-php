<?php require_once('../private/initialize.php'); ?>

<?php
$page_title = 'Home';
$page_classes[] = 'home';
?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div class="row justify-content-center my-5">
	<a href="###" class="btn">Button</a>
</div>
<div class="row justify-content-center my-5">
	<a href="<?php echo !$session->is_logged_in() ? 'login.php' : 'logout.php'; ?>" class="btn "><?php echo !$session->is_logged_in() ? 'Login' : 'Logout'; ?></a>
</div>
<?php include(SHARED_PATH . '/footer.php'); ?>