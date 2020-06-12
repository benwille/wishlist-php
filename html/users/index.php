<?php require_once('../../private/initialize.php'); ?>
<?php //require_login(); 
?>
<?php

// Find all admins
$users = User::find_all();
$admin = User::find_by_username($session->username);


?>
<?php $page_title = 'Users'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div class="users listing">
  <h1>Users</h1>
  <?php if ($admin->is_admin()) { ?>
    <div class="actions">
      <a class="action" href="<?php echo url_for('/users/new.php'); ?>">Add User</a>
    </div>
  <?php } ?>
  <div class="row">
    <?php foreach ($users as $user) { ?>
      <div class="col-sm-6">
        <section class="card mb-5" id="<?php echo h($user->id); ?>">
          <div class="card-header">
            <h2 class="card-title"><?php echo h($user->full_name()); ?></h2>
            <h5 class="card-subtitle"><?php echo h($user->username); ?></h5>
          </div>

          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Role: </strong> <?php echo $user->is_admin() ? 'Admin' : 'User'; ?></li>
          </ul>
          <?php if ($admin->is_admin()) { ?>
            <div class="card-footer text-center">
              <a class="card-link" href="<?php echo url_for('/users/show.php?id=' . h(u($user->id))); ?>">View</a>
              <a class="card-link" href="<?php echo url_for('/users/edit.php?id=' . h(u($user->id))); ?>">Edit</a>
              <a class="card-link" href="<?php echo url_for('/users/delete.php?id=' . h(u($user->id))); ?>">Delete</a>
            </div>
          <?php } ?>
        </section>
        <!--end card-->
      </div>

    <?php } ?>
  </div>
  <!--row-->



</div>


<?php include(SHARED_PATH . '/footer.php'); ?>