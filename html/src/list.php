<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = '';
$page_classes[] = '';
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

foreach ($results as $result) {
  $result->types = unserialize($result->types);
}

$json = json_encode($result);

echo $json;

die;
?>

<div id="content">
  <div class="tasks listing">
    <h1><?php echo $page_title; ?></h1>
    <?php //echo display_errors($post->errors);
    ?>
    <span class="message"></span>
    <div class="table-responsive">
      <table class="list table">
        <tr>
          <th>Name</th>
          <th>ID</th>
          <th>Weight</th>
          <th>Height</th>
          <th>Rarity</th>
          <th>Image</th>
          <th>&nbsp;</th>
        </tr>

        <?php foreach ($results as $result) { ?>
          <tr class="pokemon-card">
            <td class="text-capitalize"><?php echo h($result->name); ?></td>
            <td><?php echo h($result->id); ?></td>
            <td><?php echo h($result->weight()); ?> lbs</td>
            <td><?php echo h($result->height()); ?></td>
            <td><?php echo h($result->rarity); ?></td>
            <td><img src="<?php echo url_for('images/' . str_pad($result->id, 3, '0', STR_PAD_LEFT) . '.png'); ?>"></td>
            <td><a class="action" href="<?php echo url_for('/src/vew.php?id=' . h(u($result->id))); ?>">View</a></td>
          </tr>
        <?php } ?>
      </table>
    </div>

    <?php
    $url = url_for('/src/index.php');
    echo $pagination->page_links($url);
    ?>

  </div>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>