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
// Prioritäten werden aktualisiert!
$db->updatePriorities();

?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>BFW TICKET SYSTEM</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="dashboard">
  <header class="topbar">
    <div class="logo">BFW TICKET SYSTEM</div>
    <nav>
      <a href="index.php" class="navlinks">Home</a>
      <?php if ($_SESSION['uid'] === 0): ?>
        <a href="signup.php" class="navlinks">Konto erstellen</a>
      <?php elseif ($_SESSION['uid'] !== 0 && $user->getRole() === 'admin'): ?>
        <a href="admin_category.php" class="navlinks">Kategories</a>
        <a href="admin_user.php" class="navlinks">Benutzerverwaltung</a>
        <a href="admin_stats.php" class="navlinks">Statistik</a>
        <a href="create_ticket.php" class="navlinks">Ticket erstellen</a>
        <a href="logout.php" id="logoutBtn" class="navlink_logout">Abmelden</a>
      <?php elseif ($_SESSION['uid'] !== 0): ?>
        <a href="create_ticket.php" class="navlinks">Ticket erstellen</a>
        <a href="logout.php" id="logoutBtn" class="navlink_logout">Abmelden</a>
      <?php endif; ?>
    </nav>
  </header>
   