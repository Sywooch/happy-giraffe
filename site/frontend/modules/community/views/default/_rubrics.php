<?php
/**
 * @var CommunityRubric[] $rubrics
 */
?>
<div class="menu-simple">
    <ul class="menu-simple_ul">
        <?php foreach ($rubrics as $rubric): ?>
            <?php
            $active = false;
            if ($rubric->id == $this->rubric_id)
                $active = true;
            if (!$active)
                foreach ($rubric->childs as $child)
                    if ($child->id == $this->rubric_id)
                        $active = true;
            ?>
            <li class="menu-simple_li<?php if (!empty($rubric->childs)) echo ' menu-simple_li__with-drop'; if ($active) echo ' active';?>">
                <?= HHtml::link($rubric->title, $rubric->getUrl(), array('class' => 'menu-simple_a'), true) ?>
                <?php if (!empty($rubric->childs)):?>
                    <a href="javascript:;" class="menu-simple_a-drop" onclick="$(this).next().toggleClass('display-n');$(this).parent().toggleClass('active');"></a>
                    <ul class="menu-simple_ul<?php if (!empty($rubric->childs) && !$active) echo ' display-n'; ?>">
                        <?php foreach ($rubric->childs as $child): ?>
                            <li class="menu-simple_li<?php if ($child->id == $this->rubric_id) echo ' active' ?>">
                                <?= HHtml::link($child->title, $child->getUrl(), array('class' => 'menu-simple_a'), true) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>