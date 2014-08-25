<?php

require __DIR__ . '/vendor/autoload.php';

define('CURRENT_PART', 'part2');

ini_set('display_errors', 1);
error_reporting(E_ALL);

// bootstrap jackrabbit
$factory = new \Jackalope\RepositoryFactoryJackrabbit;

$repository = $factory->getRepository(array('jackalope.jackrabbit_uri' => 'http://localhost:8080/server'));
$credentials = new \PHPCR\SimpleCredentials('admin', 'admin');
$session = $repository->login($credentials, CURRENT_PART);

