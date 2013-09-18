<?php $comments = $this->getComments(); ?><div class="photo-window_right">

    <div class="photo-window_banner-hold clearfix">
        <!-- R-87026-5 ﬂÌ‰ÂÍÒ.RTB-·ÎÓÍ  -->
        <div id="yandex_ad_R-87026-5"></div>
        <script type="text/javascript">
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Context.AdvManager.render({
                        blockId: "R-87026-5",
                        renderTo: "yandex_ad_R-87026-5",
                        async: true
                    });
                });
                t = d.getElementsByTagName("script")[0];
                s = d.createElement("script");
                s.type = "text/javascript";
                s.src = "//an.yandex.ru/system/context.js";
                s.async = true;
                t.parentNode.insertBefore(s, t);
            })(this, this.document, "yandexContextAsyncCallbacks");
        </script>
    </div>

    <?php $this->render('view', array('comments' => $comments)); ?>

</div>

<div class="photo-window_right-bottom <?=$this->objectName ?>">
    <div class="comments-gray comments-gray__photo-add">
        <div class="comments-gray_add clearfix">

            <?php if (!Yii::app()->user->isGuest):?>
                <div class="comments-gray_ava">
                    <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 24)) ?>
                </div>
            <?php endif ?>
            <div class="comments-gray_frame">
                <input type="text" id="add_<?=$this->objectName ?>" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий" data-bind="enterKey: addComment" value="">
            </div>
        </div>
    </div>
</div>