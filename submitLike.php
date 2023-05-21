<?php

include "functions/init.php";

    
  if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['post_id'])) {
      
       $user_id = clean($_POST['user_id']);
       $post_id = clean($_POST['post_id']);
       
       $user_id = filter_var($user_id, FILTER_UNSAFE_RAW);
       $post_id = filter_var($post_id, FILTER_UNSAFE_RAW);
       
       $user_id = escape($user_id);
       $post_id = escape($post_id);
       
       $sql = "INSERT INTO likes (user_id, post_id)";
    
       $sql .= "VALUES('$user_id', '$post_id')";
    
    confim(query($sql));
}