<?php

include "functions/init.php";

session_destroy();
echo "<script>window.location.href = 'index.php'</script>";