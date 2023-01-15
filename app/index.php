<?php

// display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "utils.php";
include "data.php";

session_start();
#$_SESSION['user_id'] = 1; // todo: for development, always logged in
$page = $_GET['p'] ?? 'home';
$login = false;

function load_user(){
  global $login;
  global $user;
  if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    assert(is_int($user_id));
    $sql = "SELECT * FROM User WHERE id = $user_id";
    $db = getDb();
    $user = $db->query($sql)->fetchObject('User');
    $_SESSION['user'] = $user;
    $login = true;
  }
}


load_user();
if(isset($_POST["action"])){
  // map the actions to the class handlers
  $action = $_POST["action"];
  # assert that class is a valid class
  assert(!str_contains($action,".") and !str_contains($action,"/"));
  if (file_exists("./requests/" . $action.".php")) {
    // the file handles the request
    include "./requests/" . $action. ".php";
  }
}
load_user();

if(isset($_POST)){
  var_dump($_POST);
}

// all requests


?>
<html lang="de">
<head>
  <title>Politbreak</title>
  <!-- w3-css -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- j query -->
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</head>
<body class="w3-padding">
<?php if ($login): ?>
<header class="w3-card w3-padding" style="margin-bottom: 7px">
  <nav>
    <a class="w3-button w3-purple" href="?p=home">Home</a>
    <a class="w3-button w3-purple" href="?p=mynews">News</a>
    <a class="w3-button w3-purple" href="?p=profiles">Profiles</a>
    <a class="w3-button w3-purple" href="?p=connections">Connections</a>
    <a class="w3-button w3-purple" href="?p=settings">Settings</a>
    <a class="w3-button w3-purple" href="?p=about">About</a>
    <a class="w3-button w3-purple" href="?p=debug">About</a>
  </nav>
</header>
<?php endif; ?>

<?php

if($login) {
  switch ($page) {
      
    case 'settings':
      include "settings.php";
      break;
      
    case 'about':
      echo "About the application:<br>";
      echo "Solve Political Discourse";
      echo "
        <pre>
        Worauf kommt es an?
        
        -> Gute Diskussionen
        -> Papers muss gut funktionieren
        -> Wiki muss übersichtlich sein
        -> Zusammenarbeit mit anderen befürworten
        -> Tools für den Objektiven Diskurs
       
        </pre>
      ";
      break;
      
    case 'connections':
      include "connections.php";
      break;
      
    case 'chat':
      include "chat.php";
      break;
      
    // not main pages
    case 'one':
      include "one.php";
      break;
  
    case 'forum':
      include "forum.php";
      break;
  
    case 'mynews':
      include "mynews.php";
      break;
      
    case 'edit':
      include "edit.php";
      break;
      
    case 'one_channel':
      include "one_channel.php";
      break;
  
    case 'debug':
      include "debug.php";
      break;
  
    case 'profiles':
      include "profiles.php";
      break;
      
    default:
      // home page
      include "home.php";
      break;
  }
}else{
  include "login.php";
}
?>

</body>
</html>
