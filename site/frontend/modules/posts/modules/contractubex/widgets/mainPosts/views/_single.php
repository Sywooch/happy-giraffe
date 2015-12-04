<li class="club-advices_list_item">
    <?php if ($this->photo): ?>
    <div class="club-advices_list_item_img"><img src="<?=Yii::app()->thumbs->getThumb($this->getPhoto(), 'contra1')?>"></div>
    <?php endif; ?>
    <div class="club-advices_list_item_cont">
        <div class="live-user">
            <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
            <div class="username"><a>Контратубекс</a><span class="tx-date">минуту назад</span></div>
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