<div class="handbook_multi">
    <?php foreach ($categoryList as $category => $diseases): ?>
    <ul class="handbook_list">
        <li><span><?php echo $category ?></span></li>
        <?php foreach ($diseases as $disease): ?>
        <li><a
            href="<?php echo $this->createUrl('view', array('url' => $disease->slug)) ?>"><?php
            echo $disease->title ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php endforeach; ?>
</div>