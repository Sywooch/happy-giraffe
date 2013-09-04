<li class="b-section_li">
    <a href="<?=$this->createUrl('/cook/recipe/index', array('section' => 0)) ?>"
       class="b-section_li-a<?php if (Yii::app()->controller->id  == 'recipe' && $this->section == 0) echo ' active' ?>">Рецепты</a>
</li>
<li class="b-section_li">
    <a href="<?=$this->createUrl('/community/default/forum', array('forum_id'=>23)) ?>"
       class="b-section_li-a<?php if (isset($this->forum) && $this->forum !== null && $this->forum->id == 23) echo ' active' ?>">Для детей</a>
</li>
<li class="b-section_li">
    <a href="<?=$this->createUrl('/cook/recipe/index', array('section' => 1)) ?>"
       class="b-section_li-a<?php if (Yii::app()->controller->id  == 'recipe' && $this->section == 1) echo ' active' ?>">Для мультиварки</a>
</li>
<li class="b-section_li">
    <a href="<?=$this->createUrl('/community/default/forum', array('forum_id'=>22)) ?>"
       class="b-section_li-a<?php if (isset($this->forum) && $this->forum !== null && $this->forum->id == 22) echo ' active' ?>">Форум</a>
</li>
<li class="b-section_li">
    <a href="<?=$this->createUrl('/community/default/services', array('club_id'=>$this->club->id)) ?>" class="b-section_li-a<?php if (Yii::app()->controller->action->id == 'services' ) echo ' active' ?>">Сервисы</a>
</li>