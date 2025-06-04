<?php
include('header.php');
?>
<div class="dashboard">

    <div class="login-page">
        <div class="login-box">
            <h2>KONTO ERSTELLEN</h2>
            <form id="loginForm" action="signup.php" method="post">
                <label for="username">Benutzername</label>
                <input type="text" id="username" name="username" required>

                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" required>

                <label for="password2">Passwort widerholung</label>
                <input type="password" id="password2" name="password2" required>

                <button type="submit">Konto erstellen</button>
            </form>
            <div id="errorMsg" class="error-msg">
                <?php
                if (!empty($_SESSION['error_signup'])) {
                    echo ($_SESSION['error_signup']);
                    //unset the error message for the next try
                    unset($_SESSION['error_signup']);
                }
                ?>
            </div>

        </div>
    </div>
</div>
<?php
include('footer.php');
if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password2'])) {
    if ($db->check_signup($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password2']) == false) {
        header("Location:signup.php");
        die();
    } else {
        $user = $db->do_login($_POST['email']);
        header("refresh: 0; url = index.php");
    }
}
?>