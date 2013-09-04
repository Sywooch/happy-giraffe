<?php
/**
 * @var int $type
 * @var string $letter
 * @var string[] $letters
 * @var bool $showMenu
 * @var $cloud
 * @var $menu
 */
$rus = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','щ','ш','ь','ы','ъ','э','ю','я');
$eng = range('a', 'z');
$num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
?>

<div class="content-cols clearfix">
    <div class="col-1">
        <h2 class="col-1_t">Избранное</h2>

        <div class="menu-list menu-list__favorites">
            <a href="<?=$this->createUrl('default/index')?>" class="menu-list_i menu-list_i__all">
                <span class="menu-list_ico"></span>
                <span class="menu-list_tx">Все</span>
                <span class="menu-list_count"><?=FavouritesManager::getCountByUserId(Yii::app()->user->id)?></span>
            </a>
            <?php if ($showMenu): ?>
                <?php foreach ($menu as $row): ?>
                    <?php if ($row['count'] > 0): ?>
                        <a href="<?=$this->createUrl('default/index', array('entity' => $row['entity']))?>" class="menu-list_i menu-list_i__<?=$row['entity']?>">
                            <span class="menu-list_ico"></span>
                            <span class="menu-list_tx"><?=$row['title']?></span>
                            <span class="menu-list_count"><?=$row['count']?></span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="margin-15">
            <a href="<?=$this->createUrl('index', array('type' => TagsController::TYPE_POPULAR))?>" class="font-middle ">
                <span class="ico-tags margin-r15"></span>Все теги
            </a>
        </div>
    </div>

    <div class="col-23 clearfix">
        <div class="cont-nav margin-b25">
            <span class="ico-tags-big"></span>
            <span class="cont-nav_tx">Все теги</span>
            <div class="cont-nav_i<?php if ($type == TagsController::TYPE_BY_LETTER): ?> active<?php endif; ?>">
                <a class="cont-nav_a" href="<?=$this->createUrl('index', array('type' => TagsController::TYPE_BY_LETTER))?>">По алфавиту</a>
            </div>
            <div class="cont-nav_i<?php if ($type == TagsController::TYPE_POPULAR): ?> active<?php endif; ?>">
                <a class="cont-nav_a" href="<?=$this->createUrl('index', array('type' => TagsController::TYPE_POPULAR))?>">Популярные</a>
            </div>
        </div>

        <?php if ($type == TagsController::TYPE_BY_LETTER): ?>
        <div class="alphabet-b">
            <ul class="alphabet-b_ul">
                <?php foreach ($rus as $l): ?>
                <?php $this->renderPartial('_letter', array('letter' => $l, 'hasTags' => array_search($l, $letters) !== false, 'active' => $l == $letter)); ?>
                <?php endforeach; ?>
            </ul>
            <ul class="alphabet-b_ul">
                <?php foreach ($eng as $l): ?>
                    <?php $this->renderPartial('_letter', array('letter' => $l, 'hasTags' => array_search($l, $letters) !== false, 'active' => $l == $letter)); ?>
                <?php endforeach; ?>
            </ul>
            <ul class="alphabet-b_ul margin-l20">
                <?php foreach ($num as $l): ?>
                    <?php $this->renderPartial('_letter', array('letter' => $l, 'hasTags' => array_search($l, $letters) !== false, 'active' => $l == $letter)); ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="tagcloud">
            <?php
            $this->widget('application.extensions.YiiTagCloud.YiiTagCloud',
                array(
                    'containerTag' => 'ul',
                    'containerClass' => 'tagcloud_ul',
                    'beginColor' => '1b8acc',
                    'endColor' => '62bbff',
                    'minFontSize' => 12,
                    'maxFontSize' => 30,
                    'arrTags' => $cloud,
                )
            );
            ?>
        </div>
    </div>
</div>