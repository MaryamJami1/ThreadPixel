<?php
class Service extends Model {
    protected $table = 'services';

    public function getActive() {
        $stmt = $this->db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function toggleActive($id) {
        $stmt = $this->db->prepare("UPDATE services SET is_active = NOT is_active WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
