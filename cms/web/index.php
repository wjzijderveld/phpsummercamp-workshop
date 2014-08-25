<?php

require __DIR__ . '/../bootstrap.php';

$rootNode   = $session->getRootNode();
$cmsNode    = $rootNode->getNode('cms');
$routesNode = $rootNode->getNode('routes');
$menuNode   = $rootNode->getNode('menu/main');

$versionManager = $session->getWorkspace()->getVersionManager();

function sendResponse($content, $status = '200 OK')
{
    header('HTTP/1.1 ' . $status);
    echo $content;
    exit;
}

function render($template, array $variables)
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

function renderMenu(Jackalope\Node $menuNode)
{
    return render('menu.html.php', array('nodes' => $menuNode));
}

function renderContentNode(Jackalope\Node $node)
{
    global $versionManager;

    $baseNode = $node;
    if (isset($_GET['version']) && $baseNode->isNodeType('mix:versionable')) {
        $node = $versionManager->getVersionHistory($baseNode->getPath())->getVersion($_GET['version'])->getFrozenNode();
    }

    $variables = $node->getPropertiesValues();
    $variables['node'] = $node;
    $variables['versions'] = getVersions($baseNode);
    $variables['baseVersion'] = getBaseVersion($baseNode);
    $variables['shownVersion'] = null;
    if (isset($_GET['version'])) {
        $variables['shownVersion'] = $_GET['version'];
    } elseif ($variables['baseVersion']) {
        $variables['shownVersion'] = $variables['baseVersion']->getName();
    }

    return render('contentPage.html.php', $variables);
}

function getVersions(Jackalope\Node $node)
{
    global $versionManager;

    if (! $node->isNodeType('mix:versionable')) {
        return array();
    }

    return $versionManager->getVersionHistory($node->getPath())->getAllVersions();
}

function getBaseVersion(Jackalope\Node $node)
{
    global $versionManager;

    if (! $node->isNodeType('mix:versionable')) {
        return;
    }

    return $versionManager->getBaseVersion($node->getPath());
}

function handleNode(Jackalope\Node $node, $menuNode)
{
    if ($node->isNodeType('mix:simple_page')) {
        sendResponse(renderMenu($menuNode) . renderContentNode($node));
    } elseif ($node->isNodeType('nt:file')) {
        $resource = $node->getNode('jcr:content');
        header('Content-Type: ' . $resource->getPropertyValue('jcr:mimeType'));
        sendResponse($resource->getProperty('jcr:data')->getString());
    } else {
        sendResponse('The requested document can not me served', '501 Not Implemented');
    }
}

$path = ltrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ('' === $path) {
    $path = 'homepage';
}

if ($cmsNode->hasNode($path)) {
    $currentNode = $cmsNode->getNode($path);

    handleNode($currentNode, $menuNode);

} else {
    if ($routesNode->hasNode($path)) {
        $route = $routesNode->getNode($path);
        handleNode($route->getPropertyValue('node'), $menuNode);
    } else {
        sendResponse('<h1>Not found</h1>', '404 Not Found');
    }
}
