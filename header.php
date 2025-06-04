<?php 
session_start(); 
define('SECURE_ACCESS', true);
if(!isset($_SESSION['uid'])) {
    $_SESSION['uid'] = 0;
}
if(!file_exists('assets/config')) {
    header("Location: install/index.php");
}
include_once('classes/Database.php');
include_once('classes/Ticket.php');
include_once('classes/User.php');
$configs = include_once('assets/config');
$db = new Database($configs['host'], $configs['user'], $configs['pwd'], $configs['db']);

if($_SESSION['uid'] != 0) {
    $user = $db->load_user($_SESSION['uid']);
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>BFW TICKET SYSTEM</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="topbar">
    <div class="logo">BFW TICKET SYSTEM</div>
    <nav>
      <a href="index.php">Home</a>
      <?php if ($_SESSION['uid'] === 0): ?>
        <a href="signup.php">Konto erstellen</a>
      <?php elseif ($_SESSION['uid'] !== 0 && $user->getRole() === 'admin'): ?>
        <a href="admin_user.php">Benutzerverwaltung</a>
        <a href="admin_stats.php">Statistik</a>
        <a href="create_ticket.php">Ticket erstellen</a>
        <a href="logout.php" id="logoutBtn">Abmelden</a>
      <?php elseif ($_SESSION['uid'] !== 0): ?>
        <a href="create_ticket.php">Ticket erstellen</a>
        <a href="logout.php" id="logoutBtn">Abmelden</a>
      <?php endif; ?>
    </nav>
  </header>
  <body>
