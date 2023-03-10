<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if (!isset($exchange)) {
    redirect_to(url_for('/exchange/index.php'));
}
$already_matched = [];
foreach ($exchange as $match) {
    $already_matched[$match->user_id] = $match->match_id;
}
// var_dump($already_matched);

$match_list = [];
foreach ($already_matched as $i) {
    $u = User::find_by_id($i);
    $match_list[] = $u->full_name();
}


$arr = [];
foreach ($users as $user) {
    // var_dump($user);
    if (!in_array($user->id, $already_matched)) {
        $arr[] = $user->id;
    }
}

if (!empty($match_list)) {
    ?>

<p><b><?php echo implode("</b>, <b>", $match_list);?></b>
	already have matches.</p>

<?php
}

if (empty($arr)) {
    return;
} else { ?>

<thead>
	<th>Person</th>
	<th>Match</th>
</thead>
<?php
// var_dump($exchange);

$res = [];
    (shuffle($arr));

    for ($i=0;$i<count($arr);$i++) {
        $res[$arr[$i]] = $arr[$i+1];
    }
    $res[$arr[count($arr)-1]] = $arr[0];
    // print_r($res);
    $i = 0;
    foreach ($res as $key => $value) { ?>
<?php $user = User::find_by_id($key);
        $match = User::find_by_id($value); ?>
<tr>
	<td>
		<input type="text"
			name="exchange[<?php echo $i;?>][user_name]"
			value="<?php echo $user->first_name; ?>" readonly />
		<input type="hidden"
			name="exchange[<?php echo $i;?>][user_id]"
			value="<?php echo $user->id; ?>" />
	</td>
	<td>
		<input type="text"
			name="exchange[<?php echo $i;?>][match_name]"
			value="<?php echo $match->first_name; ?>" readonly />
		<input type="hidden"
			name="exchange[<?php echo $i;?>][match_id]"
			value="<?php echo $match->id; ?>" />
	</td>
</tr>
<?php $i++; ?>
<?php } ?>
<?php } ?>