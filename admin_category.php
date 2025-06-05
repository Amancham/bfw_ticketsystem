<?php
include 'header.php';
?>
<main class="dashboard">
    <h2>Neue Kategory erstellen</h2>
    <form action="admin_category.php" method="post" id="ticketForm" class="ticket-form">
        <label for="name">Neue Kategorie *</label>
        <input type="text" name="name" id="name" required>
        <button type="submit" name="absenden">absenden</button>
</main>

<?php include 'footer.php';

if (!empty($_POST['name'])) {
    $db->createCategory($_POST['name']);
}
?>