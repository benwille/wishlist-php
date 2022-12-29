<!doctype html>
<?php
// $start = microtime(true);
$loginTime = $_SESSION['last_login'] ?? null;
if ($loginTime) {
    $loginDate = date("M d h:i:s A", $loginTime);
}
$msg = $loginDate ?? 'Not logged in';
echo '<script>console.log("' . $msg . '");</script>';
?>
<html lang="en">

<head>
	<title>Wishlist
		<?php if (isset($page_title)) {
		    echo ' - ' . h($page_title);
		} ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400&display=swap" rel="stylesheet">
	<link rel="stylesheet" media="all"
		href="<?php echo url_for('/css/theme.min.css'); ?>" />
	<link rel="shortcut icon"
		href="<?php echo url_for('/images/favicon.png');?>"
		type="image/x-icon">
	<link rel="icon"
		href="<?php echo url_for('/images/favicon.png');?>"
		type="image/x-icon">
	<link rel="apple-touch-icon"
		href="<?php echo url_for('/images/apple-touch-icon.png'); ?>">
	<link rel="apple-touch-icon" size="152x152"
		href="<?php echo url_for('/images/apple-touch-icon-ipad.png'); ?>">
	<link rel='manifest' href='/manifest.json'>
	<meta name="theme-color" content="#ef5350">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-touch-icon.png'); ?>">
	<!-- iOS Splash Screen Images -->
	<link rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-splash-640.png'); ?>"
		media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
	<link rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-splash-750.png'); ?>"
		media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
	<link rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-splash-1242.png'); ?>"
		media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
	<link rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-splash-828.png'); ?>"
		media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
	<link rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-splash-1125.png'); ?>"
		media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
	<link rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-splash-1536.png'); ?>"
		media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
	<link rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-splash-1668.png'); ?>"
		media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
	<link rel="apple-touch-startup-image"
		href="<?php echo url_for('/images/apple-splash-2048.png'); ?>"
		media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">

	<?php // TODO: decide what JS files you want to include?>

	<!-- <script src="<?php echo url_for('/js/yall.min.js'); ?>">
	</script> -->
	<!-- <script src="<?php echo url_for('/js/app.js'); ?>">
	</script> -->
	<!-- <script>
    document.addEventListener("DOMContentLoaded", yall);
  </script> -->

	<?php // TODO:?>
	<meta property="og:url" content="<?php echo getURL(); ?>" />
	<meta property="og:title"
		content="<?php echo h($page_title); ?>" />
	<meta property="og:description" content="<?php // TODO:?>" />
	<meta property="og:image"
		content="<?php // TODO: echo url_for('');?>" />

</head>

<body <?php if ($page_classes) : ?>
	class="<?php echo implode(", ", $page_classes); ?>"
	<?php endif; ?>>

	<header class="bg-success">
		<div class="container">
			<nav class="navbar navbar-dark navbar-expand-md">
				<div class="container">
					<a
						href="<?php echo url_for('/index.php'); ?>">
						<img class="wordmark"
							src="<?php //TODO: echo url_for('')?>"
							alt="" />
					</a>

					<button class="navbar-toggler mb-2" type="button" data-toggle="collapse" data-target="#myTogglerNav"
						aria-controls="myTogglerNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse text-right" id="myTogglerNav">
						<div class="navbar-nav ml-3 w-100 flex-wrap">
							<a class="nav-item nav-link"
								href="<?php echo url_for('/'); ?>">Everyone's
								Wishlist</a>
							<a class="nav-item nav-link"
								href="<?php echo url_for('/wishlist/?id=' . h(u($session->admin_id()))); ?>">My
								Wishlist</a>
							<a class="nav-item nav-link"
								href="<?php echo url_for('/exchange/index.php'); ?>">Gift
								Exchange</a>
							<a class="nav-item nav-link"
								href="<?php echo url_for('/addresses/index.php'); ?>">Addresses</a>
							<a class="nav-item nav-link"
								href="<?php echo url_for('/users/show.php?id=' . h(u($session->admin_id()))); ?>">My
								Account</a>
							<?php if ($admin && $admin->is_admin()) {?>
							<a class="nav-item nav-link"
								href="<?php echo url_for('/users/index.php'); ?>">Admin</a>
							<?php }?>
							<a class="nav-item nav-link ml-xl-auto"
								href="<?php echo url_for('/logout.php'); ?>">Logout</a>
						</div><!-- navbar-->

					</div><!-- navbar -->
				</div><!--container-->

			</nav><!-- nav -->

		</div>

	</header><!-- Header Container -->

	<div class="<?php echo $container ?: 'container'; ?>"
		id="content">
		<?php echo display_session_message();?>