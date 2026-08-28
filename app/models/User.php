<?php
class User extends Model {
    protected $table = 'users';

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->create($data);
    }

    public function verifyPassword($email, $password) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function updateProfile($id, $data) {
        return $this->update($id, $data);
    }

    public function changePassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        return $this->update($id, ['password' => $hashed]);
    }

    public function getCustomers() {
        $stmt = $this->db->query("SELECT * FROM users WHERE role = 'customer' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getCustomerCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM users WHERE role = 'customer'");
        return $stmt->fetch()->count;
    }
}
