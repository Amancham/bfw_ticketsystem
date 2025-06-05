<?php 
include("header.php");

if (!(isset($_GET['mode']) && isset($_GET['id']))) {
    echo("<h2>Fehler: Diese Seite ist nicht für den Direktaufruf. Modus oder Ticket-ID fehlen.</h2>");
    die();
}
else
{
    $mode = $_GET['mode'];
    $ticket_id = intval($_GET['id']);
    switch($mode) 
    {
        case 'view':
            $ticket = $db->show_ticket($ticket_id);
            $notes = $db->show_notes($ticket_id);
            break;
        case 'add_note':
            break;
        case 'edit':
            break;
        case 'do_edit':
            break;
    }
}
?>
<main class="dashboard">

<!-- display single ticket including comments/notes for the ticket  mode=view?id=x?? -->
<?php if($mode === 'view'): ?>
    <div class="view-ticket">
        <!-- dropped due to time constraints 
        <?php if($user->getRole() === 'admin'): ?>
            <a href="ticket.php?mode=edit&id=<?= htmlspecialchars($ticket['tid']) ?>">Bearbeiten</a>
        <?php endif; ?>
        -->
        <h2><?= htmlspecialchars($ticket['title']) ?></h2>
        <p><?= htmlspecialchars($ticket['description']) ?></p>
        <p class="ticket-supporter">Geschrieben von <strong><?= htmlspecialchars($ticket['username']) ?></strong> am <?= htmlspecialchars($ticket['created_at']) ?></p>
        <div class="ticket-state">
            <?php if($ticket['priority'] === 1) {
                $priority = "<span class=\"prio_high\">Hoch</span>";
            }
            elseif ($ticket['priority'] === 2) {
                $priority = "<span class=\"prio_mid\">Medium</span>";
            }
            elseif ($ticket['priority'] === 3) {
                $priority = "<span class=\"prio_low\">Niedrig</span>";
            }
            else {
                $priority = "Fehler";
            }
            if($ticket['status'] === 'neu') {
                $status = "<span class=\"state_new\">Neu</span>";
            }
            elseif($ticket['status'] === 'in_bearbeitung') {
                $status = "<span class=\"state_active\">In Bearbeitung</span>";
            }
            elseif($ticket['status'] === 'abgeschlossen') {
                $status = "<span class=\"state_done\">Abgeschlossen</span>";
            }
            else {
                $status = "Fehler";
            }
            ?>
            Priorität: <?= $priority; ?>
            Status: <?= $status; ?>
        </div>
        <?php foreach($notes as $note): ?>
            <div class="ticket-note">
                <p><?= htmlspecialchars($note['note']) ?></p>
                <span class="ticket-supporter">Hinzugefügt am <?= htmlspecialchars($note['created_at']) ?> von <?= htmlspecialchars($note['username']) ?></span>
            </div>
        <?php endforeach; ?>
        <?php if (empty($notes)): ?>
            <p>Es gibt noch keine Kommentare.</p>
        <?php endif; ?>
        <div class="ticket-note-add">
            <form action="ticket.php?mode=add_note&id=<?= htmlspecialchars($ticket['tid']) ?>" method="post">
                <label for="note"><strong>Kommentar hinzufügen</strong></label><br>
                <textarea id="note" name="note" rows="7" required></textarea><br>
                <?php if($user->getRole() === 'admin' || $user->getRole() === 'support'): ?>
                    <input type="radio" id="in_bearbeitung" name="status" value="in_bearbeitung" <?php if($ticket['status'] === 'in_bearbeitung'): ?>checked<?php endif; ?>>
                    <label for="in_bearbeitung">In Bearbeitung</label><br>
                    <input type="radio" id="abgeschlossen" name="status" value="abgeschlossen" <?php if($ticket['status'] === 'abgeschlossen'): ?>checked<?php endif; ?>>
                    <label for="abgeschlossen">Abgeschlossen</label><br>
                    <?php else: ?>
                        <input type="hidden" name="status" value="<?= htmlspecialchars($ticket['status']) ?>">
                <?php endif; ?>
                <button type="submit" name="send">Hinzufügen</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php if($mode === 'edit'): ?>
<h2>Ticket bearbeiten</h2>
<p>Geplant: die Admins sollten das Ticket insgesamt bearbeiten können, nicht nur den Status. Aus zeitlichen Gründen nicht implementiert.</p> 
<?php endif; ?>

<?php
if($mode === 'add_note') 
{
    if(isset($_POST['send']) && !empty($_POST['note'])) {
        // call add note function 
        if($db->check_status($ticket_id, $_POST['status'])) {
            $db->edit_status($ticket_id, $_POST['status']);
            echo("<p>Der Status wurde geändert.</p>");
        }
        $db->add_note($ticket_id, $user->getUid(), $_POST['note']);
        if (($user->getRole() === 'admin' OR $user->getRole() === 'support') AND $db->check_supporter($ticket_id, $user->getUid())) {
            $db->add_supporter($ticket_id, $user->getUid());
        }
        echo("<p>Der Kommentar wurde hinzugefügt. Sie werden gleich zurückgeleitet.");
        header("Refresh:1.25;url=ticket.php?mode=view&id=".$ticket_id."");
        

    }
    else {
        echo("<p>Es wurde kein Kommentar eingegeben.</p> <button onclick=\"history.back()\">Zurück</button>");
    }
    
}

if($mode === 'do_edit') 
{
    // call edit ticket function not yet implemented
}
?>
</main>
<?php include("footer.php"); ?>