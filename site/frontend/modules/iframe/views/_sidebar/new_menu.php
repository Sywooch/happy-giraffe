<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 */

use site\frontend\modules\iframe\models\QaQuestion;
use site\frontend\modules\iframe\models\QaCategory;
use site\frontend\modules\iframe\models\qaTag\Enum;
use site\frontend\modules\iframe\models\QaTag;

$question = QaQuestion::model()->category(QaCategory::PEDIATRICIAN_ID);
$tags = QaTag::model()->byCategory(QaCategory::PEDIATRICIAN_ID)->findAll();
$tagEnum = new Enum();
$currentTagId = \Yii::app()->request->getParam('tagId');
$tab = \Yii::app()->request->getParam('tab');
$tagsIdList = [
    Enum::LESS_THAN_YEAR_ID,
    Enum::MORE_THAN_YEAR_ID,
    Enum::PRESCHOOL_ID,
    Enum::SCHOOLKID_ID
];

?>

<div class="b-text--left">
    <span class="b-filter-dropdown__title">Возраст</span>
    <ul class="b-filter-year__list">
        <li class="b-filter-dropdown__item">
            <input type="radio" name="ages" class="material-theme-radio filled-in" id="filled-in-0"  <?=is_null($currentTagId) ? 'checked' : ''?>>
            <label class="b-filter-dropdown-iframe__label" for="filled-in-0" data-href="<?=$this->createUrl('/iframe/default/pediatrician', ['tab' => $tab])?>">
                <span class="text--grey">Любой</span>
            </label>
        </li>
        <?php foreach ($tags as $tag) {?>
            <li class="b-filter-dropdown__item">
                <input type="radio" name="ages" class="material-theme-radio filled-in" id="filled-in-<?=$tag->id?>" <?=$currentTagId == $tag->id ? 'checked' : ''?>>
                <label class="b-filter-dropdown-iframe__label" for="filled-in-<?=$tag->id?>" data-href="<?=$this->createUrl('/iframe/default/pediatrician', ['tab' => $tab, 'tagId' => $tag->id])?>">
                    <span class="text--grey"><?=$tagEnum->getTitleForWebMenu($tag->name)?></span>
                </label>
            </li>
        <?php }?>
    </ul>
</div>
<script>
    $(document).ready(function () {
        $('.b-filter-dropdown-iframe__label').on('click',function () {
            var url = $(this).attr('data-href');
            setTimeout(function() {
                location.href = url
            }, 100)
        })
    });
</script>