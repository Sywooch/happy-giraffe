<?php
/**
 * @var site\frontend\modules\comments\modules\contest\controllers\DefaultController $this
 * @var string $content
 */
?>

<?php $this->beginContent('//layouts/lite/common'); ?>
<div class="contest"><a href="#" class="i-giraffe-back"></a>
    <div class="contest-commentator">
        <!-- Шапка-->
        <div class="contest-commentator-header">
            <div class="contest-commentator-header_date">Сроки проведения:  с 20 февраля по 31 марта</div>
            <h1 class="contest-commentator-header_t">Лучший комментатор</h1>
            <ul class="contest-commentator-header_ul">
                <li class="contest-commentator-header_li">
                    <a href="<?=$this->createUrl('/comments/contest/default/rules', array('contestId' => $this->contest->id))?>" class="btn btn-xxl btn-link">Правила</a>
                </li>
                <li class="contest-commentator-header_li">
                    <a href="<?=$this->createUrl('/comments/contest/default/index', array('contestId' => $this->contest->id))?>" class="btn btn-xxl btn-link">О конкурсе</a>
                </li>
                <li class="contest-commentator-header_li">
                    <a href="<?=$this->createUrl('/comments/contest/default/rating', array('contestId' => $this->contest->id))?>" class="btn btn-xxl btn-link">Лидеры</a>
                </li>
                <li class="contest-commentator-header_li">
                    <a href="<?=$this->createUrl('/comments/contest/default/my', array('contestId' => $this->contest->id))?>" class="btn btn-xxl btn-link">Моя лента</a>
                </li>
            </ul>
        </div>
        <!-- Шапка-->
        <?=$content?>
    </div>
    <?php $this->renderPartial('//_footer'); ?>
</div>
<?php $this->endContent(); ?>