<?php if (!in_array($this->club->id, array(7))):?>
    <?php if (count($this->club->communities) > 1):?>
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
<?php else: ?>
    <?php $this->renderPartial('application.modules.community.views.default.club_specific._links_' . $this->club->id); ?>
<?php endif ?>