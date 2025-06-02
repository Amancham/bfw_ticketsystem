<?php 
include('header.php');
session_unset(); 
session_destroy(); ?>

<h2>Sie wurden ausgeloggt</h2>
<div id="content">
<p>Sie werden jetzt auf die Startseite weitergeleitet.</p>
</div>
<?php include('footer.php'); 
header("refresh: 1.5; url = index.php");
exit();
?>