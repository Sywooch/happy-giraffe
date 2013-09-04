<?php
/**
 * @var CommunityRubric[] $rubrics
 */
?><div class="menu-simple">
    <ul class="menu-simple_ul">
        <?php foreach ($rubrics as $rubric): ?>
            <li class="menu-simple_li<?php if ($rubric->id == $this->rubric_id) echo ' active' ?>">
                <a class="menu-simple_a" href="<?= $rubric->getUrl() ?>"><?= $rubric->title ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>