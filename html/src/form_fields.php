<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if (!isset($user)) {
  redirect_to(url_for('/users/index.php'));
}
?>

<dl>
  <dt>First name</dt>
  <dd><input type="text" name="user[first_name]" value="<?php echo h($user->first_name); ?>" /></dd>
</dl>

<dl>
  <dt>Last name</dt>
  <dd><input type="text" name="user[last_name]" value="<?php echo h($user->last_name); ?>" /></dd>
</dl>

<dl>
  <dt>Email</dt>
  <dd><input type="text" name="user[email]" value="<?php echo h($user->email); ?>" /></dd>
</dl>

<dl>
  <dt>Username</dt>
  <dd><input type="text" name="user[username]" value="<?php echo h($user->username); ?>" /></dd>
</dl>

<dl>
  <dt>Password</dt>
  <dd><input type="password" name="user[password]" value="" /></dd>
</dl>

<dl>
  <dt>Confirm Password</dt>
  <dd><input type="password" name="user[confirm_password]" value="" /></dd>
</dl>

<dl>
  <dt>Is admin?</dt>
  <dd>
    <input type="hidden" name="is_admin" value="0" />
    <input type="checkbox" name="is_admin" value="1" <?php if ($user->is_admin()) {
                                                        echo " checked";
                                                      } ?> />
  </dd>
</dl>