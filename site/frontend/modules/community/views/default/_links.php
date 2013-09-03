<?php if (count($this->club->communities) == 1):?>
    <li class="b-section_li">
        <a href="<?=$this->createUrl('/community/default/forum', array('forum_id'=>$this->club->communities[0]->id)) ?>"
           class="b-section_li-a<?php if (isset($this->forum) && $this->forum !== null) echo ' active' ?>">Форум</a>
    </li>
<?php else: ?>
    <?php foreach ($this->club->communities as $community): ?>
        <li class="b-section_li">
            <a href="<?=$this->createUrl('/community/default/forum', array('forum_id'=>$community->id)) ?>"
               class="b-section_li-a<?php if (isset($this->forum) && $this->forum !== null && $this->forum->id == $community->id) echo ' active' ?>"><?=$community->title ?></a>
        </li>
    <?php endforeach; ?>
<?php endif ?>


<?php if (count($this->club->services) < 2):?>
    <?php foreach($this->club->services as $service):?>
        <li class="b-section_li">
            <a href="<?=$service->getUrl() ?>" class="b-section_li-a<?php if (isset($service_id) && $service_id = $service->id) echo ' active' ?>"><?=$service->title ?></a>
        </li>
    <?php endforeach ?>
<?php else: ?>
    <li class="b-section_li">
        <a href="<?=$this->createUrl('/community/default/services', array('club_id'=>$this->club->id)) ?>" class="b-section_li-a<?php if (Yii::app()->controller->action->id == 'services' ) echo ' active' ?>">Сервисы</a>
    </li>
<?php endif ?>

<?php if ($this->club->id == 7): ?>
    <li class="b-section_li">
        <a href="<?=$this->createUrl('/cook/recipe/index', array('section' => 0))?>" class="b-section_li-a<?php if (Yii::app()->controller->id == 'recipe' && $this->section == 0) echo ' active' ?>">Рецепты</a>
    </li>
    <li class="b-section_li">
        <a href="<?=$this->createUrl('/cook/recipe/index', array('section' => 1))?>" class="b-section_li-a<?php if (Yii::app()->controller->id == 'recipe' && $this->section == 1) echo ' active' ?>">Для мультиварки</a>
    </li>
<?php endif; ?>