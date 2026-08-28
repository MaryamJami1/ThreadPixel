<?php
class ContactController extends Controller {
    public function index() {
        $this->view('contact/index', ['title' => 'Contact — ThreadPixel']);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/contact');
            exit;
        }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid security token.');
            header('Location: ' . BASE_URL . '/contact');
            exit;
        }

        $name = Validator::sanitize($_POST['name'] ?? '');
        $email = Validator::sanitize($_POST['email'] ?? '');
        $subject = Validator::sanitize($_POST['subject'] ?? '');
        $message = Validator::sanitize($_POST['message'] ?? '');

        $validator = new Validator();
        $validator->required('name', $name)
                  ->required('email', $email)
                  ->email('email', $email)
                  ->required('message', $message);

        if ($validator->hasErrors()) {
            Session::flash('error', $validator->firstError());
            header('Location: ' . BASE_URL . '/contact');
            exit;
        }

        // In production, send email. For now, store as message to admin.
        if (Session::isLoggedIn()) {
            $msgModel = $this->model('Message');
            $msgModel->send(Session::userId(), 1, "[Contact Form - {$subject}] {$message}");
        }

        Session::flash('success', 'Your message has been sent. We will get back to you soon.');
        header('Location: ' . BASE_URL . '/contact');
        exit;
    }
}
