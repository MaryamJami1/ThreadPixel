<?php
class PricingController extends Controller {
    public function index() {
        $serviceModel = $this->model('Service');
        $data = [
            'title' => 'Pricing — ThreadPixel',
            'services' => $serviceModel->getActive(),
        ];
        $this->view('pricing/index', $data);
    }
}
