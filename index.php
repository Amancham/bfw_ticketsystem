<?php
include ('header.php');
if($_SESSION['uid'] === 0) {
    header("Location: login.php");
}
?>
<main class="dashboard">

</main>
