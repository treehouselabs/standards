<?php

$file = __DIR__.'/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

/**
 * @var \Composer\Autoload\ClassLoader $loader
 */
$loader = require $file;
$loader->addPsr4('TreeHouse\\Standards\\Tests\\', __DIR__ . '/TreeHouse/Standards/Tests/');
