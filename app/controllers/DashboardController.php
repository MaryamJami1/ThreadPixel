<?php
class DashboardController extends Controller {

    public function __construct() {
        Middleware::requireAuth();
    }

    public function index() {
        $quoteModel = $this->model('Quote');
        $orderModel = $this->model('Order');
        $messageModel = $this->model('Message');
        $uid = Session::userId();

        $data = [
            'title' => 'Dashboard — ThreadPixel',
            'quotes' => $quoteModel->getByUser($uid),
            'orders' => $orderModel->getByUser($uid),
            'unreadMessages' => $messageModel->getUnreadCount($uid),
        ];
        $this->view('customer/dashboard', $data);
    }

    public function quotes() {
        $quoteModel = $this->model('Quote');
        $data = [
            'title' => 'My Quotes — ThreadPixel',
            'quotes' => $quoteModel->getByUser(Session::userId()),
        ];
        $this->view('customer/quotes', $data);
    }

    public function quoteDetail($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/dashboard/quotes'); exit; }
        $quoteModel = $this->model('Quote');
        $quote = $quoteModel->findWithDetails($id);
        if (!$quote || $quote->user_id != Session::userId()) {
            Session::flash('error', 'Quote not found.');
            header('Location: ' . BASE_URL . '/dashboard/quotes'); exit;
        }
        $quoteFileModel = $this->model('QuoteFile');
        $data = [
            'title' => 'Quote #' . $quote->quote_number . ' — ThreadPixel',
            'quote' => $quote,
            'files' => $quoteFileModel->getByQuote($id),
        ];
        $this->view('customer/quote-detail', $data);
    }

