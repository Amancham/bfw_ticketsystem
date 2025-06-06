
<?php
include 'header.php';

$categories = $db->getPdo()->query("SELECT cid, name FROM category ORDER BY name ASC")->fetchAll();
?>

<main class="login-page">
    <form action="create_ticket.php" method="post" id="ticketForm" class="ticket-form">
      <h2>Neues Ticket erstellen</h2>
      <label for="title">Titel *</label>
      <input type="text" name="title" id="title" required>

      <label for="description">Problembeschreibung *</label>
      <textarea name="description" id="description" rows="12" required></textarea>
   

      <label for="priority">Priorität *</label>
      <select name="priority" id="priority" required>
        <option value="1">Hoch</option>
        <option value="2">Mittel</option>
        <option value="3">Niedrig</option>
      </select>

      <label for="cid">Kategorie</label>
      <select name="cid" id="cid">
        <option value="">-- Bitte wählen --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['cid'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" name="absenden">Ticket absenden</button>
    </form>
    <div id="successMessage" class="success-msg"></div>

   
  </main>
 <?php include 'footer.php'; 

 if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['priority']) && !empty($_POST['cid']))
 {
  $db -> createTicket($_POST['title'],$_POST['description'],$_POST['priority'],$user->getUid(),$_POST['cid']);
 }
?>
  
