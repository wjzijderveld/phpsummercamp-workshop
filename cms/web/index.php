<?php

require __DIR__ . '/../bootstrap.php';

$rootNode = $session->getRootNode();

$cmsNode = $rootNode->getNode('cms');

function sendResponse($content, $status = '200 OK') 
{
    header('HTTP/1.1 ' . $status);
    echo $content;
    exit;
}

$path = ltrim($_SERVER['REQUEST_URI'], '/');

if ('' === $path) {
    $path = 'homepage';
}

if ($cmsNode->hasNode($path)) {
    $currentNode = $cmsNode->getNode($path);

    if (! $currentNode->isNodeType('nt:file')) {
        $response = '<h1>' . $currentNode->getPropertyValue('title') . '</h1>';
        $response .= '<p>' . $currentNode->getPropertyValue('content') . '</h1>';
        sendResponse($response);
    } else {
        sendResponse('The requested document can not me served', '501 Not Implemented');
    }

} else {
    sendResponse('<h1>Not found</h1>', '404 Not Found');
}
