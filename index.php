<?php
declare(strict_types=1);
require __DIR__ . "/vendor/autoload.php";

ini_set('display_errors','1');
ini_set("display_startup_errors","1");
error_reporting(E_ALL);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
header('Location: ' . $uri . '/src/sites/');
exit;
?>
Something is wrong with the XAMPP installation :-(

