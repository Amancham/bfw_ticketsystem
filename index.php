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
    <?php foreach ($own_tickets as $own_t): 
        if($own_t['priority'] === 1) {
            $priority = "<span class=\"prio_high\">Hoch</span>";
        }
        elseif ($own_t['priority'] === 2) {
            $priority = "<span class=\"prio_mid\">Medium</span>";
        }
        elseif ($own_t['priority'] === 3) {
            $priority = "<span class=\"prio_low\">Niedrig</span>";
        }
        else {
            $priority = "Fehler";
        }
        if($own_t['status'] === 'neu') {
            $status = "<span class=\"state_new\">Neu</span>";
        }
        elseif($own_t['status'] === 'in_bearbeitung') {
            $status = "<span class=\"state_active\">In Bearbeitung</span>";
        }
        elseif($own_t['status'] === 'abgeschlossen') {
            $status = "<span class=\"state_done\">Abgeschlossen</span>";
        }
        else {
            $status = "Fehler";
        }
    ?>
        <tr>
            <td><?= htmlspecialchars($own_t['tid']) ?></td>
            <td><a href="ticket.php?mode=view&id=<?= htmlspecialchars($own_t['tid']) ?>"><?= htmlspecialchars($own_t['title']) ?></a></td>
            <td><?= $priority ?></td>
            <td><?= $status ?></td>
            <td><?= htmlspecialchars($own_t['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($own_tickets)): ?>
        <tr>
            <td colspan="5">Du hast noch keine Tickets erstellt.</td>
        </tr>
    <?php endif; ?>
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
    <?php foreach ($open_tickets as $open_t): 
        if($open_t['priority'] === 1) {
            $priority = "<span class=\"prio_high\">Hoch</span>";
        }
        elseif ($open_t['priority'] === 2) {
            $priority = "<span class=\"prio_mid\">Medium</span>";
        }
        elseif ($open_t['priority'] === 3) {
            $priority = "<span class=\"prio_low\">Niedrig</span>";
        }
        else {
            $priority = "Fehler";
        }
        if($open_t['status'] === 'neu') {
            $status = "<span class=\"state_new\">Neu</span>";
        }
        elseif($open_t['status'] === 'in_bearbeitung') {
            $status = "<span class=\"state_active\">In Bearbeitung</span>";
        }
        elseif($open_t['status'] === 'abgeschlossen') {
            $status = "<span class=\"state_done\">Abgeschlossen</span>";
        }
        else {
            $status = "Fehler";
        }
    ?>
        <tr>
            <td><?= htmlspecialchars($open_t['tid']) ?></td>
            <td><a href="ticket.php?mode=view&id=<?= htmlspecialchars($open_t['tid']) ?>"><?= htmlspecialchars($open_t['title']) ?></a></td>
            <td><?= $priority; ?></td>
            <td><?= $status; ?></td>
            <td><?= htmlspecialchars($open_t['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($open_tickets)): ?>
        <tr>
            <td colspan="5">Es gibt keine offenen Tickets</td>
        </tr>
    <?php endif; ?>
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
    <?php foreach ($all_tickets as $all_t): 
        if($all_t['priority'] === 1) {
            $priority = "<span class=\"prio_high\">Hoch</span>";
        }
        elseif ($all_t['priority'] === 2) {
            $priority = "<span class=\"prio_mid\">Medium</span>";
        }
        elseif ($all_t['priority'] === 3) {
            $priority = "<span class=\"prio_low\">Niedrig</span>";
        }
        else {
            $priority = "Fehler";
        }
        if($all_t['status'] === 'neu') {
            $status = "<span class=\"state_new\">Neu</span>";
        }
        elseif($all_t['status'] === 'in_bearbeitung') {
            $status = "<span class=\"state_active\">In Bearbeitung</span>";
        }
        elseif($all_t['status'] === 'abgeschlossen') {
            $status = "<span class=\"state_done\">Abgeschlossen</span>";
        }
        else {
            $status = "Fehler";
        }
    ?>
        <tr>
            <td><?= htmlspecialchars($all_t['tid']) ?></td>
            <td><a href="ticket.php?mode=view&id=<?= htmlspecialchars($all_t['tid']) ?>"><?= htmlspecialchars($all_t['title']) ?></a></td>
            <td><?= $priority; ?></td>
            <td><?= $status; ?></td>
            <td><?= htmlspecialchars($all_t['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($all_tickets)): ?>
        <tr>
            <td colspan="5">Es wurden noch keine Tickets erstellt</td>
        </tr>
    <?php endif; ?>
</table>
<?php endif; ?>

</main>
<?php 
include ('footer.php');
?>