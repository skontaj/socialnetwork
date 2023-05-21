<?php

function clean($string) {
    
    return htmlentities($string);
}

function email_exists($email) {
    
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $query = "SELECT id FROM users WHERE email = '$email'";
    $result = query($query);
    
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function user_exists($user) {
    
     $user = filter_var($user, FILTER_UNSAFE_RAW);
    $query = "SELECT id FROM users WHERE username = '$user'";
    $result = query($query);
    
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function validate_user_registration() {
    
    $errors = [];
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = clean($_POST['first_name']);
    $last_name = clean($_POST['last_name']);
    $username = clean($_POST['username']);
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);
    $confirm_password = clean($_POST['confirm_password']);
    
    if (strlen($first_name) < 3) {
        $errors[] = "Your First Name cannot be less then 3 characters!";
    }
    if (strlen($last_name) < 3) {
        $errors[] = "Your Last Name cannot be less then 3 characters!";
    }
    if (strlen($username) < 3) {
        $errors[] = "Your Username cannot be less then 3 characters!";
    }
    if (strlen($username) > 20) {
        $errors[] = "Your Username cannot be bigger then 20 characters!";
    }
    if (email_exists($email)) {
        $errors[] = "Sorry that Email is already is taken";
    }
    if (user_exists($username)) {
        $errors[] = "Sorry that Username is already is taken";
    }
    if (strlen($password) < 8) {
        $errors[] = "Your Password cannot be less then 8 characters!";
    }
    if ($password != $confirm_password) {
        $errors[] = "The password was not confirmed correctly";
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
           echo  "<div class='alert'>" . $error . "</div>";
        }
        
    } else {
        
        $first_name = filter_var($first_name, FILTER_UNSAFE_RAW);
        $last_name = filter_var($last_name, FILTER_UNSAFE_RAW);
        $username = filter_var($username, FILTER_UNSAFE_RAW);
        $email = filter_var($email, FILTER_UNSAFE_RAW);
        $password = filter_var($password, FILTER_UNSAFE_RAW);
        create_user($first_name, $last_name, $username, $email, $password);
        
        $_SESSION['email'] = $email;
    
        echo "<script>window.location.href = 'home.php'</script>";
    
}
}
}

function create_user($first_name, $last_name, $username, $email, $password) {
    
    $first_name = escape($first_name);
    $last_name = escape($last_name);
    $username = escape($username);
    $email = escape($email);
    $password = escape($password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (first_name,last_name,username,profil_image,email,password)";
    
    $sql .= "VALUES('$first_name','$last_name','$username','uploads/user.png','$email','$password')";
    
    confim(query($sql));
    
    
}

function validate_user_login() {
    
    $errors = [];
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);
    
    if(empty($email)) {
        $errors[] = "Email field cannot be empty";
    }
    
    if(empty($password)) {
        $errors[] = "Password field cannot be empty";
    }
    
    if(empty($errors)) {
        if(user_login($email, $password)) {
            echo "<script>window.location.href = 'home.php'</script>";
        } else {
            $errors[] = "Your email or password is incorrect";
        }
    }
    
    if (!empty($errors)) {
       foreach ($errors as $error) {
           echo  "<div class='alert'>" . $error . "</div>";
       }
    }
    
    }
}

