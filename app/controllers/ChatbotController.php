<?php
class ChatbotController extends Controller {
    public function respond() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['response' => 'Invalid request.']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $message = trim($input['message'] ?? '');

        if (empty($message)) {
            echo json_encode([
                'response' => "Hi! I'm the ThreadPixel Assistant 🧵\nHow can I help with your embroidery project today?",
                'buttons' => ['Get a Quote', 'View Services', 'Pricing', 'File Formats', 'Turnaround Time', 'Talk to a Human']
            ]);
            exit;
        }

        $serviceModel = $this->model('Service');
        $activeServices = $serviceModel->getActive();
        $serviceLines = [];
        foreach ($activeServices as $service) {
            $serviceLines[] = $service->name . ' (from $' . number_format($service->starting_price, 2) . ')';
        }
        $serviceSummary = implode(', ', $serviceLines);

        // Quick button responses
        $quickResponses = [
            'get a quote' => ['response' => "You can submit a quote request with your artwork and requirements. We'll review it and get back to you with pricing.", 'link' => BASE_URL . '/quote', 'linkText' => 'Go to Quote Form'],
            'view services' => ['response' => "Our current services are: {$serviceSummary}. We can also discuss custom digitizing requirements.", 'link' => BASE_URL . '/services', 'linkText' => 'View All Services'],
            'pricing' => ['response' => "Current services and starting prices are: {$serviceSummary}. Final pricing depends on complexity, stitch count, size, and turnaround.", 'link' => BASE_URL . '/pricing', 'linkText' => 'View Pricing'],
            'file formats' => ['response' => "We provide embroidery files in DST, PES, EXP, JEF, VP3, and other common machine formats. Let us know which format you need when requesting a quote."],
            'turnaround time' => ['response' => "Standard turnaround is typically 12-24 hours. Rush orders may be available for eligible designs. Turnaround depends on design complexity."],
            'talk to a human' => ['response' => "I'd be happy to connect you with the ThreadPixel team.", 'link' => BASE_URL . '/contact', 'linkText' => 'Contact Support'],
        ];

        $lowerMsg = strtolower($message);
        if (isset($quickResponses[$lowerMsg])) {
            echo json_encode($quickResponses[$lowerMsg]);
            exit;
        }

        if (preg_match('/\b(services?|offer|provide|do you do)\b/', $lowerMsg)) {
            echo json_encode([
                'response' => "We currently offer: {$serviceSummary}. If your project is not listed, send us the artwork and requirements and we can review a custom request.",
                'link' => BASE_URL . '/services',
                'linkText' => 'Explore Services'
            ]);
            exit;
        }

        if (preg_match('/\b(price|pricing|cost|costs|how much|budget|rate|rates)\b/', $lowerMsg)) {
            echo json_encode([
                'response' => "Starting prices are: {$serviceSummary}. Your exact quote depends on the artwork, size, stitch count, garment, and deadline. Upload the design for an accurate review.",
                'link' => BASE_URL . '/quote',
                'linkText' => 'Request a Quote'
            ]);
            exit;
        }

        // Search knowledge base
        $kbModel = $this->model('ChatbotKnowledge');
        $result = $kbModel->search($message);

        if ($result) {
            echo json_encode(['response' => $result->answer]);
        } else {
            echo json_encode([
                'response' => "I don't want to give you incorrect information. Let me connect you with the ThreadPixel team for a detailed answer.",
                'link' => BASE_URL . '/contact',
                'linkText' => 'Contact Support'
            ]);
        }
        exit;
    }
}
