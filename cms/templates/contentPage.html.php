
<h1><?php echo $title; ?></h1>

<p><?php echo $content; ?></p>

<?php foreach ($node->getNodes() as $child): ?>
    <?php if ($child->isNodeType('nt:file')): ?>
        <img src="<?php echo substr($child->getPath(), 4); ?>" title="" />
    <?php endif; ?>
<?php endforeach; ?>
