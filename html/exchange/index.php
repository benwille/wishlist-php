<?php require_once('../../private/initialize.php'); ?>
<?php require_login();
?>
<?php

// Find all admins
$users = User::find_all();

$year = date('Y');

$exchange = Exchange::find_by_year($year);
$years = Exchange::find_all_years();
// var_dump($exchange);

?>
<?php $page_title = 'Gift Exchange: ' . h($year); ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div class="users listing pt-5">
	<h1><?php echo h($year);?> Exchange</h1>
	<?php if ($admin->is_admin()) {?>
	<div class="actions">
		<a class="action"
			href="<?php echo url_for('/exchange/new.php'); ?>">New
			Gift Exchange</a>
	</div>
	<?php }?>
	<div class="row pt-5 justify-content-center">

		<?php
        $x = 1;
foreach ($years as $year) {
    echo '<a href="' . url_for("/exchange/show.php?year=" . $year) . '">' . $year . '</a> ';
    if ($x < count($years)) {
        echo '&nbsp;|&nbsp;';
    }
    $x++;
} ?>
	</div>
	<div class="row">
		<div class="col-6">


			<table class="table">
				<thead>
					<th>Person</th>
					<th>Match</th>
				</thead>
				<tbody>
					<?php foreach ($exchange as $match) { ?>
					<tr>
						<td><?php echo $match->get_name($match->user_id);?>
						</td>
						<td><?php echo $match->get_name($match->match_id); ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>

			</table>

			</form>
		</div>

	</div>
	<!--row-->



</div>


<?php include(SHARED_PATH . '/footer.php'); ?>