function user_login($email, $password) {
    
    $email = filter_var($email, FILTER_UNSAFE_RAW);
    $password = filter_var($password, FILTER_UNSAFE_RAW);
    
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = query($query);
    
    if ($result->num_rows > 0) {
        
        $data = $result->fetch_assoc();
        
        if (password_verify($password, $data['password'])) {            
            $_SESSION['email'] = $email;
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_user($id = NULL) {
    
    if ($id != NULL) {
        
        $query = "SELECT * FROM users WHERE id=" . $id;
    $result = query($query);
    
    if ($result->num_rows > 0) {
        
        return $result->fetch_assoc();
         
    } else {
        
            return "Uesr not found";
        }
    } else {
        
        $query = "SELECT * FROM users WHERE email ='" . $_SESSION['email'] . "'";
    $result = query($query);
        
        if ($result->num_rows > 0) {
       
          return $result->fetch_assoc();
       
        } else {
            
            return "Uesr not found";
        }
    }
}

function create_post_content () {
    
    $errors = [];
    
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['post_content'])) {
        $post_content = clean($_POST['post_content']);
        
        if (strlen($post_content) > 200) {   
        $errors[] = "Your post content is too long!";
        }
        
        if (strlen($post_content) < 1) {   
        $errors[] = "There is no post content!";
        }
        
        if (!empty($errors)) {
       foreach ($errors as $error) {
           echo  "<div class='alert'>" . $error . "</div>";
       }
    } else {
        
        $post_content = filter_var($post_content, FILTER_UNSAFE_RAW);
        $post_content = escape($post_content);
        $user = get_user();
        $user_id = $user['id'];
        
        $sql = "INSERT INTO posts (user_id, content)";
    
    $sql .= "VALUES('$user_id', '$post_content')";
    
    confim(query($sql));
    }
  }
}

function get_likes($post_id) {
    
    $query = "SELECT post_id FROM likes";
    $result = query($query);
    
    if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
            
            if($row['post_id'] == $post_id) {
                ++$i;
            }
         }
         echo $i;
    } else {
        
        return "0";
    }
}

function post_likes($post_id, $user_id) {
    
    $query = "SELECT * FROM likes WHERE post_id=" . $post_id ;
    $result = query($query);
    
    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            
           if($row['user_id'] == $user_id) {
               echo "disabled";
           }
         }
    }
}

function get_comm($post_id) {
    
    $query = "SELECT * FROM comments ORDER BY time DESC";
    $result = query($query);
    
    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
          
          $user = get_user($row['user_id']);
          
          if($row['post_id'] == $post_id) {
            
            echo "<div class='single_comm'>";
            echo "<img src=". $user['profil_image'] ." >";
            echo $user['first_name'];
            echo " ";
            echo $user['last_name'];
            echo ": ";
            echo $row['content'];
            echo "</div>";
            }
        }
    }
}

function all_post_content() {
    
    
    $query = "SELECT * FROM posts ORDER BY created_time DESC";
    $result = query($query);
    
    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            
            $user = get_user($row['user_id']);
            $user2 = get_user();
            $user_id = $user2['id'];
            
    
    echo "<div class='single-post'>";
            
    echo "<div id='username-post'>";
    echo "<span class='inline'><img src=". $user['profil_image'] ." ></span>";
    echo "<span class='inline'><p>" . $user['first_name'] . " " . $user['last_name'] . "</p></span>";
    echo "</div>";
    
    echo "<div class='post-content'>";
    echo "<p>" . $row['content'] . "</p>";
    echo "</div>";
    echo "<hr>";
    echo $row['created_time'];
    echo "<div class='likes-comment-delete-btn'>";
    echo "<form method='POST' id='contactform'>";
    echo "<input name='user_id' id='user_id' type='text' style='display:none' value=" . $user_id . ">";
    echo "<input name='post_id' id='post_id' type='text' style='display:none' value=" . $row['id'] . ">";
    echo "<button  type='button' class='btn-primary' onclick='likePost(this)'";
    echo post_likes($row['id'], $user_id);
    echo "><i class='fa fa-thumbs-o-up'> Likes <span id='span'>";
    echo get_likes($row['id']);
    echo "</span></i></button>";
    echo "</form>";
    echo "<button class='comment-post-btn' onclick='commentPost(this)'><i class='fa fa-comment-o'> Comments</i></button>";
    
    if ($user_id === $row['user_id']) {
    echo "<form method='POST'>";

    echo "<input name='del_post' id='del_post' type='text' style='display:none' value=" . $row['id'] . ">";

    echo "<button class='remove-btn' onclick='removeMyPost(this)' type='button'>Remove</button>";
    echo "</form>";
    }
    
    echo "</div>";
    
    echo "<form class='hide-form' method='POST'>";
    echo "<input id='content' name='content' placeholder='Napisi komentar...' type='text' id='commentSadrzaj'>";
    echo "<input name='user_id2' id='user_id2' type='text' style='display:none' value=" . $user_id . ">";
    echo "<input name='post_id2' id='post_id2' type='text' style='display:none' value=" . $row['id'] . ">";
    echo "<button type='button' onclick='commentPostSubmit(this)'>Comment</button>";
    echo "</form>";
  
    echo "<div class='post-comments'>";
    echo "<div class='comm'></div>";
    get_comm($row['id']);
    echo "</div>";
    echo "</div>";
        }
    }
}

