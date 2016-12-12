<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 */

use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\qaTag\Enum;
use site\frontend\modules\som\modules\qa\models\QaTag;


$questions = QaQuestion::model()->category(QaCategory::PEDIATRICIAN_ID)->getList();
$tags = QaTag::model()->byCategory(QaCategory::PEDIATRICIAN_ID)->findAll();
$tagEnum = new Enum();
?>

 <div class="b-text--left b-margin--bottom_40">
    <div class="b-filter-year">
        <ul class="b-filter-year__list">
        	<?php foreach ($tags as $tag) {?>
            	<li class="b-filter-year__li">
            		<a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tab' => 'new', 'tagId' => $tag->id])?>" class="b-filter-year__link">
            			<?=$tagEnum->getTitleForWebMenu($tag->name)?>
            			<span><?=$questions->sortedByField('tag_id', $tag->id)->getCount()?></span>
        			</a>
    			</li>
            <?php }?>
        </ul>
    </div>
</div>
