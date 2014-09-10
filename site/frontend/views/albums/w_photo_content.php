<div id="photo-content">
    <?php if (get_class($model) == 'Contest'): ?>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => 'Вам понравилось фото?',
            'notice' => '<big>Это конкурсные баллы</big><p>Нажатие на кнопку социальных сетей +1 балл.<br />Нажатие сердечка от Весёлого Жирафа +2 балла.</p>',
            'model' => $photo->getAttachByEntity('ContestWork')->model,
            'type' => 'simple',
            'options' => array(
                'title' => CHtml::encode($photo->w_title),
                'image' => $photo->getPreviewUrl(180, 180),
                'description' => $photo->w_description,
            ),
        ));  ?>

        <?php if ($photo->author_id == Yii::app()->user->id): ?>
            <?php
                $url = Yii::app()->createAbsoluteUrl('albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $model->id, 'photo_id' => $photo->id));
            ?>
            <div class="sharelink-friends">
                <div class="title-row">
                    Отправить ссылку друзьям
                    <input type="text" class="text" value="<?=$url?>" onclick="$(this).select();" />
                </div>
                <p>Хочешь победить в конкурсе? Разошли эту ссылку друзьям и знакомым, сделай подписью в скайпе, аське и статусом в социальных сетях. Чем больше человек проголосует за твоё фото - тем выше шансы на победу!</p>

            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php

    $post = $photo;
    Yii::import('site.common.models.forms.PhotoViewComment');
    //костыль для велентина
    if (isset($model->content) && method_exists($model->content, 'isValentinePost') && $model->content->isValentinePost()){
        $post = $model->content;
        $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => 'Вам понравилось фото?',
            'notice' => '',
            'model' => $post,
            'type' => 'simple_ajax',
            'options' => array(
                'title' => CHtml::encode($post->title),
                'image' => $model->items[0]->photo->getOriginalUrl(),
                'description' => $post->preview,
            ),
        ));
    }

    //костыль для украшений блюд
    if (get_class($model) == 'CookDecorationCategory'){
        $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => 'Вам понравилось фото?',
            'notice' => '',
            'model' => $photo,
            'type' => 'simple_ajax',
            'options' => array(
                'title' => CHtml::encode('Оформления блюд на Веселом Жирафе - '.$photo->title),
                'image' => $photo->getPreviewUrl(180, 180),
                'description' => $photo->w_description,
            ),
            'url'=>$this->createAbsoluteUrl('/cook/decor/index', array('id'=>'photo'.$photo->id))
        ));
    }

     $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
        'model' => $post,
        'popUp' => true,
        'commentModel' => 'PhotoViewComment',
        'photoContainer'=>true
    )); ?>

    <!-- <div class="textalign-c margin-20">
        <div class="counter-rambler">  
            <noindex>
                <div class="counter-rambler_i" id="counter-rambler-popup"></div>
                <a class="counter-rambler_a" href="http://www.rambler.ru/" target="_blank" rel="nofollow">Партнер «Рамблера»</a>
            </noindex>
        </div>
    </div> -->
</div>

<script type="text/javascript">
    /*var _top100q = _top100q || [];

    _top100q.push(["setAccount", "2900190"]);
    _top100q.push(["trackPageviewByLogo", document.getElementById("counter-rambler-popup")]);


    (function(){
        var top100 = document.createElement("script"); top100.type = "text/javascript";

        top100.async = true;
        top100.src = ("https:" == document.location.protocol ? "https:" : "http:") + "//st.top100.ru/top100/top100.js";
        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(top100, s);
    })();*/
</script>

<!-- tns-counter.ru -->
<script type="text/javascript">
    (function(win, doc, cb){
        (win[cb] = win[cb] || []).push(function() {
            try {
                tnsCounterHappygiraffe_ru = new TNS.TnsCounter({
                    'account':'happygiraffe_ru',
                    'tmsec': 'happygiraffe_total'
                });
            } catch(e){}
        });

        var tnsscript = doc.createElement('script');
        tnsscript.type = 'text/javascript';
        tnsscript.async = true;
        tnsscript.src = ('https:' == doc.location.protocol ? 'https:' : 'http:') +
            '//www.tns-counter.ru/tcounter.js';
        var s = doc.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(tnsscript, s);
    })(window, this.document,'tnscounter_callback');
</script>
<noscript>
    <img src="//www.tns-counter.ru/V13a****happygiraffe_ru/ru/UTF-8/tmsec=happygiraffe_total/" width="0" height="0" alt="" />
</noscript>
<!--/ tns-counter.ru -->

<?php if (Yii::app()->request->getQuery('go')): ?>
    <div class="test">
        <?php $this->widget('FavouriteWidget', array('model' => $photo)); ?>
    </div>

    <script type="text/javascript">
        $('.photo-info .favorites-control').replaceWith($('.test .favorites-control'));
    </script>
<?php endif; ?>