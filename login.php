<?php include "inc/header.php"; ?>

<?php

if (isset($_SESSION['email'])) {
    
    echo "<script>window.location.href = 'home.php'</script>";
}

?>

<?php
    validate_user_login();
?>


<form method="POST">

    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="********" required><br>
    <br>
    <input type="submit" name="login-submit" placeholder="Login" value="Login">
    
</form>

<?php include "inc/footer.php"; ?>