<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// On charge les fichiers de __DIR__ . '/../resources/config' dans l'ordre croissant
foreach (new DirectoryIterator(__DIR__ . '/../resources/config') as $fileInfo) { if($fileInfo->isDot()) continue; if($fileInfo->getExtension() != 'php') continue; $require_list[] = $fileInfo->getPathname(); }
sort($require_list, SORT_STRING);
foreach($require_list as $file) require_once $file;

$app['debug'] = TRUE;

$app['http_cache']->run();