function change_email() {
    
    $errors = [];
    
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['ch_email'])) {
        
    $ch_email = clean($_POST['ch_email']);
    
    $user = get_user();
    $user_id = $user['id'];
    
    if(empty($ch_email)) {
        $errors[] = "Email field cannot be empty";
    }
    if (email_exists($ch_email)) {
        $errors[] = "Sorry that Email is already is taken";
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
           echo  "<div class='alert'>" . $error . "</div>";
        }
    } else {
        $ch_email = filter_var($ch_email, FILTER_UNSAFE_RAW);
        $ch_email = escape($ch_email);
        
        $sql = "UPDATE users SET email='$ch_email' WHERE id=$user_id";
         confim(query($sql));
         
        $_SESSION['email'] = $ch_email;
        echo "<script>window.location.href = 'home.php'</script>";
        
    }
    }
}


function change_password() {
    
    $errors = [];
    
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['ch_password'])) {
        
    $ch_password = clean($_POST['ch_password']);
    $ch_password2 = clean($_POST['ch_password2']);
    $ch_password3 = clean($_POST['ch_password3']);
    
    $ch_password = filter_var($ch_password, FILTER_UNSAFE_RAW);
    $ch_password2 = filter_var($ch_password2, FILTER_UNSAFE_RAW);
    $ch_password3 = filter_var($ch_password3, FILTER_UNSAFE_RAW);
    
    if (strlen($ch_password2) < 8) {
        $errors[] = "Your Password cannot be less then 8 characters!";
    }
    if ($ch_password2 != $ch_password3) {
        $errors[] = "The password was not confirmed correctly";
    }
    
    $query = "SELECT * FROM users WHERE email ='" . $_SESSION['email'] . "'";
    $result = query($query);
        
        if ($result->num_rows > 0) {
       
        $row = $result->fetch_assoc();
       
        if(password_verify($ch_password, $row['password'])) {  
      } else {
          $errors[] = "The current password was not confirmed correctly";
      }
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
           echo  "<div class='alert'>" . $error . "</div>";
        }
    } else {
        
        $ch_password2 = escape($ch_password2);
        $ch_password2 = password_hash($ch_password2, PASSWORD_DEFAULT);
        
        $sql = "UPDATE users SET password='$ch_password2' WHERE email ='" . $_SESSION['email'] . "'";
         confim(query($sql));
    }
  }
}

function del_user_pr() {
    
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['del_user'])) {
      
       $del_user = clean($_POST['del_user']);
 
       
       $sql = "DELETE FROM users WHERE id=$del_user";
       confim(query($sql));
       $sql = "DELETE FROM posts WHERE user_id=$del_user";
       confim(query($sql));
       $sql = "DELETE FROM comments WHERE user_id=$del_user";
       confim(query($sql));

    session_destroy();
        echo "window.location.href = 'index.php'";
}
}

function upload_image() {
    
  if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['empty'])) {
      
     $target_dir = "uploads/";
     $user = get_user();
     $user_id = $user['id'];
     $target_file = $target_dir . $user_id . "." . pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION);
     $uploadOk = 1;
     $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
     $error = "";
     
     $check = getimagesize($_FILES['file']['tmp_name']);
     if($check !== false ) {
         $uploadOk = 1;
     } else {
         $error = "File is not an image.";
         $uploadOk = 0;
     }
     if($_FILES['file']['size'] > 5000000) {
         $error = "Sorry, your file is to large.";
         $uploadOk = 0;
     }
     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
         $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
         $uploadOk = 0;
     }
     if($uploadOk == 0) {
         echo  "<div class='alert'>" . $error . "</div>";
     } else {
         $sql = "UPDATE users SET profil_image='$target_file' WHERE id=$user_id";
         confim(query($sql));
         
         if(!move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
             echo  "<div class='alert'>" . $error . "</div>";
         }
         echo "<script>window.location.href = 'home.php'</script>";
     }
  }
}
