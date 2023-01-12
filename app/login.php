<?php

?>
<form method="post">
  <input type="hidden" name="action" value="login">
  <label>
    Username:<br>
    <input type="text" name="username" value="majo">
  </label>
  <br>
  <label>
    Password:<br>
    <input type="password" name="password" value="majo">
  </label>
  <br>
  <input type="submit" value="Login">
</form>


<h4>Registration</h4>
<form method="post">
  <input type="hidden" name="action" value="create_account">
  <label>
    Username:<br>
    <input type="text" name="username" value="majo">
  </label>
  <br>
  <label>
    Email:<br>
    <input type="text" name="email" value="majo@majo.de">
  </label>
  <br>
  <label>
    Password:<br>
    <input type="password" name="password" value="majo">
  </label>
  <br>
  <label>
    Confirm Password:<br>
    <input type="password" name="confirm_password" value="majo">
  </label>
  <br>
  <input type="submit" value="Register">
</form>
