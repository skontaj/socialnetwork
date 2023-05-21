<?php

include "functions/init.php";

if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['del_user'])) {
      
     $del_user = clean($_POST['del_user']);
     
       $sql = "DELETE FROM users WHERE id=$del_user";
       confim(query($sql));
       $sql = "DELETE FROM posts WHERE user_id=$del_user";
       confim(query($sql));
       $sql = "DELETE FROM comments WHERE user_id=$del_user";
       confim(query($sql));

      session_destroy();
      echo "<script>window.location.href = 'index.php'</script>";
}