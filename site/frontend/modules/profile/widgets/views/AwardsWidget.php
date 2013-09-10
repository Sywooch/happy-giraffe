<?php
/**
 * @var AwardsWidget $this
 */
$url = $this->isMyProfile ? Yii::app()->createUrl('/scores/default/index') : Yii::app()->createUrl('/profile/default/awards', array('user_id'=>$this->user->id));
?><div class="user-awards">
    <div class="clearfix">
        <a href="<?=$url ?>"><span class="ico-cup-small"></span></a> &nbsp;
        <a href="<?=$url ?>" class="heading-small"><?=$this->isMyProfile?'Мои успехи':'Мои награды'?></a>
    </div>
    <ul class="user-awards_ul clearfix">
        <?php foreach ($this->awards as $award): ?>
            <li class="user-awards_li">
                <a href="<?=$this->isMyProfile?$url:$award->getUrl() ?>" class="user-awards_a">
                    <img src="<?=$award->getAward()->getIconUrl(46) ?>" alt="<?=$award->getAward()->title ?>" class="user-awards_img">
                    <span class="user-awards_overlay"></span>
                </a>
                <div class="user-awards_popup user-awards_popup__2" style="display: none;">
                    <div class="user-awards_popup-tale"></div>
                    <div class="user-awards_popup-img">
                        <img src="<?=$award->getAward()->getIconUrl(84) ?>" alt="<?=$award->getAward()->title ?>">
                    </div>
                    <div class="user-awards_popup-desc">
                        <div class="clearfix"><?=$award->getAward()->title ?></div>
                        <div class="font-smallest">Получен <?=Yii::app()->dateFormatter->format('d MMM yyyy',strtotime($award->created)) ?></div>
                        <div class="user-awards_popup-count">+ <?=$award->getAward()->scores ?> баллов</div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script type="text/javascript">
    $(function() {
        $('.user-awards_li').bind({
            mouseover: function(){
                $(this).find('.user-awards_popup').stop(true, true).delay(200).fadeIn(200);
            },
            mouseout: function(){
                $('.user-awards_ul .user-awards_popup').stop(true, true).delay(100).fadeOut(100);

            }
        });
    });
</script>
