<?php require_once('../../private/initialize.php'); ?>
<?php //require_login();
?>
<?php

// Find all admins
$users = User::find_all();

$year = date('Y');

$exchange = Exchange::find_by_year($year);

if (is_post_request()) {
    // Create record using post parameters
    $args = $_POST['exchange'];
    var_dump($args);
    $year = '';

    foreach ($args as $arg) {
        $item = new Exchange($arg);
        // var_dump($item);
        $year = $item->year;
        $result = $item->save();
        $errors[] = $item->errors;
        if ($result === true) {
            continue;
        } else {
            // show errors
        }
    }

    $msg = 'Gift Exchange names were added successfully.';
    $session->message($msg);
    redirect_to(url_for('/exchange/show.php?year=' . $year));
} else {
    // display the form
    // $exchange = new Exchange();
}

?>
<?php $page_title = 'New Exchange'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div class="users listing pt-5">
	<a class="backlink"
		href="<?php echo url_for('/exchange/index.php'); ?>">&laquo;
		Back to List</a>
	<h1>Exchange</h1>
	<div class="row">
		<div class="col-6">
			<form
				action="<?php echo url_for('/exchange/new.php');?>"
				method="post">

				<table class="table">
					<?php include('form_fields.php');?>

				</table>
				<?php if (!empty($arr)) { ?>
				<button type="submit" class="btn btn-primary">Submit Names</button>
				<?php } ?>
			</form>
		</div>

	</div>
	<!--row-->



</div>


<?php include(SHARED_PATH . '/footer.php'); ?>