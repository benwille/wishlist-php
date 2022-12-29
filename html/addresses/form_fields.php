<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if (!isset($address)) {
    redirect_to(url_for('/addresses/index.php'));
}
?>

<div class="form-group">
	<label for="inputAddress">Address</label>
	<input type="text" name="address[street]" class="form-control"
		value="<?php echo h($address->street); ?>" id="inputAddress">
</div>
<div class="row">

	<div class="form-group col-md-4">
		<label for="inputCity">City</label>
		<input type="text" name="address[city]" class="form-control"
			value="<?php echo h($address->city); ?>" id="inputCity">
	</div>
	<div class="form-group col-md-4">
		<label for="inputState">State</label>
		<input type="text" name="address[state]" class="form-control"
			value="<?php echo h($address->state); ?>"
			id="inputState">
	</div>
	<div class="form-group col-md-4">
		<label for="inputZip">Zip Code</label>
		<input type="text" name="address[zip]" class="form-control"
			value="<?php echo h($address->zip); ?>" id="inputZip"
			pattern="[0-9]{5}" title="5 digit zip code">
	</div>
</div>