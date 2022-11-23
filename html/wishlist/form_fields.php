<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if (!isset($item)) {
  redirect_to(url_for('/wishlist/index.php'));
}
?>

<input type="hidden" name="item[user_id]" value="<?php echo h($id);?>">
<input type="hidden" name="item[year_added]" value="<?php echo date('Y'); ?>">
<dl>
  <dt>Item name</dt>
  <dd><input type="text" name="item[item_name]" value="<?php echo h($item->item_name); ?>" /></dd>
</dl>

<dl>
  <dt>Description</dt>
  <dd><textarea type="text" name="item[description]" /><?php echo h($item->description); ?></textarea></dd>
  
</dl>

<dl>
  <dt>Link</dt>
  <dd><input type="url" name="item[link]" value="<?php echo h($item->link); ?>" /></dd>
</dl>