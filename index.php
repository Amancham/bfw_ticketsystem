<?php
include ('header.php');
if($_SESSION['uid'] === 1) {
    header("Location: login.php");
}
?>
<main class="dashboard">



</main><?php 
include 'footer.php';
?>