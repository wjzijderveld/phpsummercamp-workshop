<?php if ($nodes->hasNodes()): ?>
    <ul>
    <?php foreach ($nodes as $menuNode): ?>
        <li>
            <a href="<?php echo $menuNode->getPropertyValue('path'); ?>"><?php echo $menuNode->getPropertyValue('label'); ?></a>
            <?php echo renderMenu($menuNode); ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
