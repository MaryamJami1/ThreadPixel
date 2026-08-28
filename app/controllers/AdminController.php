<?php
class AdminController extends Controller {

    public function __construct() {
        Middleware::requireAdmin();
    }

    public function index() {
        $userModel = $this->model('User');
        $quoteModel = $this->model('Quote');
        $orderModel = $this->model('Order');
        $messageModel = $this->model('Message');

        $data = [
            'title' => 'Admin Dashboard — ThreadPixel',
            'totalCustomers' => $userModel->getCustomerCount(),
            'pendingQuotes' => $quoteModel->getCountByStatus('Pending'),
            'activeOrders' => $orderModel->getCount() - $orderModel->getCountByStatus('Delivered') - $orderModel->getCountByStatus('Cancelled'),
            'completedOrders' => $orderModel->getCountByStatus('Delivered'),
            'revenue' => $orderModel->getRevenue(),
            'unreadMessages' => $messageModel->getUnreadCount(1),
        ];
        $this->view('admin/dashboard', $data);
    }

    // ===== CUSTOMERS =====
    public function customers() {
        $userModel = $this->model('User');
        $this->view('admin/customers', [
            'title' => 'Customers — Admin',
            'customers' => $userModel->getCustomers(),
        ]);
    }

    // ===== QUOTES =====
    public function quotes() {
        $quoteModel = $this->model('Quote');
        $this->view('admin/quotes', [
            'title' => 'Quotes — Admin',
            'quotes' => $quoteModel->getAllWithCustomer(),
        ]);
    }

    public function quoteDetail($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/admin/quotes'); exit; }
        $quoteModel = $this->model('Quote');
        $quote = $quoteModel->findWithDetails($id);
        if (!$quote) { Session::flash('error', 'Quote not found.'); header('Location: ' . BASE_URL . '/admin/quotes'); exit; }
        $quoteFileModel = $this->model('QuoteFile');
        $this->view('admin/quote-detail', [
            'title' => 'Quote #' . $quote->quote_number . ' — Admin',
            'quote' => $quote,
            'files' => $quoteFileModel->getByQuote($id),
        ]);
    }

