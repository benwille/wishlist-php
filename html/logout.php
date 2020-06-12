<?php
require_once('../private/initialize.php');

// Log out the admin
$session->logout($user);

redirect_to(url_for('/login.php'));

?>
