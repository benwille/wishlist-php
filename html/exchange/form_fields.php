<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if (!isset($exchange)) {
    redirect_to(url_for('/exchange/index.php'));
}

$assignments = [];
$remaining = $people;

do {
    $valid = true; // Assume the current shuffle will work
    $assignments = [];

    // Assign each person to the next in the list
    for ($i = 0; $i < count($people); $i++) {
        $assigner = $people[$i];
        $assignee = $people[($i + 1) % count($people)]; // Circular assignment

        if (!User::isValidAssignment($assigner, $assignee, $database, $year)) {
            $valid = false;
            shuffle($people); // Re-shuffle if invalid assignment
            break;
        }

        $assignments[] = [$assigner, $assignee];
    }
} while (!$valid); // Repeat until a valid arrangement is found

?>

<thead>
	<th>Person</th>
	<th>Match</th>
</thead>
<?php
    $i = 0;
    foreach ($assignments as $assignment) {  
        $user = User::find_by_id($assignment[0]);
        $match = User::find_by_id($assignment[1]); 
?>
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
<?php } // end foreach ?>