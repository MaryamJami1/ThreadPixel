<?php
class Testimonial extends Model {
    protected $table = 'testimonials';

    public function getActive() {
        $stmt = $this->db->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function toggleActive($id) {
        $stmt = $this->db->prepare("UPDATE testimonials SET is_active = NOT is_active WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
