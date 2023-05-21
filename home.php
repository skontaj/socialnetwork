<?php include "inc/header.php"; ?>

<?php

if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href = 'login.php'</script>";
}

    $user = get_user();

    create_post_content();
    
    upload_image();
    
    change_email();
    
    change_password();
    
?>

<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Social Network</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
   <link rel="stylesheet" href="css/socialNetwork1.css">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="left-side">
          <div class="user-img">
          <?php echo "<img src='" . $user['profil_image'] . "'>"; ?>
          </div>
          <p id="username">
          <?php echo $user['first_name']; ?>
          <?php echo $user['last_name']; ?>
          </p>
          <p id="email">
          <?php echo $user['email']; ?>
          </p>
          <button id="chProfil" onclick='chProfil(this)'>Izmjeni profil</button>
          <button id="logout"><a href="logout.php">Logout</a></button>
        </div>
      </div>
      <div class="col-md-9">
        <div class="right-side">
          <form class="input-objava" method="POST">
            <textarea id="postSadrzaj" placeholder="Napisi nesto..." name="post_content"></textarea>
            <input type="submit" name="post-submit" placeholder="Objavi">
          </form>
          <div class="objava-html">
            
            <?php all_post_content(); ?>
            <div class='result'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="popup">
    
    <form class="izmjeniProfil" method="post">
      <h1>Izmjeni Profil</h1>
      	<div>
      	  <label for="email">Email adresa:</label>
      	  <input type="email" name="ch_email" placeholder="email.email@gmail.com" required>
      	</div>
      
		<div class="popupBtns">
		<button id="izmjeni">Change email</button>
		</div>
    </form>

    <form class="izmjeniProfil" method="post">
      	<div>
      	  <label for="password">Old password:</label>
      	  <input type="password" name="ch_password" placeholder="********" required>
      	  <label for="password2">New password:</label>
      	  <input type="password" name="ch_password2" placeholder="********" required>
      	  <label for="password3">Confirm new password:</label>
      	  <input type="password" name="ch_password3" placeholder="********" required>
      	</div>
      
		<div class="popupBtns">
		<button id="izmjeni" type="submit">Change password</button>
		</div>
    </form>
    
    <div>
      <form method="post" enctype="multipart/form-data" id="uploadFile">
        <div>
          <input type="file" id="file" name="file">
          <input name='empty' type='text' style='display:none' value="qwer">
        </div>
        <div>
          <button type="submit">Promjeni profilnu</button>
        </div>
      </form>
    </div>
    <form method="post">
      <input name='del_user' id='del_user' type='text' style='display:none' value=<?php echo $user['id']; ?>>
      <div class="popupBtns">
        <button type="button" id="obrisi" onclick='delUser(this)'>Obrisi profil</button>
      </div>
    </form>
    <div class="x">
    <button onclick='x(this)'>X</button>
    </div>
    
  </div>
  
  <div class="overlay"></div>
  
  <script src="js/showComm.js"></script>
  
  <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

 <script src="js/submit.js"></script>

</body>

</html>


<?php include "inc/footer.php"; ?>