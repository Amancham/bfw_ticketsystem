<?php
include ('header.php');
if($_SESSION['uid'] === 1) {
    header("Location: login.php");
}
?>
<main class="dashboard">
<h2>Meine Tickets</h2>
<table>
  <tr>
    <th>ID</th>
    <th>Titel</th>
    <th>Priorität (3. Hoch)</th>
    <th>Status</th>
    <th>Erstellt am</th>
  </tr>


  
</table>

</main><?php 
include 'footer.php';
?>