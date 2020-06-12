<?php require_once('../../private/initialize.php'); ?>

<?php
// $e = Pokemon::evolutionChain(5);

// die;
?>

<?php
  $sql = "SELECT * FROM pokemon ";
  $sql .= "LIMIT 50 ";
  $sql .= "OFFSET 600 ";
  $pokemon = Pokemon::find_by_sql($sql);

  foreach ($pokemon as $p) {
    $name = $p->name;

    $pokemon = json_decode($api->pokemonSpecies($name), JSON_PRETTY_PRINT);

    // $evolvesFrom = $pokemon['evolves_from_species']['name'] ?: NULL;
    //
    //
    // foreach ($pokemon['flavor_text_entries'] as $desc) {
    //   if ($desc['language']['name'] === 'en') {
    //     $description = $desc['flavor_text'];
    //     break;
    //   }
    // }

    $rarity = $pokemon['pal_park_encounters'][0]['base_score'] * $pokemon['pal_park_encounters'][0]['rate'] ?: NULL;


    // $args['name'] = $pokemon['name'];
    // $args['height'] = $pokemon['height'];
    // $args['weight'] = $pokemon['weight'];
    // $types = [];
    // foreach($pokemon['types'] as $type) {
    //   $types[] = $type['type']['name'];
    // }
    // $args['types'] = serialize($types);

    // $args['evolvesFrom'] = $evolvesFrom;
    // $args['description'] = $description;
    $args['rarity'] = $rarity;

    $pokeman = Pokemon::find_by_id($pokemon['id']);

    if ($pokeman) {
      $pokeman->merge_attributes($args);
    } else {
      $pokeman = new Pokemon($args);
    }

    $result = $pokeman->save();

    if($result === true) {
      echo $pokeman->name . ": ✅";
    } else {
      echo 'There was an error';
      $pokemon->id;
    }
  }


?>
