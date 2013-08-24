<?php
/**
 * @var AwardsWidget $this
 */
?><div class="user-awards">
    <div class="clearfix">
        <span class="ico-cup-small"></span> &nbsp;
        <a href="<?=Yii::app()->createUrl('/profile/default/awards', array('user_id'=>$this->user->id)) ?>" class="heading-small">Мои <?=($this->isMyProfile) ? 'успехи' : 'награды'; ?></a>
    </div>
    <ul class="user-awards_ul clearfix">
        <?php foreach ($this->awards as $award): ?>
            <li class="user-awards_li">
                <a href="<?=$award->getUrl() ?>" class="user-awards_a">
                    <img src="<?=$award->getAward()->getIconUrl(46) ?>" alt="<?=$award->getAward()->title ?>" class="user-awards_img">
                    <span class="user-awards_overlay"></span>
                </a>
                <div class="user-awards_popup user-awards_popup__2">
                    <div class="user-awards_popup-tale"></div>
                    <div class="user-awards_popup-img">
                        <img src="<?=$award->getAward()->getIconUrl(84) ?>" alt="<?=$award->getAward()->title ?>">
                    </div>
                    <div class="user-awards_popup-desc">
                        <div class="clearfix"><?=$award->getAward()->title ?></div>
                        <div class="font-smallest">Получен <?=Yii::app()->dateFormatter->format('d MMM yyyy',strtotime($award->created)) ?></div>
                        <div class="user-awards_popup-count">+ <?=$award->getAward()->scores ?> баллов</div>
                        <a href="" class="user-awards_popup-more">Как получить трофеи</a>
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
                $(this).find('.user-awards_popup').stop(true, true).fadeIn(200);
            },
            mouseout: function(){
                $(this).find('.user-awards_popup').stop(true, true).delay(200).fadeOut(200);

            }
        });
    });
</script>
