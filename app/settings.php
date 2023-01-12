<?php

/**
 * @var $user User
 */
$user = $_SESSION['user'];
?>

<pre>
  <?=print_r($user, true)?>
</pre>

<form method="post">
  <input type="hidden" name="action" value="logout">
  <input type="submit" class="w3-btn w3-red" value="Logout">
</form>
<form method="post">
  <input type="hidden" name="action" value="edit_settings">
  <label>
    Username:<br>
    <input
      type="text"
      name="username"
      value="<?= $user->username; ?>"
      readonly>
  </label>
  <br>
  <label>
    Email:<br>
    <input
      type="text"
      name="email"
      value="<?php echo $user->email; ?>">
  </label>
  <br>
  <label>
    First Name:<br>
    <input
      type="text"
      name="first_name"
      value="<?php echo $user->first_name; ?>">
  </label>
  <br>
  <label>
    Last Name:<br>
    <input
      type="text"
      name="last_name"
      value="<?php echo $user->last_name; ?>">
  </label>
  <br>
  <label>
    Topics of Interest:<br>
    <input
      type="text"
      name="topics_of_interest"
      value="<?php echo $user->topics_of_interest; ?>">
  </label>
  <br>
  <label>
    Bio:<br>
    <input
      type="text"
      name="bio"
      value="<?php echo $user->bio; ?>">
  </label>
  <br>
  <label>
    Profile Picture:<br>
    <input
      type="file"
      name="profile_picture"
      value="<?php echo $user->profile_picture; ?>">
  </label>
  <br>
  <label>
    Interests:<br>
    <input
      type="text"
      name="interests"
      value="<?php echo $user->interests; ?>">
  </label>
  <br><br>
  <input type="submit" value="Save">
</form>

