<?php


echo "<h3>Post Filter</h3>";


// load all posts

$db = getDb();

$all_posts = $db->query("SELECT * FROM Post ORDER BY id DESC");
$all_posts = array_map(fn ($post) => populate(new Post(), $post), $all_posts->fetchAll());

// print all posts

foreach ($all_posts as $post) {
  put_post($post, true, true, true);
}