<?php
include ('header.php');
?>

<div class="login-page">
    <!-- TODO: Add option per page for body class and title without having to take the header apart -->
  <div class="login-box">
    <h2>BFW TICKET SYSTEM</h2>
    <form id="loginForm">
      <label for="username">Benutzername</label>
      <input type="text" id="username" name="username" required>

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
?>