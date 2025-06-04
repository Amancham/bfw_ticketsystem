<?php
include ('header.php');
if($_SESSION['uid'] === 0) {
    header("Location: login.php");
}
if($user->getRole() !== 'admin') {
    header("Location: index.php");
}
$users = $db->list_users()
?>
<main class="dashboard">
    <h2>Benutzerverwaltung (Admin)</h2>
    <table>
      <thead>
        <tr>
          <th>Benutzer ID</th>
          <th>Benutzername</th>
          
          <th>Rolle</th>
          <th>Aktion</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['uid']) ?></td>
          <td><?= htmlspecialchars($u['username']) ?></td>
          <td><?= $u['role'] ?></td>
          <td>
            <?php if ($u['uid'] != $user->getUid()): ?>
              <form method="post" action="admin_user.php" style="display: inline-block">
                <input type="hidden" name="user_id" value="<?= $u['uid'] ?>">
                <select name="role">
                  <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>User</option>
                  <option value="support" <?= $u['role'] === 'support' ? 'selected' : '' ?>>Support</option>
                  <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
                <button type="submit" name="submitBtn">Speichern</button>
              </form>
            <?php else: ?>
              (Du)
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</main>
<?php 
include ('footer.php');
if(isset($_POST['submitBtn'])) {
    // if button is pressed, update the user role
    $userId = intval($_POST['user_id']);
    $newRole = $_POST['role'];

    $validRoles = ['user', 'support', 'admin'];
    if (!in_array($newRole, $validRoles)) {
        die("Ungültige Rolle.");
    }
    if($userId === $user->getUid()) {
        die("Du kannst deine eigene Rolle nicht ändern.");
    }
    // if everything with the proposed change is okay, do it
    $db->update_user($newRole, $userId);
    header('Location: admin_user.php');
}

?>