<?php

$blogid = $_POST['blogid'];
$name = htmlspecialchars(trim($_POST['name']));
$comment = htmlspecialchars(trim($_POST['comment']));

$new_comment = new CommentsModel();
$new_comment->blogid = $blogid;
$new_comment->author = $name;
$new_comment->body = $comment;
$new_comment->save();

$cmntqry = "SELECT * FROM comments WHERE blogid = '$blogid' ORDER BY date DESC";
BaseActiveRecord::check_connection();
foreach (BaseActiveRecord::$pdo->query($cmntqry) as $с => $comment) {
    $r[] = $comment['date'] . ' ' . $comment['author'] . ' написал: ' . $comment['body'] . '<hr>';
}
 if(empty($r)) {
   echo "empty";
  } else {
   echo json_encode($r);
  }
