<div class="contest-list_item clearfix">
    <div class="contest-list_banner">
        <?=CHtml::link(CHtml::image('/images/contest/banner-w280-' . $data->id . '.jpg', $data->title), $data->url)?>
    </div>
    <div class="contest-list_holder">
        <div class="content-title"><?=CHtml::link($data->title, $data->url)?></div>
        <?=$data->text?>
        <div class="contest-list_row">
            <div class="date<?php if($data->status > Contest::STATUS_ACTIVE): ?> red<?php endif; ?>"><?=$data->from?>-<?=$data->to?> <span class="year"><?=$data->year?></span></div>
            <?php if ($data->status > Contest::STATUS_ACTIVE): ?>
                <div class="complet">Завершен</div>
            <?php endif; ?>
            <?php if ($data->status == Contest::STATUS_ACTIVE): ?>
                <a href="<?=$data->url?>" class="btn-green btn-h46">Принять участие!</a>
            <?php elseif ($data->status == Contest::STATUS_FINISHED): ?>
                <div class="result"><i class="glass"></i>Идет работа жюри</div>
            <?php elseif ($data->status == Contest::STATUS_RESULTS): ?>
                <div class="result"><i class="win"></i><?=CHtml::link('Победители', array('/contest/default/results', 'id' => $data->id))?></div>
            <?php endif; ?>
        </div>
    </div>
</div>