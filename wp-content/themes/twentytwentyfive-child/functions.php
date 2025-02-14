<?php


require_once __DIR__ . '/autoloader.php';

try {
    KKF\App::getInstance()->initialize();
} catch (\Exception $e) {
    error_log($e->getMessage());
}