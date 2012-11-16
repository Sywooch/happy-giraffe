<div class="btn-cooks-container">

    <a href="" class="btn-cooks" onclick="$(this).next().toggle();return false;"></a>
    <ul style="display: none;">
        <?php
        foreach ($authors as $author): ?>
            <li><a href="" onclick="CookModule.addTask(this, <?php echo $author->id ?>, <?=$this->section ?>);$(this).parents('ul').hide();return false;"><?=$author->name ?></a>
                <span class="count"><?=$author->getTasksCount() ?></span></li>
        <?php endforeach; ?>
    </ul>
</div>