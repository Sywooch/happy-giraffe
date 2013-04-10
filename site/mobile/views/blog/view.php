<?php $this->renderPartial('_post', array('data' => $content, 'full' => true)); ?>

<?php if (! empty($next)): ?>
    <div class="margin-10 textalign-c clearfix">
        <a href="<?=$next[0]->url?>" class="btn-green btn-medium">Следующая <i class="ico-arrow ico-arrow__right"></i></a>
    </div>

    <div class="interesting">
        <div class="interesting_t">Еще интересно</div>
        <ul>
            <?php foreach ($next as $n): ?>
                <li class="interesting_i"><?=CHtml::link($n->title, $n->url)?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>