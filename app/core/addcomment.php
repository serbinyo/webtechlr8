<?php
  $name = htmlspecialchars(trim($_POST['name']));
  $comment = htmlspecialchars(trim($_POST['comment']));
  
  $new_comment = new CommentsModel();
  $new_comment->blogid = '3';
  $new_comment->author = $name;
  $new_comment->body = $comment;
  $new_comment->save();
  
  echo 'спасибо';
  