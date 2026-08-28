<?php
/**
 * ThreadPixel - Auth Middleware
 */

class Middleware {
    public static function requireAuth() {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Please log in to access this page.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    public static function requireAdmin() {
        self::requireAuth();
        if (!Session::isAdmin()) {
            Session::flash('error', 'Unauthorized access.');
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }

    public static function requireGuest() {
        if (Session::isLoggedIn()) {
            if (Session::isAdmin()) {
                header('Location: ' . BASE_URL . '/admin');
            } else {
                header('Location: ' . BASE_URL . '/dashboard');
            }
            exit;
        }
    }
}
