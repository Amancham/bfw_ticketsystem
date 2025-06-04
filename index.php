<?php
include ('header.php');
if($_SESSION['uid'] === 0) {
    header("Location: login.php");
}
if($user->getRole() === 'admin') {
    $all_tickets = $db->list_all_tickets();
    $open_tickets = $db->list_open_tickets();
    $own_tickets = $db->list_my_tickets($user->getUid());
}
elseif($user->getRole() === 'support') {
    $own_tickets = $db->list_my_tickets($user->getUid());
    $open_tickets = $db->list_open_tickets();
}
else {
    $own_tickets = $db->list_my_tickets($user->getUid());
}
?>
<main class="dashboard">
<h2>Meine Tickets</h2>
<table>
    <tr>
        <th width="5%">ID</th>
        <th>Titel</th>
        <th width="15%">Priorität</th>
        <th width="15%">Status</th>
        <th width="15%">Erstellt am</th>
    </tr>
    <?php foreach ($own_tickets as $own_t): ?>
        <tr>
            <td><?= htmlspecialchars($own_t['tid']) ?></td>
            <td><?= htmlspecialchars($own_t['title']) ?></td>
            <td><?= htmlspecialchars($own_t['priority']) ?></td>
            <td><?= htmlspecialchars($own_t['status']) ?></td>
            <td><?= htmlspecialchars($own_t['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php if($user->getRole() === 'support' OR $user->getRole() === 'admin'): ?>
<h2>Offene Tickets</h2>
<table>
    <tr>
        <th width="5%">ID</th>
        <th>Titel</th>
        <th width="15%">Priorität</th>
        <th width="15%">Status</th>
        <th width="15%">Erstellt am</th>
    </tr>
    <?php foreach ($open_tickets as $open_t): ?>
        <tr>
            <td><?= htmlspecialchars($open_t['tid']) ?></td>
            <td><?= htmlspecialchars($open_t['title']) ?></td>
            <td><?= htmlspecialchars($open_t['priority']) ?></td>
            <td><?= htmlspecialchars($open_t['status']) ?></td>
            <td><?= htmlspecialchars($open_t['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<?php if($user->getRole() === 'admin'): ?>
<h2>Alle Tickets</h2>
<table>
    <tr>
        <th width="5%">ID</th>
        <th>Titel</th>
        <th width="15%">Priorität</th>
        <th width="15%">Status</th>
        <th width="15%">Erstellt am</th>
    </tr>
    <?php foreach ($all_tickets as $all_t): ?>
        <tr>
            <td><?= htmlspecialchars($all_t['tid']) ?></td>
            <td><?= htmlspecialchars($all_t['title']) ?></td>
            <td><?= htmlspecialchars($all_t['priority']) ?></td>
            <td><?= htmlspecialchars($all_t['status']) ?></td>
            <td><?= htmlspecialchars($all_t['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

</main>
<?php 
include ('footer.php');
?>