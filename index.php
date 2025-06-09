<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

$router = new AltoRouter();

$router->map('GET', '/flights', function () {
    require __DIR__ . '/views/flights/all.php';
});
$router->map('GET|POST', '/flights/create', function () {
    require __DIR__ . '/views/flights/create.php';
});
$router->map('GET|POST', '/flights/edit', function () {
    require __DIR__ . '/views/flights/edit.php';
});
$router->map('GET', '/flights/delete', function () {
    require __DIR__ . '/views/flights/delete.php';
});

$match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo "404 - Not Found";
}
