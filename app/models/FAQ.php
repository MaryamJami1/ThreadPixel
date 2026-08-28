<?php
class FAQ extends Model {
    protected $table = 'faqs';

    public function getActive() {
        $stmt = $this->db->query("SELECT * FROM faqs WHERE is_active = 1 ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function getByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM faqs WHERE category = :cat AND is_active = 1 ORDER BY id ASC");
        $stmt->execute(['cat' => $category]);
        return $stmt->fetchAll();
    }

    public function getGroupedByCategory() {
        $faqs = $this->getActive();
        $grouped = [];
        foreach ($faqs as $faq) {
            $grouped[$faq->category][] = $faq;
        }
        return $grouped;
    }

    public function toggleActive($id) {
        $stmt = $this->db->prepare("UPDATE faqs SET is_active = NOT is_active WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
