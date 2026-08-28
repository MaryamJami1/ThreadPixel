<?php
class FaqController extends Controller {
    public function index() {
        $faqModel = $this->model('FAQ');
        $data = [
            'title' => 'FAQ — ThreadPixel',
            'grouped' => $faqModel->getGroupedByCategory(),
        ];
        $this->view('faq/index', $data);
    }
}
