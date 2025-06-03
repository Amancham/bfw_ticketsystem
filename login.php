<?php
include ('header.php');
?>

<div class="login-page">
  <div class="login-box">
    <h2>BFW TICKET SYSTEM</h2>
    <form id="loginForm" action="login.php" method="post">
      <label for="email">E-Mail Adresse</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Passwort</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Anmelden</button>
    </form>
    <div id="errorMsg" class="error-msg">
      <?php 
      if(!empty($_SESSION['error_login'])) {
          echo($_SESSION['error_login']);
          //unset the error message for the next try
          unset($_SESSION['error_login']);
      }
      ?>
    </div>
  </div>
</div>

<?php 
include ('footer.php');
if(!empty($_POST['email']) && !empty($_POST['password'])) {
  if($db->check_login($_POST['email'], $_POST['password']) === false) {
      header("Location:login.php");
      die();
  }
  else {
      $user_id = $db->do_login($_POST['email']);
      header("Refresh: 0; url = index.php");
  }
}
?>