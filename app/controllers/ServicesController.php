<?php
class ServicesController extends Controller {
    public function index() {
        $serviceModel = $this->model('Service');
        $data = [
            'title' => 'Services — ThreadPixel',
            'services' => $serviceModel->getActive(),
        ];
        $this->view('services/index', $data);
    }

    public function show($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL . '/services');
            exit;
        }
        $serviceModel = $this->model('Service');
        $service = $serviceModel->findById($id);
        if (!$service) {
            $this->view('errors/404', ['title' => 'Not Found']);
            return;
        }
        $data = [
            'title' => $service->name . ' — ThreadPixel',
            'service' => $service,
        ];
        $this->view('services/show', $data);
    }
}
