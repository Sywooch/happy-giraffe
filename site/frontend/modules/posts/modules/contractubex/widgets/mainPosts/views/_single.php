<li class="club-advices_list_item">
    <?php if ($this->photo): ?>
    <div class="club-advices_list_item_img"><img src="<?=Yii::app()->thumbs->getThumb($this->getPhoto(), 'contra1')?>"></div>
    <?php endif; ?>
    <div class="club-advices_list_item_cont">
        <div class="live-user">
            <a href="<?=$this->model->user->profileUrl?>" class="ava ava ava__<?=($this->model->user->gender) ? 'male' : 'female'?>">
                <?php if ($this->model->user->avatarUrl): ?>
                    <img alt="" src="<?=$this->model->user->avatarUrl?>" class="ava_img">
                <?php endif; ?>
            </a>
            <div class="username">
                <a href="<?=$this->model->user->profileUrl?>"><?=$this->model->user->fullName?></a>
                <?=HHtml::timeTag($this->model, array('class' => 'tx-date'))?>
            </div>
        </div>
        <a class="club-advices_list_item_heading" href="<?=$this->model->url?>"><?=$this->model->title?></a>
        <div class="club-advices_list_item_dynamic clearfix">
            <div class="club-advices_list_item_dynamic_visitors clearfix">
                <div class="club-advices_list_item_dynamic_visitors_img"></div><span><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($this->model->url)?></span>
            </div>
            <div class="club-advices_list_item_dynamic_comments clearfix">
                <div class="club-advices_list_item_dynamic_comments_img"></div><span><?=$this->commentsCount?></span>
            </div>
            <?php if (count($this->commentators) > 0): ?>
            <ul class="dynamic_users clearfix">
                <?php foreach ($this->commentators as $commentator): ?>
                <li class="dynamic_users_item">
                    <a href="<?=$commentator->url?>" class="ava ava__small ava__female">
                        <img alt="" src="<?=$commentator->avatarUrl?>" class="ava_img">
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</li>