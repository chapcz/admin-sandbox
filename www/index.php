<?php

use Nette\Application\Application;
const WWW_DIR = __DIR__;
const APP_TEMP_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp';

$container = require __DIR__ . '/../app/bootstrap.php';
$container->getByType(Application::class)->run();
