<?php

$db = getDb();

$profiles =  $db->query(
  "SELECT * FROM User"
)->fetchAll(PDO::FETCH_ASSOC);

$profiles = array_map(fn(
  $profile
) => populate(new User(), $profile), $profiles);


/** @var User $profile */
foreach ($profiles as $profile) {
  ?>
  <div class="w3-card w3-padding w3-margin">
    <div class="w3-container">
      <h2><?= $profile->username ?></h2>
      <p><?= $profile->email ?></p>
      <p><?= $profile->id ?></p>
      <button> Create connection </button>
      &nbsp;
      <button> Open details -> what this user has posted ... </button>
    </div>
  </div>
<?php
}