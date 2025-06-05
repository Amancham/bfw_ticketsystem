<?php
include('header.php');
include('classes/Statistics.php');

if ($_SESSION['uid'] === 0 || $user->getRole() !== 'admin') {
    header("Location: index.php");
    exit();
}// hier wird üperprueft ob der Benutzer ein Admin ist


$stats = new Statistics($db); // hier wird eine Statistik-Instanz erstellt


$avg_time = $stats->getAverageTicketProcessingTime();
$ticket_ratio = $stats->getTicketStatusRatio();
$active_users = $stats->getMostActiveUsers(); // Statistik-Daten werden abgerufen
?>

<main class="stats-page">
    <div class="stats-box">
        <h2>Statistiken</h2>
        
        <div class="stats-section">
            <h3>Durchschnittliche Bearbeitungszeit (geschlossene Tickets)</h3>
            <p><?php echo htmlspecialchars($avg_time); ?></p>
        </div>
        
        <div class="stats-section">
            <h3>Verhältnis offene zu bearbeitete Tickets</h3>
            <p>Offene Tickets: <?php echo htmlspecialchars($ticket_ratio['open_count']); ?> (<?php echo $ticket_ratio['open_ratio']; ?>%)</p>
            <p>Bearbeitete Tickets: <?php echo htmlspecialchars($ticket_ratio['closed_count']); ?> (<?php echo $ticket_ratio['closed_ratio']; ?>%)</p>
        </div>
        
        <div class="stats-section">
            <h3>Meistaktive Benutzer</h3>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Benutzername</th>
                        <th>Anzahl Tickets</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($active_users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['ticket_count']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($active_users)): ?>
                        <tr>
                            <td colspan="2">Keine Daten verfügbar</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>