<?php
class Order extends Model {
    protected $table = 'orders';

    public function generateOrderNumber() {
        $stmt = $this->db->query("SELECT MAX(id) as max_id FROM orders");
        $maxId = $stmt->fetch()->max_id ?? 0;
        return 'TP-ORD-' . str_pad($maxId + 1, 5, '0', STR_PAD_LEFT);
    }

    public function createFromQuote($quoteId, $userId, $price) {
        return $this->create([
            'order_number' => $this->generateOrderNumber(),
            'quote_id' => $quoteId,
            'user_id' => $userId,
            'status' => 'Awaiting Payment',
            'total_price' => $price,
        ]);
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT o.*, q.quote_number, q.service_id, s.name as service_name FROM orders o LEFT JOIN quotes q ON o.quote_id = q.id LEFT JOIN services s ON q.service_id = s.id WHERE o.user_id = :uid ORDER BY o.created_at DESC");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function findWithDetails($id) {
        $stmt = $this->db->prepare("SELECT o.*, q.quote_number, q.design_size, q.garment_type, q.machine_format, q.quantity, q.additional_instructions, s.name as service_name, u.name as customer_name, u.email as customer_email, u.business_name FROM orders o LEFT JOIN quotes q ON o.quote_id = q.id LEFT JOIN services s ON q.service_id = s.id LEFT JOIN users u ON o.user_id = u.id WHERE o.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateStatus($id, $status) {
        return $this->update($id, ['status' => $status]);
    }

    public function getCountByStatus($status) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = :status");
        $stmt->execute(['status' => $status]);
        return $stmt->fetch()->count;
    }

    public function getRevenue() {
        $stmt = $this->db->query("SELECT COALESCE(SUM(total_price), 0) as revenue FROM orders WHERE status IN ('Paid','In Digitizing','Quality Check','Completed','Delivered')");
        return $stmt->fetch()->revenue;
    }

    public function getAllWithCustomer() {
        $stmt = $this->db->query("SELECT o.*, u.name as customer_name, u.email as customer_email, s.name as service_name, q.quote_number FROM orders o LEFT JOIN users u ON o.user_id = u.id LEFT JOIN quotes q ON o.quote_id = q.id LEFT JOIN services s ON q.service_id = s.id ORDER BY o.created_at DESC");
        return $stmt->fetchAll();
    }
}
