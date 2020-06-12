<?php require_once('../../private/initialize.php'); ?>
<?php //require_login(); ?>
<?php

$id = $_GET['id'] ?? '1'; // PHP > 7.0

$user = User::find_by_id($id);

?>

<?php $page_title = 'Show User: ' . h($user->full_name()); ?>
<?php include(SHARED_PATH . '/header.php'); ?>


  <a class="backlink" href="<?php echo url_for('/users/index.php'); ?>">&laquo; Back to List</a>

  <div class="user show">

    <h1>User: <?php echo h($user->full_name()); ?></h1>

    <div class="attributes">
      <dl>
        <dt>First name</dt>
        <dd><?php echo h($user->first_name); ?></dd>
      </dl>
      <dl>
        <dt>Last name</dt>
        <dd><?php echo h($user->last_name); ?></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><?php echo h($user->username); ?></dd>
      </dl>
      <dl>
        <dt>Role</dt>
        <dd><?php echo $user->is_admin() ? 'Admin' : 'User'; ?></dd>
      </dl>
    </div>
    <a class="card-link" href="<?php echo url_for('/users/edit.php?id=' . h(u($user->id))); ?>">Edit</a>
  </div>

  <?php include(SHARED_PATH . '/footer.php'); ?>
