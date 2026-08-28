<?php
class Message extends Model {
    protected $table = 'messages';

    public function getConversation($userId, $adminId = 1) {
        $stmt = $this->db->prepare("SELECT m.*, u.name as sender_name FROM messages m LEFT JOIN users u ON m.sender_id = u.id WHERE (m.sender_id = :uid AND m.receiver_id = :aid) OR (m.sender_id = :aid2 AND m.receiver_id = :uid2) ORDER BY m.created_at ASC");
        $stmt->execute(['uid' => $userId, 'aid' => $adminId, 'aid2' => $adminId, 'uid2' => $userId]);
        return $stmt->fetchAll();
    }

    public function send($senderId, $receiverId, $content, $quoteId = null, $orderId = null) {
        return $this->create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $content,
            'quote_id' => $quoteId,
            'order_id' => $orderId,
        ]);
    }

    public function markAsRead($userId, $senderId) {
        $stmt = $this->db->prepare("UPDATE messages SET is_read = 1 WHERE receiver_id = :uid AND sender_id = :sid AND is_read = 0");
        return $stmt->execute(['uid' => $userId, 'sid' => $senderId]);
    }

    public function getUnreadCount($userId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM messages WHERE receiver_id = :uid AND is_read = 0");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetch()->count;
    }

    public function getConversationList() {
        $stmt = $this->db->query("SELECT u.id, u.name, u.email, u.business_name, (SELECT COUNT(*) FROM messages WHERE receiver_id = 1 AND sender_id = u.id AND is_read = 0) as unread_count, (SELECT content FROM messages WHERE (sender_id = u.id OR receiver_id = u.id) AND (sender_id = 1 OR receiver_id = 1) ORDER BY created_at DESC LIMIT 1) as last_message FROM users u WHERE u.role = 'customer' AND u.id IN (SELECT DISTINCT sender_id FROM messages UNION SELECT DISTINCT receiver_id FROM messages) ORDER BY (SELECT MAX(created_at) FROM messages WHERE sender_id = u.id OR receiver_id = u.id) DESC");
        return $stmt->fetchAll();
    }
}
