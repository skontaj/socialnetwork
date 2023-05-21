<?php include "inc/header.php"; ?>

<?php

if (isset($_SESSION['email'])) {
    
    echo "<script>window.location.href = 'home.php'</script>";
}

?>


<p>Social Network</p>

<?php include "inc/footer.php"; ?>