<?php

class Controller {
    // Load model
    public function model($model) {
        require_once ROOT_PATH . '/app/models/' . $model . '.php';
        return new $model();
    }

    // Load view
    public function view($view, $data = [], $layout = 'main') {
        $viewFile = ROOT_PATH . '/app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            extract($data);

            // Buffer the view content
            ob_start();
            require $viewFile;
            $viewContent = ob_get_clean();

            // Wrap in layout if it exists
            $layoutFile = ROOT_PATH . '/app/views/layouts/' . $layout . '.php';
            if ($layout && file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $viewContent;
            }
        } else {
            die("View does not exist: " . htmlspecialchars($view));
        }
    }
}
