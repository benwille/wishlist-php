<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if (!isset($user)) {
    redirect_to(url_for('/users/index.php'));
}
?>


<div class="form-group">
	<label for="inputFirstName">First Name</label>
	<input type="text" name="user[first_name]" class="form-control"
		value="<?php echo h($user->first_name); ?>"
		id="inputFirstName">
</div>
<div class="form-group">
	<label for="inputLastName">Last Name</label>
	<input type="text" name="user[last_name]" class="form-control"
		value="<?php echo h($user->last_name); ?>"
		id="inputLastName">
</div>
<div class="form-group">
	<label for="inputUsername">Username</label>
	<input type="text" name="user[username]" class="form-control"
		value="<?php echo h($user->username); ?>" id="inputUsername">
</div>
<div class="form-group">
	<label for="inputPassword">Password</label>
	<input type="password" name="user[password]" value="" class="form-control" id="inputPassword">
</div>
<div class="form-group">
	<label for="inputPasswordConfirm">Confirm Password</label>
	<input type="password" name="user[confirm_password]" value="" class="form-control" id="inputPasswordConfirm">
</div>
<?php if ($admin->is_admin()) { ?>
<div class="form-group form-check">
	<input type="hidden" name="user[is_admin]" value="0" />
	<input type="checkbox" name="user[is_admin]" value="1" <?php if ($user->is_admin()) {
	    echo " checked";
	} ?>
	class="form-check-input" id="inputIsAdmin">
	<label class="form-check-label" for="inputIsAdmin">Is Admin?</label>
</div>
<?php } ?>