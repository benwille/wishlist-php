<?php

require_once('../../private/initialize.php');
require_login();
require_admin();

if (!isset($_GET['id'])) {
  redirect_to(url_for('/index.php'));
}
$id = $_GET['id'];

$item_id = $_GET['item'];
$item = Wishlist::find_by_id($item_id);
if ($item == false) {
    redirect_to(url_for('/wishlist/index.php'));
}


if (is_post_request()) {

  // Delete item
  $result = $item->delete();
  $session->message('The gift was deleted successfully.');
  redirect_to(url_for('/wishlist/index.php?id=' . $id));
} else {
  // Display form
}

?>

<?php $page_title = 'Delete Gift'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/wishlist/index.php?id=' . h($id)); ?>">&laquo; Back to List</a>

  <div class="gift delete">
    <h1>Delete Gift</h1>
    <p>Are you sure you want to delete this gift?</p>
    <p class="item"><?php echo h($item->item_name); ?></p>

    <form action="<?php echo url_for('/wishlist/delete.php?id=' . h(u($id)) . '&item=' . h(u($item->id))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Gift" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>