<?php
class QuoteFile extends Model {
    protected $table = 'quote_files';

    public function getByQuote($quoteId) {
        $stmt = $this->db->prepare("SELECT * FROM quote_files WHERE quote_id = :qid");
        $stmt->execute(['qid' => $quoteId]);
        return $stmt->fetchAll();
    }
}
