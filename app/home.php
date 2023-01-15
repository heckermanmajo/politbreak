<?php
if(!isset($_GET["p"])){
  $_GET["p"] = "home";
}
if(!isset($_GET["category"])){
  $_GET["category"] = "all";
}
?>
  <form method="post">
    <label>
      <b> Kategorie des Posts: </b>
      <select name="category">
        <option value="wiki">Wiki Entry</option>
        <option value="news" selected>News</option>
        <option value="question">Question</option>
        <option value="problem">Problem</option>
        <option value="paper">Paper</option>
        <option value="group">Group</option>
      </select>
    </label>
    <input type="submit" name="action" value="create_post">
  </form>

  <form method="post">
    <select name="category" id="category_filter">
      <option value="all" <?=$_GET["category"] == "all" ? "selected" : "" ?>>All Categories</option>
      <option value="wiki" <?=$_GET["category"] == "wiki" ? "selected" : "" ?>>Wiki Entry</option>
      <option value="news" <?=$_GET["category"] == "news" ? "selected" : "" ?>>News</option>
      <option value="question" <?=$_GET["category"] == "question" ? "selected" : "" ?>>Question</option>
      <option value="problem" <?=$_GET["category"] == "problem" ? "selected" : "" ?>>Problem</option>
      <option value="paper" <?=$_GET["category"] == "paper" ? "selected" : "" ?>>Paper</option>
      <option value="group" <?=$_GET["category"] == "group" ? "selected" : "" ?>>Group</option>
    </select>
    <button onclick="event.preventDefault();window.location.href = '/?p=<?=$_GET["p"] ?? "home"?>&category=' + $('#category_filter').val() + ''"> Search </button>
  </form>
<?php

// load all posts

$category = $_GET["category"] ?? "all";

$db = getDb();
if($category != "all") {
  $statement = $db->prepare("SELECT * FROM Post WHERE category=:category ORDER BY id DESC");
  $statement->execute(["category" => $category]);
  $all_posts = array_map(fn(
    $post
  ) => populate(new Post(), $post), $statement->fetchAll(PDO::FETCH_ASSOC));
}else{
  $all_posts = $db->query("SELECT * FROM Post ORDER BY id DESC");
  $all_posts = array_map(fn(
    $post
  ) => populate(new Post(), $post), $all_posts->fetchAll(PDO::FETCH_ASSOC));
}
// print all posts

foreach ($all_posts as $post) {
  put_post($post, true, true, true);
}