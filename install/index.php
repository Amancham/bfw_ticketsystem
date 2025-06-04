<?php 
if(file_exists('lock')) {
    die('Cannot run installation while "Lock" file is present in installation folder.');
}

if(!file_exists('../assets/config')) {
    echo('<h1>Welcome to the installation</h1>');
    echo('<p>Please enter the following information to continue.</p>');

    echo('<div class="form">');
        echo('<form action="index.php" method="post">');
        echo('<fieldset>');
        echo('<legend>Server connection</legend>');
        echo('<label for="server">Server/Host <span class="required">*</span></label><br/>');
        echo('<input type="text" name="server" id="server" required /><br/>');
        echo('<label for="user">Username <span class="required">*</span></label><br/>');
        echo('<input type="text" name="user" id="user" required /><br/>');
        echo('<label for="pwd">Password <span class="required">*</span></label><br/>');
        echo('<input type="password" name="pwd" id="pwd" required /><br/>');
        echo('<label for="db">Database Name <span class="required">*</span></label><br>');
        echo('<input type="text" name="db" id="db" required />');
        echo('</fieldset>');
        echo('<input type="submit" name="Submit">');
        echo('</form>');
        echo('</div>');

        if((isset($_POST['server']) && isset($_POST['user']) && isset($_POST['pwd']) && isset($_POST['db'])) && 
        (!empty($_POST['server']) && !empty($_POST['user']) && !empty($_POST['pwd']) && !empty($_POST['db']))) {
            $server = $_POST['server'];
            $user = $_POST['user'];
            $pwd = $_POST['pwd'];
            $db = $_POST['db'];
            $file = '../assets/config';
            $contents = "<?php
    if(!defined('SECURE_ACCESS')) {
        die('Direct access not permitted');
    }
    return array(
        'host' => '".$server."',
        'user' => '".$user."',
        'pwd' => '".$pwd."',
        'db' => '".$db."'
    );
    ?>
    ";
            file_put_contents(
            $file,
            $contents
            );
            header("Location: index.php");
        }
    }
    else {
        // create tables
        define('SECURE_ACCESS', true);
        include_once ("../classes/Database.php");
        $configs = include('../assets/config');

        $db = new Database($configs['host'], $configs['user'], $configs['pwd'], $configs['db']);

        $sql = file_get_contents('../assets/database.sql');
        $db->getPdo()->exec($sql);
        echo("All tables were created successfully");

        echo('<h1>Admin account</h1>');

        echo('<form action="index.php?add=admin_done" method="post">');
        echo('<fieldset>');
        echo('<legend>Admin account</legend>');
        echo('<label for="name">Name</label><br/>');
        echo('<input type="text" id="name" name="name"><br/>');
        echo('<label for="email">E-Mail</label><br/>');
        echo('<input type="email" id="email" name="email"><br/>');
        echo('<label for="pwd">Password</label><br/>');
        echo('<input type="password" id="pwd" name="pwd"><br/>');
        echo('</fieldset>');
        echo('<input type="submit" name="Submit">');
        echo('</form>');

        if((isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pwd'])) && 
        (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['pwd']))) {
            $pwd_hashed = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
            $create_admin = "INSERT INTO user (username, email, password, role) VALUES ('".$_POST['name']."', '".$_POST['email']."', '".$pwd_hashed."', 'admin');";
            $db->getPdo()->exec($create_admin);

            echo("<p>Admin-Account created successfully.</p>");

            $db = null;

            file_put_contents(
                'lock',
                'Installation locked'
            );
            header("Location: ../index.php");
        }
    }