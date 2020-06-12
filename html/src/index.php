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
// $sql .= "ORDER BY rank DESC ";
// $sql .= "LIMIT 1 ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$results = DatabaseObject::find_by_sql($sql);

?>
<div class="row">

  <?php foreach ($results as $result) { ?>
    <div class="col p-2 d-flex justify-content-center" id="<?php echo h(u($result->id)); ?>">
      <a class="action" href="<?php echo url_for('/src/view.php?id=' . h(u($result->id))); ?>">
        <img src="<?php echo url_for('images/placeholder.jpg'); ?>" data-src="<?php echo url_for('images/thumbnails/' . str_pad($result->id, 3, '0', STR_PAD_LEFT) . '.png'); ?>" class="lazy" alt="<?php echo h($result->name()); ?>">
        <!-- <img src="<?php echo url_for('images/thumbnails/' . str_pad($result->id, 3, '0', STR_PAD_LEFT) . '.png'); ?>"  alt="<?php echo h($result->name()); ?>"> -->
      </a>
    </div>
  <?php } ?>

</div>


<?php include(SHARED_PATH . '/footer.php'); ?>