<?php
  $blogid = $_POST['blogid'];
  $name = htmlspecialchars(trim($_POST['name']));
  $comment = htmlspecialchars(trim($_POST['comment']));
  
  $new_comment = new CommentsModel();
  $new_comment->blogid = $blogid;
  $new_comment->author = $name;
  $new_comment->body = $comment;
  $new_comment->save();
  
  echo 'спасибо';
  