    public function updateQuoteStatus($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/quotes'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/quotes'); exit; }
        $status = Validator::sanitize($_POST['status'] ?? '');
        $price = isset($_POST['quoted_price']) ? (float)$_POST['quoted_price'] : null;
        $quoteModel = $this->model('Quote');
        $quoteModel->updateStatus($id, $status, $price);
        Session::flash('success', 'Quote status updated.');
        header('Location: ' . BASE_URL . '/admin/quoteDetail/' . $id); exit;
    }

    public function convertToOrder($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/quotes'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/quotes'); exit; }
        $quoteModel = $this->model('Quote');
        $quote = $quoteModel->findById($id);
        if (!$quote || $quote->status !== 'Approved') {
            Session::flash('error', 'Quote must be approved before converting to order.'); header('Location: ' . BASE_URL . '/admin/quoteDetail/' . $id); exit;
        }
        $orderModel = $this->model('Order');
        $orderModel->createFromQuote($quote->id, $quote->user_id, $quote->quoted_price ?? 0);
        $quoteModel->updateStatus($id, 'Converted to Order');
        Session::flash('success', 'Quote converted to order successfully.');
        header('Location: ' . BASE_URL . '/admin/orders'); exit;
    }

    // ===== ORDERS =====
    public function orders() {
        $orderModel = $this->model('Order');
        $this->view('admin/orders', [
            'title' => 'Orders — Admin',
            'orders' => $orderModel->getAllWithCustomer(),
        ]);
    }

    public function orderDetail($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/admin/orders'); exit; }
        $orderModel = $this->model('Order');
        $order = $orderModel->findWithDetails($id);
        if (!$order) { Session::flash('error', 'Order not found.'); header('Location: ' . BASE_URL . '/admin/orders'); exit; }
        $orderFileModel = $this->model('OrderFile');
        $this->view('admin/order-detail', [
            'title' => 'Order #' . $order->order_number . ' — Admin',
            'order' => $order,
            'files' => $orderFileModel->getByOrder($id),
        ]);
    }

    public function updateOrderStatus($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/orders'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/orders'); exit; }
        $status = Validator::sanitize($_POST['status'] ?? '');
        $orderModel = $this->model('Order');
        $orderModel->updateStatus($id, $status);
        Session::flash('success', 'Order status updated.');
        header('Location: ' . BASE_URL . '/admin/orderDetail/' . $id); exit;
    }

    public function uploadOrderFile($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/orders'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/orderDetail/' . $id); exit; }
        if (!isset($_FILES['file']) || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
            Session::flash('error', 'Please select a file.'); header('Location: ' . BASE_URL . '/admin/orderDetail/' . $id); exit;
        }
        $uploader = new FileUpload('artwork');
        $result = $uploader->upload($_FILES['file'], 'orders');
        if ($result['success']) {
            $fileType = Validator::sanitize($_POST['file_type'] ?? 'final_design');
            $orderFileModel = $this->model('OrderFile');
            $orderFileModel->create([
                'order_id' => $id,
                'file_type' => $fileType,
                'file_path' => $result['file_path'],
                'file_name' => $result['file_name'],
            ]);
            Session::flash('success', 'File uploaded successfully.');
        } else {
            Session::flash('error', $result['error']);
        }
        header('Location: ' . BASE_URL . '/admin/orderDetail/' . $id); exit;
    }

    // ===== PORTFOLIO =====
    public function portfolio() {
        $portfolioModel = $this->model('Portfolio');
        $this->view('admin/portfolio', [
            'title' => 'Portfolio — Admin',
            'items' => $portfolioModel->getAll(),
        ]);
    }

    public function addPortfolio() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/addPortfolio'); exit; }
            $data = [
                'category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
                'title' => Validator::sanitize($_POST['title'] ?? ''),
                'description' => Validator::sanitize($_POST['description'] ?? ''),
                'stitch_count' => (int)($_POST['stitch_count'] ?? 0) ?: null,
                'dimensions' => Validator::sanitize($_POST['dimensions'] ?? ''),
                'machine_formats' => Validator::sanitize($_POST['machine_formats'] ?? ''),
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            ];
            // Handle image uploads
            $uploader = new FileUpload('image');
            foreach (['original_artwork', 'digitized_preview', 'actual_embroidery'] as $field) {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                    $result = $uploader->upload($_FILES[$field], 'portfolio');
                    if ($result['success']) { $data[$field . '_path'] = $result['file_path']; }
                }
            }
            $portfolioModel = $this->model('Portfolio');
            $portfolioModel->create($data);
            Session::flash('success', 'Portfolio item added.');
            header('Location: ' . BASE_URL . '/admin/portfolio'); exit;
        }
        $categoryModel = $this->model('PortfolioCategory');
        $this->view('admin/portfolio-form', [
            'title' => 'Add Portfolio — Admin',
            'categories' => $categoryModel->findAll('id ASC'),
            'item' => null,
        ]);
    }

    public function editPortfolio($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/admin/portfolio'); exit; }
        $portfolioModel = $this->model('Portfolio');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/editPortfolio/' . $id); exit; }
            $data = [
                'category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
                'title' => Validator::sanitize($_POST['title'] ?? ''),
                'description' => Validator::sanitize($_POST['description'] ?? ''),
                'stitch_count' => (int)($_POST['stitch_count'] ?? 0) ?: null,
                'dimensions' => Validator::sanitize($_POST['dimensions'] ?? ''),
                'machine_formats' => Validator::sanitize($_POST['machine_formats'] ?? ''),
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            ];
            $uploader = new FileUpload('image');
            foreach (['original_artwork', 'digitized_preview', 'actual_embroidery'] as $field) {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                    $result = $uploader->upload($_FILES[$field], 'portfolio');
                    if ($result['success']) { $data[$field . '_path'] = $result['file_path']; }
                }
            }
            $portfolioModel->update($id, $data);
            Session::flash('success', 'Portfolio item updated.');
            header('Location: ' . BASE_URL . '/admin/portfolio'); exit;
        }
        $item = $portfolioModel->findById($id);
        $categoryModel = $this->model('PortfolioCategory');
        $this->view('admin/portfolio-form', [
            'title' => 'Edit Portfolio — Admin',
            'categories' => $categoryModel->findAll('id ASC'),
            'item' => $item,
        ]);
    }

    public function deletePortfolio($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/portfolio'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/portfolio'); exit; }
        $portfolioModel = $this->model('Portfolio');
        $portfolioModel->delete($id);
        Session::flash('success', 'Portfolio item deleted.');
        header('Location: ' . BASE_URL . '/admin/portfolio'); exit;
    }

    // ===== SERVICES =====
    public function services() {
        $serviceModel = $this->model('Service');
        $this->view('admin/services', ['title' => 'Services — Admin', 'services' => $serviceModel->findAll()]);
    }

    public function addService() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/addService'); exit; }
            $serviceModel = $this->model('Service');
            $serviceModel->create([
                'name' => Validator::sanitize($_POST['name'] ?? ''),
                'description' => Validator::sanitize($_POST['description'] ?? ''),
                'starting_price' => (float)($_POST['starting_price'] ?? 0),
                'suitable_applications' => Validator::sanitize($_POST['suitable_applications'] ?? ''),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            Session::flash('success', 'Service added.');
            header('Location: ' . BASE_URL . '/admin/services'); exit;
        }
        $this->view('admin/service-form', ['title' => 'Add Service — Admin', 'service' => null]);
    }

    public function editService($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/admin/services'); exit; }
        $serviceModel = $this->model('Service');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/editService/' . $id); exit; }
            $serviceModel->update($id, [
                'name' => Validator::sanitize($_POST['name'] ?? ''),
                'description' => Validator::sanitize($_POST['description'] ?? ''),
                'starting_price' => (float)($_POST['starting_price'] ?? 0),
                'suitable_applications' => Validator::sanitize($_POST['suitable_applications'] ?? ''),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            Session::flash('success', 'Service updated.');
            header('Location: ' . BASE_URL . '/admin/services'); exit;
        }
        $this->view('admin/service-form', ['title' => 'Edit Service — Admin', 'service' => $serviceModel->findById($id)]);
    }

    public function deleteService($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/services'); exit; }
        $serviceModel = $this->model('Service');
        $serviceModel->delete($id);
        Session::flash('success', 'Service deleted.');
        header('Location: ' . BASE_URL . '/admin/services'); exit;
    }

    // ===== FAQS =====
    public function faqs() {
        $faqModel = $this->model('FAQ');
        $this->view('admin/faqs', ['title' => 'FAQs — Admin', 'faqs' => $faqModel->findAll()]);
    }

    public function addFaq() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/addFaq'); exit; }
            $faqModel = $this->model('FAQ');
            $faqModel->create([
                'category' => Validator::sanitize($_POST['category'] ?? 'General'),
                'question' => Validator::sanitize($_POST['question'] ?? ''),
                'answer' => Validator::sanitize($_POST['answer'] ?? ''),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            Session::flash('success', 'FAQ added.');
            header('Location: ' . BASE_URL . '/admin/faqs'); exit;
        }
        $this->view('admin/faq-form', ['title' => 'Add FAQ — Admin', 'faq' => null]);
    }

    public function editFaq($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/admin/faqs'); exit; }
        $faqModel = $this->model('FAQ');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/editFaq/' . $id); exit; }
            $faqModel->update($id, [
                'category' => Validator::sanitize($_POST['category'] ?? 'General'),
                'question' => Validator::sanitize($_POST['question'] ?? ''),
                'answer' => Validator::sanitize($_POST['answer'] ?? ''),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            Session::flash('success', 'FAQ updated.');
            header('Location: ' . BASE_URL . '/admin/faqs'); exit;
        }
        $this->view('admin/faq-form', ['title' => 'Edit FAQ — Admin', 'faq' => $faqModel->findById($id)]);
    }

    public function deleteFaq($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/faqs'); exit; }
        $faqModel = $this->model('FAQ');
        $faqModel->delete($id);
        Session::flash('success', 'FAQ deleted.');
        header('Location: ' . BASE_URL . '/admin/faqs'); exit;
    }

    // ===== TESTIMONIALS =====
    public function testimonials() {
        $model = $this->model('Testimonial');
        $this->view('admin/testimonials', ['title' => 'Testimonials — Admin', 'testimonials' => $model->findAll()]);
    }

    public function addTestimonial() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/addTestimonial'); exit; }
            $model = $this->model('Testimonial');
            $model->create([
                'client_name' => Validator::sanitize($_POST['client_name'] ?? ''),
                'business_name' => Validator::sanitize($_POST['business_name'] ?? ''),
                'content' => Validator::sanitize($_POST['content'] ?? ''),
                'rating' => (int)($_POST['rating'] ?? 5),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            Session::flash('success', 'Testimonial added.');
            header('Location: ' . BASE_URL . '/admin/testimonials'); exit;
        }
        $this->view('admin/testimonial-form', ['title' => 'Add Testimonial — Admin', 'testimonial' => null]);
    }

    public function editTestimonial($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/admin/testimonials'); exit; }
        $model = $this->model('Testimonial');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/editTestimonial/' . $id); exit; }
            $model->update($id, [
                'client_name' => Validator::sanitize($_POST['client_name'] ?? ''),
                'business_name' => Validator::sanitize($_POST['business_name'] ?? ''),
                'content' => Validator::sanitize($_POST['content'] ?? ''),
                'rating' => (int)($_POST['rating'] ?? 5),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            Session::flash('success', 'Testimonial updated.');
            header('Location: ' . BASE_URL . '/admin/testimonials'); exit;
        }
        $this->view('admin/testimonial-form', ['title' => 'Edit Testimonial — Admin', 'testimonial' => $model->findById($id)]);
    }

    public function deleteTestimonial($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/testimonials'); exit; }
        $model = $this->model('Testimonial');
        $model->delete($id);
        Session::flash('success', 'Testimonial deleted.');
        header('Location: ' . BASE_URL . '/admin/testimonials'); exit;
    }

    // ===== CHATBOT KNOWLEDGE =====
    public function chatbotKnowledge() {
        $model = $this->model('ChatbotKnowledge');
        $this->view('admin/chatbot-knowledge', ['title' => 'Chatbot KB — Admin', 'items' => $model->findAll()]);
    }

    public function addKnowledge() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/addKnowledge'); exit; }
            $model = $this->model('ChatbotKnowledge');
            $model->create([
                'category' => Validator::sanitize($_POST['category'] ?? 'General'),
                'keywords' => Validator::sanitize($_POST['keywords'] ?? ''),
                'question' => Validator::sanitize($_POST['question'] ?? ''),
                'answer' => Validator::sanitize($_POST['answer'] ?? ''),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            Session::flash('success', 'Knowledge entry added.');
            header('Location: ' . BASE_URL . '/admin/chatbotKnowledge'); exit;
        }
        $this->view('admin/knowledge-form', ['title' => 'Add KB Entry — Admin', 'item' => null]);
    }

    public function editKnowledge($id = null) {
        if (!$id) { header('Location: ' . BASE_URL . '/admin/chatbotKnowledge'); exit; }
        $model = $this->model('ChatbotKnowledge');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/editKnowledge/' . $id); exit; }
            $model->update($id, [
                'category' => Validator::sanitize($_POST['category'] ?? 'General'),
                'keywords' => Validator::sanitize($_POST['keywords'] ?? ''),
                'question' => Validator::sanitize($_POST['question'] ?? ''),
                'answer' => Validator::sanitize($_POST['answer'] ?? ''),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            Session::flash('success', 'Knowledge entry updated.');
            header('Location: ' . BASE_URL . '/admin/chatbotKnowledge'); exit;
        }
        $this->view('admin/knowledge-form', ['title' => 'Edit KB Entry — Admin', 'item' => $model->findById($id)]);
    }

    public function deleteKnowledge($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) { header('Location: ' . BASE_URL . '/admin/chatbotKnowledge'); exit; }
        $model = $this->model('ChatbotKnowledge');
        $model->delete($id);
        Session::flash('success', 'Knowledge entry deleted.');
        header('Location: ' . BASE_URL . '/admin/chatbotKnowledge'); exit;
    }

    // ===== MESSAGES =====
    public function messages() {
        $messageModel = $this->model('Message');
        $this->view('admin/messages', [
            'title' => 'Messages — Admin',
            'conversations' => $messageModel->getConversationList(),
        ]);
    }

    public function conversation($userId = null) {
        if (!$userId) { header('Location: ' . BASE_URL . '/admin/messages'); exit; }
        $messageModel = $this->model('Message');
        $messageModel->markAsRead(1, $userId);
        $userModel = $this->model('User');
        $this->view('admin/conversation', [
            'title' => 'Conversation — Admin',
            'customer' => $userModel->findById($userId),
            'messages' => $messageModel->getConversation($userId),
        ]);
    }

    public function replyMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . '/admin/messages'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/messages'); exit; }
        $receiverId = (int)($_POST['receiver_id'] ?? 0);
        $content = Validator::sanitize($_POST['content'] ?? '');
        if (empty($content) || !$receiverId) {
            Session::flash('error', 'Message cannot be empty.'); header('Location: ' . BASE_URL . '/admin/conversation/' . $receiverId); exit;
        }
        $messageModel = $this->model('Message');
        $messageModel->send(1, $receiverId, $content);
        Session::flash('success', 'Reply sent.');
        header('Location: ' . BASE_URL . '/admin/conversation/' . $receiverId); exit;
    }

    // ===== SETTINGS =====
    public function settings() {
        $settingModel = $this->model('Setting');
        $this->view('admin/settings', [
            'title' => 'Settings — Admin',
            'settings' => $settingModel->findAll(),
        ]);
    }

    public function updateSettings() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . '/admin/settings'); exit; }
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) { Session::flash('error', 'Invalid token.'); header('Location: ' . BASE_URL . '/admin/settings'); exit; }
        $settingModel = $this->model('Setting');
        foreach ($_POST as $key => $value) {
            if ($key !== 'csrf_token') {
                $settingModel->set(Validator::sanitize($key), Validator::sanitize($value));
            }
        }
        Session::flash('success', 'Settings updated.');
        header('Location: ' . BASE_URL . '/admin/settings'); exit;
    }
}
