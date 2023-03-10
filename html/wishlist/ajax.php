<?php

require_once('../../private/initialize.php');

if (is_post_request()) {
    $args = $_POST['item'];
    // Create record using post parameters
    $id = $args['id'];
    $item = Wishlist::find_by_id($id);
    // echo json_encode($args);

    $item->merge_attributes($args);
    $result = $item->save();
    if ($result === true) {
        if ($args['purchased'] === 1) {
            echo 'Gift was marked as purchased.';
            return;
        } elseif ($args['purchased'] === 0) {
            echo 'Gift was marked as not purchased.';
            return;
        }
    } else {
        // show errors
    }
}