    public function approveQuote($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/dashboard/quotes'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/dashboard/quotes'); exit;
        }
        $quoteModel = $this->model('Quote');
        $quote = $quoteModel->findById($id);
        if (!$quote || $quote->user_id != Session::userId() || $quote->status !== 'Quoted') {
            Session::flash('error', 'Cannot approve this quote.'); header('Location: ' . BASE_URL . '/dashboard/quotes'); exit;
        }
        $quoteModel->updateStatus($id, 'Approved');
        Session::flash('success', 'Quote approved successfully.');
        header('Location: ' . BASE_URL . '/dashboard/quoteDetail/' . $id); exit;
    }

    public function rejectQuote($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/dashboard/quotes'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/dashboard/quotes'); exit;
        }
        $quoteModel = $this->model('Quote');
        $quote = $quoteModel->findById($id);
        if (!$quote || $quote->user_id != Session::userId()) {
            Session::flash('error', 'Quote not found.'); header('Location: ' . BASE_URL . '/dashboard/quotes'); exit;
        }
        $quoteModel->updateStatus($id, 'Rejected');
        Session::flash('success', 'Quote rejected.');
        header('Location: ' . BASE_URL . '/dashboard/quotes'); exit;
    }

    public function orders() {
        $orderModel = $this->model('Order');
        $data = [
            'title' => 'My Orders — ThreadPixel',
            'orders' => $orderModel->getByUser(Session::userId()),
        ];
        $this->view('customer/orders', $data);
    }

    public function orderDetail($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/dashboard/orders'); exit; }
        $orderModel = $this->model('Order');
        $order = $orderModel->findWithDetails($id);
        if (!$order || $order->user_id != Session::userId()) {
            Session::flash('error', 'Order not found.');
            header('Location: ' . BASE_URL . '/dashboard/orders'); exit;
        }
        $orderFileModel = $this->model('OrderFile');
        $data = [
            'title' => 'Order #' . $order->order_number . ' — ThreadPixel',
            'order' => $order,
            'files' => $orderFileModel->getByOrder($id),
        ];
        $this->view('customer/order-detail', $data);
    }

    public function messages() {
        $messageModel = $this->model('Message');
        $uid = Session::userId();
        $messageModel->markAsRead($uid, 1); // Mark admin messages as read
        $data = [
            'title' => 'Messages — ThreadPixel',
            'messages' => $messageModel->getConversation($uid),
        ];
        $this->view('customer/messages', $data);
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . '/dashboard/messages'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/dashboard/messages'); exit;
        }
        $content = Validator::sanitize($_POST['content'] ?? '');
        if (empty($content)) {
            Session::flash('error', 'Message cannot be empty.'); header('Location: ' . BASE_URL . '/dashboard/messages'); exit;
        }
        $messageModel = $this->model('Message');
        $messageModel->send(Session::userId(), 1, $content); // Send to admin (user_id = 1)
        Session::flash('success', 'Message sent.');
        header('Location: ' . BASE_URL . '/dashboard/messages'); exit;
    }

    public function files() {
        $orderModel = $this->model('Order');
        $orderFileModel = $this->model('OrderFile');
        $orders = $orderModel->getByUser(Session::userId());
        $allFiles = [];
        foreach ($orders as $order) {
            if (in_array($order->status, ['Completed', 'Delivered'])) {
                $files = $orderFileModel->getByOrder($order->id);
                foreach ($files as $file) {
                    $file->order_number = $order->order_number;
                    $allFiles[] = $file;
                }
            }
        }
        $data = [
            'title' => 'My Files — ThreadPixel',
            'files' => $allFiles,
        ];
        $this->view('customer/files', $data);
    }

    public function downloadFile($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/dashboard/files'); exit; }
        $orderFileModel = $this->model('OrderFile');
        $file = $orderFileModel->findById($id);
        if (!$file) {
            Session::flash('error', 'File not found.'); header('Location: ' . BASE_URL . '/dashboard/files'); exit;
        }
        // Verify ownership
        $orderModel = $this->model('Order');
        $order = $orderModel->findById($file->order_id);
        if (!$order || $order->user_id != Session::userId()) {
            Session::flash('error', 'Unauthorized.'); header('Location: ' . BASE_URL . '/dashboard/files'); exit;
        }
        $filePath = ROOT_PATH . '/public/' . $file->file_path;
        if (file_exists($filePath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file->file_name . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }
        Session::flash('error', 'File not found on server.'); header('Location: ' . BASE_URL . '/dashboard/files'); exit;
    }

    public function profile() {
        $userModel = $this->model('User');
        $user = $userModel->findById(Session::userId());
        $data = [
            'title' => 'Profile — ThreadPixel',
            'user' => $user,
        ];
        $this->view('customer/profile', $data);
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . '/dashboard/profile'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/dashboard/profile'); exit;
        }
        $name = Validator::sanitize($_POST['name'] ?? '');
        $businessName = Validator::sanitize($_POST['business_name'] ?? '');
        $country = Validator::sanitize($_POST['country'] ?? '');
        $validator = new Validator();
        $validator->required('name', $name, 'Full Name');
        if ($validator->hasErrors()) {
            Session::flash('error', $validator->firstError()); header('Location: ' . BASE_URL . '/dashboard/profile'); exit;
        }
        $userModel = $this->model('User');
        $userModel->updateProfile(Session::userId(), ['name' => $name, 'business_name' => $businessName, 'country' => $country]);
        $_SESSION['user_name'] = $name;
        Session::flash('success', 'Profile updated successfully.');
        header('Location: ' . BASE_URL . '/dashboard/profile'); exit;
    }

    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . '/dashboard/profile'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/dashboard/profile'); exit;
        }
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $validator = new Validator();
        $validator->required('current_password', $current, 'Current Password')
                  ->required('new_password', $new, 'New Password')
                  ->minLength('new_password', $new, 8, 'New Password')
                  ->match('confirm_password', $new, $confirm, 'Passwords');
        if ($validator->hasErrors()) {
            Session::flash('error', $validator->firstError()); header('Location: ' . BASE_URL . '/dashboard/profile'); exit;
        }
        $userModel = $this->model('User');
        $user = $userModel->findById(Session::userId());
        if (!password_verify($current, $user->password)) {
            Session::flash('error', 'Current password is incorrect.'); header('Location: ' . BASE_URL . '/dashboard/profile'); exit;
        }
        $userModel->changePassword(Session::userId(), $new);
        Session::flash('success', 'Password changed successfully.');
        header('Location: ' . BASE_URL . '/dashboard/profile'); exit;
    }
}
