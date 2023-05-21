<?php include "inc/header.php"; ?>

<?php

if (isset($_SESSION['email'])) {
    
    echo "<script>window.location.href = 'home.php'</script>";
}

?>

<?php
    validate_user_registration();
?>


<form method="POST">

    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="********" required><br>
    <input type="password" name="confirm_password" placeholder="********" required>
    <br>
    <input type="submit" name="register-submit" placeholder="Register Now" value="Register Now">
    
</form>

<?php include "inc/footer.php"; ?>