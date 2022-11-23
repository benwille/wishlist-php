<?php require_once('../private/initialize.php'); ?>

<?php
$page_title = 'Home';
$page_classes[] = 'home';


$users = User::find_all();

?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div class="row justify-content-center my-5">
	<a href="###" class="btn">Button</a>
</div>

<div id="accordion">
	<?php foreach ($users as $user) { ?>
	<div class="card">
		<div class="card-header" id="heading<?php echo $user->concat_name();?>">
			<h5 class="mb-0 d-flex collapsed" data-toggle="collapse" data-target="#collapse<?php echo $user->concat_name();?>" aria-expanded="false"
					aria-controls="collapse<?php echo $user->concat_name();?>">
				<button class="btn btn-link">
					<?php echo $user->full_name(); ?>

				</button>
				<div class="ml-auto btn">
					<i class="ml-auto fa fa-caret-right" aria-hidden="true"></i>
				</div>

			</h5>
		</div>

		<div id="collapse<?php echo $user->concat_name();?>" class="collapse" aria-labelledby="heading<?php echo $user->concat_name();?>" data-parent="#accordion">
			<div class="card-body">
				<?php 
					$list = Wishlist::find_by_user($user->id);
					// var_dump($list);
					
				?>
				<div class="row justify-content-center">
					<table class="table">
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
									<td>Added: <?php echo $item->year_added;?></td>
									<?php if ($session->admin_id() !== $user->id) { ?>
										<td><input type="checkbox" aria-label="Checkbox for following text input"> gifted</td>
									<?php } ?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div><!-- accordion -->
<?php include(SHARED_PATH . '/footer.php'); ?>