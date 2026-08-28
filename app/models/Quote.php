<?php
class Quote extends Model {
    protected $table = 'quotes';

    public function generateQuoteNumber() {
        $stmt = $this->db->query("SELECT MAX(id) as max_id FROM quotes");
        $maxId = $stmt->fetch()->max_id ?? 0;
        return 'TP-Q-' . str_pad($maxId + 1, 5, '0', STR_PAD_LEFT);
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT q.*, s.name as service_name FROM quotes q LEFT JOIN services s ON q.service_id = s.id WHERE q.user_id = :uid ORDER BY q.created_at DESC");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function findWithDetails($id) {
        $stmt = $this->db->prepare("SELECT q.*, s.name as service_name, u.name as customer_name, u.email as customer_email, u.business_name FROM quotes q LEFT JOIN services s ON q.service_id = s.id LEFT JOIN users u ON q.user_id = u.id WHERE q.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateStatus($id, $status, $price = null) {
        $data = ['status' => $status];
        if ($price !== null) {
            $data['quoted_price'] = $price;
        }
        return $this->update($id, $data);
    }

    public function getCountByStatus($status) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM quotes WHERE status = :status");
        $stmt->execute(['status' => $status]);
        return $stmt->fetch()->count;
    }

    public function getAllWithCustomer() {
        $stmt = $this->db->query("SELECT q.*, s.name as service_name, u.name as customer_name, u.email as customer_email FROM quotes q LEFT JOIN services s ON q.service_id = s.id LEFT JOIN users u ON q.user_id = u.id ORDER BY q.created_at DESC");
        return $stmt->fetchAll();
    }
}
