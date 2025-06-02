<?php
include ('header.php');
?>

<div class="login-page">
    <div class="login-box">
        <h2>KONTO ERSTELLEN</h2>
        <form id="loginForm">
            <label for="username">Benutzername</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-Mail</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" required>

            <label for="password2">Passwort widerholung</label>
            <input type="password2" id="password2" name="password2" required>

            <button type="submit">Konto erstellen</button>
            </form>
            <div id="errorMsg" class="error-msg">
                <?php 
                if(!empty($_SESSION['error_signup'])) {
                    echo($_SESSION['error_signup']);
                    //unset the error message for the next try
                    unset($_SESSION['error_signup']);
                }
                ?>
            </div>

    </div>
</div>

<?php 
include ('footer.php');
?>