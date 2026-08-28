<?php
class Portfolio extends Model {
    protected $table = 'portfolio';

    public function getAll($orderBy = 'id DESC') {
        $stmt = $this->db->query("SELECT p.*, pc.name as category_name FROM portfolio p LEFT JOIN portfolio_categories pc ON p.category_id = pc.id ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }

    public function getFeatured() {
        $stmt = $this->db->query("SELECT p.*, pc.name as category_name FROM portfolio p LEFT JOIN portfolio_categories pc ON p.category_id = pc.id WHERE p.is_featured = 1 ORDER BY p.id DESC LIMIT 8");
        return $stmt->fetchAll();
    }

    public function getByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT p.*, pc.name as category_name FROM portfolio p LEFT JOIN portfolio_categories pc ON p.category_id = pc.id WHERE p.category_id = :cat ORDER BY p.id DESC");
        $stmt->execute(['cat' => $categoryId]);
        return $stmt->fetchAll();
    }
}
