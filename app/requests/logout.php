<?php
echo "<h3>logout</h3>";
$_SESSION = array();
session_destroy();
$user = null;
$login = false;