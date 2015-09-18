<?php

// Doctrine (db)
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
  'db.options' => array(
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'dbname' => 'database',
    'user' => 'user',
    'password' => 'password',
    'charset' => 'utf8'
  )
));
