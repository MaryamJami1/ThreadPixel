<?php
/**
 * ThreadPixel - Session Helper
 */

class Session {
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function remove($key) {
        unset($_SESSION[$key]);
    }

    public static function flash($key, $value) {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function getFlash($key, $default = null) {
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    public static function hasFlash($key) {
        return isset($_SESSION['_flash'][$key]);
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function userId() {
        return $_SESSION['user_id'] ?? null;
    }

    public static function userName() {
        return $_SESSION['user_name'] ?? null;
    }

    public static function userRole() {
        return $_SESSION['user_role'] ?? null;
    }

    public static function isAdmin() {
        return self::userRole() === 'admin';
    }

    public static function destroy() {
        session_unset();
        session_destroy();
    }

    public static function setUser($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_role'] = $user->role;
    }
}
