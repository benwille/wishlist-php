<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Title';
$page_classes[] = '';
$container = '';
?>
<?php include(SHARED_PATH . '/header.php'); ?>
<?php

$current_page = $_GET['page'] ?? 1;
$per_page = 1000;
$total_count = DatabaseObject::count_all();

$pagination = new Pagination($current_page, $per_page, $total_count);

// Find all posts;
//use pagination

$sql = "SELECT * FROM /*table*/ ";
// $sql .= "LIMIT 1 ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$results = DatabaseObject::find_by_sql($sql);

?>
<div class="row">

  <?php foreach ($results as $result) { ?>
    <div class="col-sm-6">
            <section class="card mb-5" id="<?php echo h($result->id); ?>">
                <div class="card-header">
                    <h2 class="card-title"><?php echo h($result->full_name()); ?></h2>
                    <h5 class="card-subtitle"><?php echo h($result->username); ?></h5>
                </div>
                
                <?php if ($admin->is_admin()) { ?>
                <div class="card-footer text-center">
                    <a class="card-link" href="<?php echo url_for('/users/show.php?id=' . h(u($result->id))); ?>">View</a>
                    <a class="card-link" href="<?php echo url_for('/users/edit.php?id=' . h(u($result->id))); ?>">Edit</a>
                    <a class="card-link"
                        href="<?php echo url_for('/users/delete.php?id=' . h(u($result->id))); ?>">Delete</a>
                </div>
                <?php } ?>
            </section>
            <!--end card-->
        </div>
  <?php } ?>

</div>


<?php include(SHARED_PATH . '/footer.php'); ?>