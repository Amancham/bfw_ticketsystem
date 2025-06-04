
<?php

require_once 'classes/Database.php';
require_once 'classes/User.php';


$db = new Database('localhost', 'singh', '', 'database');

    
$categories = $db->getPdo()->query("SELECT cid, name FROM category")->fetchAll();
include 'header.php';
?>





  <main class="dashboard">
    <h2>Neues Ticket erstellen</h2>
    <form id="ticketForm" class="ticket-form">
      <label for="title">Titel *</label>
      <input type="text" name="title" id="title" required>

      <label for="description">Problembeschreibung *</label>
      <textarea name="description" id="description" required></textarea>
      <label for="status">Status </label>
      <textarea name="status" id="status" required></textarea>

      <label for="priority">Priorität *</label>
      <select name="priority" id="priority" required>
        <option value="1">1 (Hoch)</option>
        <option value="2">2 (Mittel)</option>
        <option value="3">3 (Niedrig)</option>
      </select>

      <label for="cid">Kategorie</label>
      <select name="cid" id="cid">
        <option value="">-- Keine --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['cid'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit">Ticket absenden</button>
    </form>
    <div id="successMessage" class="success-msg"></div>
    <?php include 'footer.php'; ?>
  </main>