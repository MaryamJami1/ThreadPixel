<?php
class AuthController extends Controller {

    public function login() {
        Middleware::requireGuest();
        $this->view('auth/login');
    }

    public function loginPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid security token. Please try again.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $email = Validator::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $validator = new Validator();
        $validator->required('email', $email, 'Email')
                  ->email('email', $email)
                  ->required('password', $password, 'Password');

        if ($validator->hasErrors()) {
            Session::flash('error', $validator->firstError());
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $userModel = $this->model('User');
        $user = $userModel->verifyPassword($email, $password);

        if ($user) {
            Session::setUser($user);
            Session::flash('success', 'Welcome back, ' . $user->name . '!');
            if ($user->role === 'admin') {
                header('Location: ' . BASE_URL . '/admin');
            } else {
                header('Location: ' . BASE_URL . '/dashboard');
            }
        } else {
            Session::flash('error', 'Invalid email or password.');
            header('Location: ' . BASE_URL . '/auth/login');
        }
        exit;
    }

    public function register() {
        Middleware::requireGuest();
        $this->view('auth/register');
    }

    public function registerPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/auth/register');
            exit;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid security token. Please try again.');
            header('Location: ' . BASE_URL . '/auth/register');
            exit;
        }

        $name = Validator::sanitize($_POST['name'] ?? '');
        $email = Validator::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $businessName = Validator::sanitize($_POST['business_name'] ?? '');
        $country = Validator::sanitize($_POST['country'] ?? '');

        $validator = new Validator();
        $validator->required('name', $name, 'Full Name')
                  ->required('email', $email, 'Email')
                  ->email('email', $email)
                  ->required('password', $password, 'Password')
                  ->minLength('password', $password, 8, 'Password')
                  ->match('confirm_password', $password, $confirmPassword, 'Passwords');

        if ($validator->hasErrors()) {
            Session::flash('error', $validator->firstError());
            header('Location: ' . BASE_URL . '/auth/register');
            exit;
        }

        $userModel = $this->model('User');

        if ($userModel->findByEmail($email)) {
            Session::flash('error', 'An account with this email already exists.');
            header('Location: ' . BASE_URL . '/auth/register');
            exit;
        }

        $userId = $userModel->register([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'business_name' => $businessName,
            'country' => $country,
            'role' => 'customer',
        ]);

        $user = $userModel->findById($userId);
        Session::setUser($user);
        Session::flash('success', 'Welcome to ThreadPixel! Your account has been created.');
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }

    public function logout() {
        Session::destroy();
        session_start();
        Session::flash('success', 'You have been logged out successfully.');
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }

    public function forgotPassword() {
        $this->view('auth/forgot-password');
    }

    public function resetPassword() {
        // Placeholder for password reset logic
        Session::flash('info', 'Password reset functionality will be available soon. Please contact support.');
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
}
