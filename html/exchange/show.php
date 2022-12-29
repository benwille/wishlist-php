<?php require_once('../../private/initialize.php'); ?>
<?php require_login();?>
<?php

$year = $_GET['year'] ?? date('Y'); // PHP > 7.0

$exchange = Exchange::find_by_year($year);

?>

<?php $page_title = 'Show Gift Exchange: ' . h($year); ?>
<?php include(SHARED_PATH . '/header.php'); ?>



<div class="exchange show pt-5">
	<a class="backlink"
		href="<?php echo url_for('/exchange/index.php'); ?>">&laquo;
		Back to List</a>

	<h1>Year: <?php echo h($year); ?></h1>

	<div class="attributes">
		<?php foreach ($exchange as $match) { ?>
		<dl>
			<dt><?php echo $match->get_name($match->user_id);?></dt>
			<dd><?php echo $match->get_name($match->match_id); ?>
			</dd>
		</dl>
		<?php } ?>

	</div>
	<!-- <a class="card-link"
		href="<?php echo url_for('/users/edit.php?id=' . h(u($user->id))); ?>">Edit</a>
	-->
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>