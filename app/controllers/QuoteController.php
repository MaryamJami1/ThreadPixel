<?php
class QuoteController extends Controller {

    public function index() {
        $serviceModel = $this->model('Service');
        $data = [
            'title' => 'Get a Quote — ThreadPixel',
            'services' => $serviceModel->getActive(),
        ];
        $this->view('quote/index', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/quote');
            exit;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid security token. Please try again.');
            header('Location: ' . BASE_URL . '/quote');
            exit;
        }

        // Validate
        $name = Validator::sanitize($_POST['name'] ?? '');
        $businessName = Validator::sanitize($_POST['business_name'] ?? '');
        $email = Validator::sanitize($_POST['email'] ?? '');
        $country = Validator::sanitize($_POST['country'] ?? '');
        $serviceId = (int)($_POST['service_id'] ?? 0);
        $designSize = Validator::sanitize($_POST['design_size'] ?? '');
        $garmentType = Validator::sanitize($_POST['garment_type'] ?? '');
        $machineFormat = Validator::sanitize($_POST['machine_format'] ?? '');
        $quantity = (int)($_POST['quantity'] ?? 1);
        $requiredDate = $_POST['required_date'] ?? null;
        $isRush = isset($_POST['is_rush']) ? 1 : 0;
        $instructions = Validator::sanitize($_POST['additional_instructions'] ?? '');

        $validator = new Validator();
        $validator->required('name', $name, 'Full Name')
                  ->required('email', $email, 'Email')
                  ->email('email', $email)
                  ->required('service_id', $serviceId, 'Service Type');

        if ($validator->hasErrors()) {
            Session::flash('error', $validator->firstError());
            header('Location: ' . BASE_URL . '/quote');
            exit;
        }

        // Get or create user
        $userModel = $this->model('User');
        $existingUser = $userModel->findByEmail($email);

        if (Session::isLoggedIn()) {
            $userId = Session::userId();
        } elseif ($existingUser) {
            $userId = $existingUser->id;
        } else {
            // Create guest account
            $tempPassword = bin2hex(random_bytes(8));
            $userId = $userModel->register([
                'name' => $name,
                'email' => $email,
                'password' => $tempPassword,
                'business_name' => $businessName,
                'country' => $country,
                'role' => 'customer',
            ]);
        }

        // Create quote
        $quoteModel = $this->model('Quote');
        $quoteNumber = $quoteModel->generateQuoteNumber();

        $quoteId = $quoteModel->create([
            'quote_number' => $quoteNumber,
            'user_id' => $userId,
            'service_id' => $serviceId ?: null,
            'design_size' => $designSize,
            'garment_type' => $garmentType,
            'machine_format' => $machineFormat,
            'quantity' => $quantity,
            'required_date' => $requiredDate ?: null,
            'is_rush' => $isRush,
            'additional_instructions' => $instructions,
            'status' => 'Pending',
        ]);

        // Handle file uploads
        if (isset($_FILES['artwork']) && $_FILES['artwork']['error'][0] !== UPLOAD_ERR_NO_FILE) {
            $uploader = new FileUpload('artwork');
            $quoteFileModel = $this->model('QuoteFile');
            $results = $uploader->uploadMultiple($_FILES['artwork'], 'quotes');
            foreach ($results as $result) {
                if ($result['success']) {
                    $quoteFileModel->create([
                        'quote_id' => $quoteId,
                        'file_path' => $result['file_path'],
                        'file_name' => $result['file_name'],
                    ]);
                }
            }
        }

        Session::flash('success', 'Your quote request has been received. Quote #' . $quoteNumber);
        Session::set('last_quote_number', $quoteNumber);
        header('Location: ' . BASE_URL . '/quote/thankYou');
        exit;
    }

    public function thankYou() {
        $quoteNumber = Session::get('last_quote_number', '');
        $data = [
            'title' => 'Quote Submitted — ThreadPixel',
            'quoteNumber' => $quoteNumber,
        ];
        $this->view('quote/thankyou', $data);
    }
}
