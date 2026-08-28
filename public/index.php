<?php
/**
 * ThreadPixel - Front Controller
 */

session_start();

// Define the root path using __DIR__ (always resolves correctly regardless of server)
define('ROOT_PATH', dirname(__DIR__));

// Load configuration
require_once ROOT_PATH . '/config/config.php';

// Load core classes
require_once ROOT_PATH . '/app/core/Database.php';
require_once ROOT_PATH . '/app/core/Model.php';
require_once ROOT_PATH . '/app/core/Controller.php';
require_once ROOT_PATH . '/app/core/Middleware.php';

// Load helpers
require_once ROOT_PATH . '/app/helpers/Session.php';
require_once ROOT_PATH . '/app/helpers/CSRF.php';
require_once ROOT_PATH . '/app/helpers/Validator.php';
require_once ROOT_PATH . '/app/helpers/FileUpload.php';

// Initialize the application router
require_once ROOT_PATH . '/app/core/App.php';
$app = new App();
