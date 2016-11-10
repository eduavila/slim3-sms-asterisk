<?php


# === Para mostrar todos erros
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors','On');

setlocale(LC_ALL, 'pt_BR');

# === Session
session_cache_limiter(false);
@session_start();


// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';


// Instantiate the app
$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);

# === config
# ==================================================
require __DIR__ .'/../app/Config/database.php';

# === helpers
# ==================================================
require __DIR__ . '/../app/Helpers/appHelpers.php';

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
require __DIR__ . '/../app/middleware.php';

// Register routes
require __DIR__ . '/../app/routes.php';

// Inicia Applicação
$app->run();