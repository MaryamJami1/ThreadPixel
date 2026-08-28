<?php
class PortfolioController extends Controller {
    public function index() {
        $portfolioModel = $this->model('Portfolio');
        $categoryModel = $this->model('PortfolioCategory');
        $categoryFilter = isset($_GET['category']) ? (int)$_GET['category'] : null;

        $data = [
            'title' => 'Portfolio — ThreadPixel',
            'categories' => $categoryModel->findAll('id ASC'),
            'items' => $categoryFilter ? $portfolioModel->getByCategory($categoryFilter) : $portfolioModel->getAll(),
            'activeCategory' => $categoryFilter,
        ];
        $this->view('portfolio/index', $data);
    }

    public function show($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL . '/portfolio');
            exit;
        }
        $portfolioModel = $this->model('Portfolio');
        $item = $portfolioModel->findById($id);
        if (!$item) {
            $this->view('errors/404', ['title' => 'Not Found']);
            return;
        }
        $data = [
            'title' => $item->title . ' — ThreadPixel',
            'item' => $item,
        ];
        $this->view('portfolio/show', $data);
    }
}
