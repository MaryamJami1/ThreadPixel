<?php
class OrderFile extends Model {
    protected $table = 'order_files';

    public function getByOrder($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM order_files WHERE order_id = :oid");
        $stmt->execute(['oid' => $orderId]);
        return $stmt->fetchAll();
    }
}
