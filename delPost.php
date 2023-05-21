<?php

include "functions/init.php";

    
  if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['del_post'])) {
      
       $del_post = clean($_POST['del_post']);
       
       $sql = "DELETE FROM posts WHERE id=$del_post";
    
    confim(query($sql));
}