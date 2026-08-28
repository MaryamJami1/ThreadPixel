<?php
class Setting extends Model {
    protected $table = 'settings';

    public function get($key, $default = null) {
        $stmt = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_key = :key");
        $stmt->execute(['key' => $key]);
        $result = $stmt->fetch();
        return $result ? $result->setting_value : $default;
    }

    public function set($key, $value) {
        $existing = $this->get($key);
        if ($existing !== null) {
            $stmt = $this->db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key");
            return $stmt->execute(['val' => $value, 'key' => $key]);
        } else {
            return $this->create(['setting_key' => $key, 'setting_value' => $value]);
        }
    }
}
