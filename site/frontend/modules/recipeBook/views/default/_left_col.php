<div class="left-inner">

    <div class="add">
        <a class="btn-green_bl" href="<?php echo $this->createUrl('/recipeBook/default/edit') ?>">Добавить<br> рецепт</a>
    </div>

    <div class="themes">
        <div class="theme-pic_double">Инфекционные<br>заболевания</div>
        <ul class="leftlist">
            <?php foreach ($cat_diseases as $cat_disease): ?>
            <li><a <?php if ($cat_disease->id == $active_disease) echo 'class="current" ' ?>
                href="<?php echo $this->createUrl('/recipeBook/default/disease', array('url' => $cat_disease->slug)) ?>"><?php
                echo $cat_disease->name ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="leftbanner">
        <a href="/"><img src="/images/leftban.png"></a>
    </div>

</div>