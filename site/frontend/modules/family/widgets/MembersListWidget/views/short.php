<?php
/**
 * @var site\frontend\modules\family\models\FamilyMember[] $members
 */
?>

<ul class="family-about_ul">
    <?php foreach ($members as $member): ?>
        <?php $this->widget('site\frontend\modules\family\widgets\FamilyMemberWidget\FamilyMemberWidget', array(
            'model' => $member,
            'view' => 'li',
        )); ?>
    <?php endforeach; ?>
</ul>