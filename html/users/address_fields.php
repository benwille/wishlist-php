<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
$addresses = Address::find_all();

// if (!isset($address)) {
//     redirect_to(url_for('/addresses/index.php'));
// }
?>


<label for="addressSelect">Address</label>
<div class="input-group">

	<select class="custom-select" id="addressSelect" name="address[address_id]">
		<option value="0">-------</option>
		<?php foreach ($addresses as $a) { ?>
		<option value="<?php echo $a->id;?>" <?php if($address && $address->address_id() === $a->id) { echo 'selected'; } ?>>
			<?php echo $a->street . ' ' . $a->city . ', ' . $a->state . ' ' . $a->zip;?>
		</option>
		<?php } ?>
	</select>
	<div class="input-group-append">
		<button class="btn btn-primary" type="submit">Update</button>
	</div>
</div>
<small class="form-text text-muted text-right">If your address isn't on the list, please contact the admin.</small>
<input type="hidden" name="address[user_id]" value="<?php echo $user->id;?>">