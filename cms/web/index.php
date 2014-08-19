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

function render($template, array $variables = array())
{
    $templatePath = __DIR__ . '/../templates';

    if (!file_exists($templatePath . '/' . $template)) {
        throw new \RuntimeException(sprintf('Template "%s" not found', $template));
    }

    // It does make this pretty easy...
    extract($variables);

    ob_start();
    require $templatePath . '/' . $template;
    return ob_get_clean();
}

$path = ltrim($_SERVER['REQUEST_URI'], '/');

if ('' === $path) {
    $path = 'homepage';
}

if ($cmsNode->hasNode($path)) {
    $currentNode = $cmsNode->getNode($path);

    if ($currentNode->isNodeType('mix:simple_page')) {
        sendResponse(render('contentPage.html.php', $currentNode->getPropertiesValues()));
    } if ($currentNode->isNodeType('nt:file')) {
        $resource = $currentNode->getNode('jcr:content');
        header('Content-Type: ' . $resource->getPropertyValue('jcr:mimeType'));
        sendResponse($resource->getProperty('jcr:data')->getString());
    } else {
        sendResponse('The requested document can not me served', '501 Not Implemented');
    }

} else {
    sendResponse('<h1>Not found</h1>', '404 Not Found');
}
