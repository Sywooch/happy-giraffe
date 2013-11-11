<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 * @var bool $showTitle
 */
?>

<?php if ($full):?>

    <h1 class="b-article_t"><?=$data->title?></h1>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <?=$data->question->text?>
        </div>
    </div>

<?php else: ?>

    <div class="b-article_t">
        <a href="<?=$data->getUrl()?>" class="b-article_t-a"><?=$data->title?></a>
    </div>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <?=Str::truncate($data->question->text, 100)?>
        </div>
    </div>

    <div class="textalign-r">
        <a class="b-article_more b-article_more__white" href="<?=$data->getUrl()?>">Смотреть далее</a>
    </div>

<?php endif; ?>