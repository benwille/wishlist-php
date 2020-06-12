<?php

  // is_blank('abcd')
  // * validate data presence
  // * uses trim() so empty spaces don't count
  // * uses === to avoid false positives
  // * better than empty() which considers "0" to be empty
  function is_blank($value) {
    return !isset($value) || trim($value) === '';
  }

  // has_presence('abcd')
  // * validate data presence
  // * reverse of is_blank()
  // * I prefer validation names with "has_"
  function has_presence($value) {
    return !is_blank($value);
  }

  // has_length_greater_than('abcd', 3)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length_greater_than($value, $min) {
    $length = strlen($value);
    return $length > $min;
  }

  // has_length_less_than('abcd', 5)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
  }

  // has_length_exactly('abcd', 4)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length_exactly($value, $exact) {
    $length = strlen($value);
    return $length == $exact;
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  // * validate string length
  // * combines functions_greater_than, _less_than, _exactly
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length($value, $options) {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
      return false;
    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
      return false;
    } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_inclusion_of( 5, [1,3,5,7,9] )
  // * validate inclusion in a set
  function has_inclusion_of($value, $set) {
  	return in_array($value, $set);
  }

  // has_exclusion_of( 5, [1,3,5,7,9] )
  // * validate exclusion from a set
  function has_exclusion_of($value, $set) {
    return !in_array($value, $set);
  }

  // has_string('nobody@nowhere.com', '.com')
  // * validate inclusion of character(s)
  // * strpos returns string start position or false
  // * uses !== to prevent position 0 from being considered false
  // * strpos is faster than preg_match()
  function has_string($value, $required_string) {
    return strpos($value, $required_string) !== false;
  }

  // has_valid_email_format('nobody@nowhere.com')
  // * validate correct format for email addresses
  // * format: [chars]@[chars].[2+ letters]
  // * preg_match is helpful, uses a regular expression
  //    returns 1 for a match, 0 for no match
  //    http://php.net/manual/en/function.preg-match.php
  function has_valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
  }

  // has_valid_url_format('http://google.com')
  // * validate correct format for URLs
  // * format: [chars]@[chars].[2+ letters]
  // * preg_match is helpful, uses a regular expression
  //    returns 1 for a match, 0 for no match
  //    http://php.net/manual/en/function.preg-match.php
  function has_valid_url_format($value) {
    $email_regex = 'https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)';
    return preg_match($email_regex, $value) === 1;
  }

  // has_unique_username('johnqpublic')
  // * Validates uniqueness of users.username
  // * For new records, provide only the username.
  // * For existing records, provide current ID as second argument
  //   has_unique_username('johnqpublic', 4)
  function has_unique_username($username, $current_id="0") {
    $user = User::find_by_username($username);
    if ($user === false || $user->id == $current_id) {
      //is unique
      return true;
    } else {
      // not unique
      return false;
    }
  }

  function is_unique_location($placeId, $current_id="0") {
    $restaurant = Restaurant::find_by_placeid($placeId);
    if ($restaurant === false  || $restaurant->id == $current_id) {
      //is unique
      return true;
    } else {
      // not unique
      return false;
    }
  }

  function can_be_promoted($promoted, $current_id="0") {
    if ($promoted == 0) {
      return true;
    } else {
      $promoted_count = Feed::count_promoted($promoted);
      $post = Email::find_by_id($current_id);
      if ($promoted_count <= 3 || $post->promoted == $promoted) {
        //is unique
        return true;
      } else {
        // not unique
        return false;
      }
    }
  }

  function can_be_hero($hero, $current_id="0") {
    if ($hero == 0) {
      return true;
    } else {
      $hero_count = Email::count_hero();
      $post = Feed::find_by_id($current_id);
      if ($hero_count < 1 || $post->hero == $hero) {
        //is unique
        return true;
      } else {
        // not unique
        return false;
      }
    }
  }

  function can_be_team_hero($team, $team_hero, $current_id="0") {
    if ($team_hero == 0) {
      return true;
    } else {
      $hero_count = Email::count_team_hero($team);
      $post = Feed::find_by_id($current_id);
      if ($hero_count < 1 || $post->team_hero == $team_hero) {
        //is unique
        return true;
      } else {
        // not unique
        return false;
      }
    }
  }

  function can_be_team_featured($team, $team_featured, $current_id="0") {
    if ($team_featured == 0) {
      return true;
    } else {
      $featured_count = Email::count_team_featured($team);
      $post = Feed::find_by_id($current_id);
      if ($featured_count <= 2 || $post->team_featured == $team_featured) {
        //is unique
        return true;
      } else {
        // not unique
        return false;
      }
    }
  }

?>
