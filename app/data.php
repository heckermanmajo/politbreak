<?php

class User {
  public int $id = 0;
  public string $username = '';
  public string $password = '';
  // german
  public string $email = '';
  public string $first_name = '';
  public string $last_name = '';
  public string $state = '';
  public int $city = 0;
  public string $topics_of_interest = '';
  public string $bio = '';
  public string $profile_picture = '';
  public string $interests = '';
}

class Connection  {
  public int $id = 0;
  public int $user_id = 0;
  public int $partner_id = 0;
  public string $date = '';
  public string $status = '';
}

class UserMessage  {
  public int $id = 0;
  public int $author_id = 0;
  public int $connection_id = 0;
  public string $content = '';
  public string $date = '';
  public string $status = '';
}

class NewsEntry {
  public int $id = 0;
  public string $title = '';
  public string $author_id = '';
  public string $content = '';
  public string $date = '';
  public string $url = '';
  public string $tags = '';
  public string $status = '';
  public string $j_author_name = '';
  public string $j_author_image = '';
}

class Topic {
  public int $id = 0;
  public string $title = '';
  public string $author_id = '';
  public int $parent_topic_id = 0;
  public string $description = '';
  public string $date = '';
  public string $tags = '';
  public string $status = '';
}

class Post {
  public int $id = 0;
  public string $title = '';
  public string $author_id = '';
  public int $parent_post = 0;
  public string $content = '';
  public string $date = '';
  public int $draft = 1;
  public string $tags = '';
  public string $category = ''; # news, question, problem, paper, wiki_entry, etc.
  public string $status = '';
  public string $j_author_name = '';
  public string $j_author_image = '';
}

class PostParagraph {
  public int $id = 0;
  public string $author_id = '';
  public string $post_id = '';
  # content
  
  public string $content = '';
  
  public string $type = '';
  public string $date = '';
  public string $tags = '';
  public string $rating = '';
  public string $status = '';
  public string $j_author_name = '';
  public string $j_author_image = '';
}

class PostLink{
  public int $id = 0;
  public string $title = '';
  public string $author_id = '';
  public string $paragraph_id = '';
  public string $description = '';
  public string $url = '';
  public string $date = '';
  public string $tags = '';
  public string $status = '';
  public string $j_author_name = '';
  public string $j_author_image = '';
}

class PostMembershipApplication  {
  public int $id = 0;
  public int $post_id = 0;
  public int $user_id = 0;
  public string $date = '';
  public string $status = '';
}

class PostMembership {
  public int $id = 0;
  public int $post_id = 0;
  public int $user_id = 0;
  public string $date = '';
  public string $status = '';
}

class PostComment{
  public int $id = 0;
  public int $post_id = 0;
  public int $author_id = 0;
  public int $parent_post_id = 0;
  public string $content = '';
  public string $date = '';
  public string $status = '';
}

class PostSupport {
  public int $id = 0;
  public int $post_id = 0;
  public int $user_id = 0;
  public string $date = '';
  public string $status = '';
}

class Channel{
  public int $id = 0;
  public string $title = '';
  public int $post_id = 0;
  public string $author_id = '';
  public string $description = '';
  public string $date = '';
  public string $tags = '';
  public string $status = '';
  public string $j_author_name = '';
  public string $j_author_image = '';
}

class ChannelAbo {
  public int $id = 0;
  public int $channel_id = 0;
  public int $user_id = 0;
  public string $date = '';
}

class ChannelMessage {
  public int $id = 0;
  public int $channel_id = 0;
  public int $author_id = 0;
  public int $parent_message_id = 0;
  public int $root_message_id = 0;
  public string $content = '';
  public string $date = '';
  public string $status = '';
  public array $j_children = [];
  public int $j_depth = 0;
}

$user_defined_classes = array(
  'User',
  'Connection',
  'UserMessage',
  'NewsEntry',
  'Topic',
  'Post',
  'PostParagraph',
  'PostLink',
  'PostMembershipApplication',
  'PostMembership',
  'PostComment',
  'PostSupport',
  'Channel',
  'ChannelAbo',
  'ChannelMessage'
);