<div class="content-cols margin-t20 clearfix">
    <div class="col-1">
        <?php $this->renderPartial('menu'); ?>
    </div>
    <div class="col-12">
        <div class="valentine-sms">
            <div class="valentine-sms_hold">
                <div class="valentine-sms_t"></div>
                <p class="valentine-sms_p">В день святого Валентина принято обмениваться смс о любви и маленькими
                    подарками. Если вы еще не знаете, как поздравить с днем святого Валентина свою вторую половинку -
                    пришлите ей смс с признанием в любви.</p>
            </div>
            <?php foreach ($models as $model): ?>
                <div class="valentine-sms-b valentine-sms-b__withe">
                    <span class="valentine-sms-b_t">«<?=$model->title ?>»</span>
                    <span class="valentine-sms-b_p"><?=$model->getFormattedText() ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($pages !== null): ?>
        <?php if ($pages->pageCount > 1): ?>
            <div class="pagination pagination-center clearfix">
                <?php $this->widget('AlbumLinkPager', array('pages' => $pages)); ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>