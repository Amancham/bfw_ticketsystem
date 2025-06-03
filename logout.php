<?php 
include('header.php');
session_unset(); 
session_destroy(); ?>

<div class="login-page">
    <div class="login-box">
        <h2>Sie wurden ausgeloggt</h2>
        <p>Bis bald.</p>
    </div>
</div>
<?php include('footer.php'); 
header("refresh: 1.5; url = index.php");
exit();
?>