<?php 
include "functions/init.php";
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Social Network</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<div class="container">

    <ul>
    <?php if (!isset($_SESSION['email'])) : ?>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
    <?php endif; ?>
    </ul>