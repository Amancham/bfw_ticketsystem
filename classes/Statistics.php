<?php
class Statistics {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAverageTicketProcessingTime() {
        $query = "
            SELECT AVG(TIMESTAMPDIFF(HOUR, t.created_at, ts.assigned_at)) as avg_hours
            FROM ticket t
            JOIN ticket_supporter ts ON t.tid = ts.tid
            WHERE t.status = 'abgeschlossen'";
        $result = $this->db->getPdo()->query($query)->fetch(PDO::FETCH_ASSOC);
        return $result['avg_hours'] ? round($result['avg_hours'], 2) . " Stunden" : "Keine Daten";
    }

    public function getTicketStatusRatio() {
        $open_query = "SELECT COUNT(*) as open_count FROM ticket WHERE status IN ('neu', 'in_bearbeitung')";
        $closed_query = "SELECT COUNT(*) as closed_count FROM ticket WHERE status = 'abgeschlossen'";
        $open_count = $this->db->getPdo()->query($open_query)->fetch(PDO::FETCH_ASSOC)['open_count'];
        $closed_count = $this->db->getPdo()->query($closed_query)->fetch(PDO::FETCH_ASSOC)['closed_count'];
        $total = $open_count + $closed_count;
        return [
            'open_count' => $open_count,
            'closed_count' => $closed_count,
            'open_ratio' => $total > 0 ? round(($open_count / $total) * 100, 2) : 0,
            'closed_ratio' => $total > 0 ? round(($closed_count / $total) * 100, 2) : 0
        ];
    }

    public function getMostActiveUsers($limit = 5) {
        $query = "
            SELECT u.username, COUNT(ts.tid) as ticket_count
            FROM ticket_supporter ts
            JOIN user u ON ts.uid = u.uid
            GROUP BY ts.uid
            ORDER BY ticket_count DESC
            LIMIT :limit";
        $stmt = $this->db->getPdo()->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>