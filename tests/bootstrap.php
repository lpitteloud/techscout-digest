<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpKernel\Kernel;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new Dotenv();

if (Kernel::VERSION_ID >= 40200) {
    $dotenv->bootEnv(dirname(__DIR__).'/.env');
} else {
    $dotenv->load(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}
