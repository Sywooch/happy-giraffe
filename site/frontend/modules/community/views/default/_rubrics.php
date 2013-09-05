<?php
/**
 * @var CommunityRubric[] $rubrics
 */
?>
<div class="menu-simple">
    <ul class="menu-simple_ul">
        <?php foreach ($rubrics as $rubric): ?>
            <li class="menu-simple_li<?php if ($rubric->id == $this->rubric_id) echo ' active' ?>">
                <?= HHtml::link($rubric->title, $rubric->getUrl(), array('class' => 'menu-simple_a'), true) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>