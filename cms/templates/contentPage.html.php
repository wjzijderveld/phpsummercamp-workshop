
<h1><?php echo $title; ?></h1>

<p><?php echo $content; ?></p>

<?php foreach ($node->getNodes() as $child): ?>
    <?php if ($child->isNodeType('nt:file')): ?>
        <img src="<?php echo substr($child->getPath(), 4); ?>" title="" />
    <?php endif; ?>
<?php endforeach; ?>

<?php if (count($versions)): ?>
<form method="GET" action="">
    <select name="version" onchange="this.form.submit();">
    <?php foreach ($versions as $version): ?>
    <option value="<?php echo $version->getName(); ?>"<?php if ($version->getName() == $shownVersion): ?> selected<?php endif; ?>>
        <?php echo $version->getName() . ' - ' . $version->getCreated()->format('Y-m-d H:i:s'); ?>
        </option>
    <?php endforeach; ?>
    </select>
</form>
<?php endif; ?>
