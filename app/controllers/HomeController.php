<?php
class HomeController extends Controller {
    public function index() {
        $serviceModel = $this->model('Service');
        $portfolioModel = $this->model('Portfolio');
        $testimonialModel = $this->model('Testimonial');

        $data = [
            'title' => 'ThreadPixel — From Pixels to Stitches',
            'services' => $serviceModel->getActive(),
            'portfolio' => $portfolioModel->getFeatured(),
            'testimonials' => $testimonialModel->getActive(),
        ];

        $this->view('home/index', $data);
    }
}
