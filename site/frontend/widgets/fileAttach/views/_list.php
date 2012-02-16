<ul>
    <?php foreach($attaches as $attach): ?>
        <li>
            <?php echo CHtml::link(CHtml::image($attach->photo->getPreviewUrl(100, 100)), $attach->photo->originalUrl, array('class' => 'fancy')); ?>
        </li>
    <?php endforeach; ?>
</ul>