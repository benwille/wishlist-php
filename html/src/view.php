<?php require_once('../../private/initialize.php'); ?>
<?php
$page_classes[] = '';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$result = DatabaseObject::find_by_id($id);


?>

<?php $page_title = h($result->name()); ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="" class="position-relative">

  <a class="back-link" href="<?php echo url_for("/src/index.php"); ?>"><svg id="Layer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 384">
      <title>close</title>
      <path d="M256,64C150.13,64,64,150.13,64,256s86.13,192,192,192,192-86.13,192-192S361.87,64,256,64Zm0,352c-88.22,0-160-71.78-160-160S167.78,96,256,96s160,71.78,160,160S344.22,416,256,416Z" transform="translate(-64 -64)" />
      <path d="M315.31,196.69a16,16,0,0,0-22.62,0L256,233.38l-36.69-36.69a16,16,0,0,0-22.62,22.62L233.38,256l-36.69,36.69a16,16,0,1,0,22.62,22.62L256,278.62l36.69,36.69a16,16,0,0,0,22.62-22.62L278.62,256l36.69-36.69a16,16,0,0,0,0-22.62Z" transform="translate(-64 -64)" />
    </svg></a>

  <div class="user show">

    <h1>Result: <?php echo h($result->full_name()); ?></h1>

    <div class="attributes">
      <dl>
        <dt>First name</dt>
        <dd><?php echo h($result->first_name); ?></dd>
      </dl>
      <dl>
        <dt>Last name</dt>
        <dd><?php echo h($result->last_name); ?></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><?php echo h($result->username); ?></dd>
      </dl>
      <dl>
        <dt>Role</dt>
        <dd><?php echo $result->is_admin() ? 'Admin' : 'User'; ?></dd>
      </dl>
    </div>
    <a class="card-link" href="<?php echo url_for('/src/edit.php?id=' . h(u($result->id))); ?>">Edit</a>
  </div>

  <?php include(SHARED_PATH . '/footer.php'); ?>