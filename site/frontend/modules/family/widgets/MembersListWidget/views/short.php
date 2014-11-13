<?php
/**
 * @var site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget $this
 * @var site\frontend\modules\family\models\FamilyMemberAbstract[] $members
 */

?>

<ul class="family-about_ul">
    <?php foreach ($members as $member): ?>
        <li class="family-about_li">
            <div class="family-about_img-hold">
                <div class="ico-family-big ico-family-big__<?=$member->getViewData()->getCssClass()?>"></div>
            </div>
            <div class="family-about_member"><?=$this->isMe($member) ? 'Я' : $member->getViewData()->getAsString()?></div>
        </li>
    <?php endforeach; ?>
</ul>