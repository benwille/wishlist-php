<?php require_once('../../private/initialize.php'); ?>
<?php
require_login();


if (!isset($_GET['id'])) {
    redirect_to(url_for('/index.php'));
}
$id = $_GET['id'];
$user = User::find_by_id($id);
if ($user == false) {
    redirect_to(url_for('/index.php'));
}

?>
<?php $page_title = 'My Wishlist';
$page_classes[] = '';
$container = '';
?>
<?php include(SHARED_PATH . '/header.php'); ?>
<?php

// var_dump($user);

$list = Wishlist::find_by_user($user->id)

?>
<div class="row pt-5 justify-content-center">
	<a href="<?php echo url_for('/wishlist/new.php?id=' . h($user->id));?>" class="btn btn-success btn-sm">+ Add Gift</a>
	<a href="<?php echo url_for('/users/edit.php?id=' . h($user->id));?>" class="btn btn-primary btn-sm">Update Password</a>
</div>
<div class="row">

	<table class="table table-sm table-striped my-5">
											
						<tbody>
							<?php foreach ($list as $item) { ?>
								<tr>
									<td scope="row">
										<?php if($item->link) { ?>
											<a href="<?php echo $item->link; ?>" target="_blank" class=""><?php echo $item->item_name; ?></a>
										<?php } else {
													echo $item->item_name;
												} ?>
											</td>
									<td><?php echo $item->description; ?></td>
									<td class="col-1 text-right"><a href="<?php echo url_for('/wishlist/edit.php?id=' . h(u($user->id)) . '&item=' . h(u($item->id))); ?>" class="btn btn-primary btn-sm">Edit</a></td>
									<td class="col-1"><a class="btn btn-primary btn-sm" href="<?php echo url_for('/wishlist/delete.php?id=' . h(u($user->id)) . '&item=' . h(u($item->id))); ?>">Delete</a></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

</div>


<?php include(SHARED_PATH . '/footer.php'); ?>