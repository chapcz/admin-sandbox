<?php

require __DIR__ . '/../vendor/autoload.php';
umask(0);
$configurator = new Nette\Configurator;

$configurator->setDebugMode(['172.18.0.1']);
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->addConfig(__DIR__ . '/config/config.neon');
if (file_exists(__DIR__ . '/config/config.override.neon')) {
    $configurator->addConfig(__DIR__ . '/config/config.override.neon');
}

return $configurator->createContainer();
