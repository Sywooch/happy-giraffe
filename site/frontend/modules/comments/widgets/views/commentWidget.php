<div id="commentsList" class="comments_hold tab-pane active">
    <div class="comments_add">
        <div class="comments_add-hold"> Комментировать от
            <?php $this->widget('site.frontend.modules.signup.widgets.AuthWidget', array('view' => 'simple')); ?> или <a href="#" onclick="openLoginPopup(event)" class="comments_add-a">Войти</a>
        </div>
        <div class="comments_add-editor display-n"></div>
    </div>
    <ul class="comments_ul" id="<?= $this->id ?>_comments">
        <?php
        /**
         * @var $this site\frontend\modules\comments\widgets\CommentWidget
         * @var $dataProvider CActiveDataProvider
         */
        $this->beginClip('comment');
        ?>
        <div class="comments_i">
            <div class="comments_ava">
                <!-- Аватарки размером 40*40-->
                <!-- ava--><a href="{link}" class="ava ava__middle ava__small-sm-mid"><img alt="" src="{ava}" class="ava_img"></a>
            </div>
            <div class="comments_frame">
                <div class="comments_header">
                    {author.link}
                    <time datetime="{datetime}" class="tx-date" data-bind="moment: {unixtime}"></time>
                </div>
                <div class="comments_cont">
                    <div class="wysiwyg-content">
                        {response.link}{comment}
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->endClip();
        $colors = array(
            'comments_li__lilac',
            'comments_li__red',
            'comments_li__yellow',
            'comments_li__blue',
            'comments_li__green',
        );

        $iterator = new CDataProviderIterator($dataProvider);
        $colorI = -1;
        $colorC = sizeof($colors);
        $color = $colors[0];
        $ul = false;
        foreach ($iterator as $comment)
        {
            if ($ul && $comment->id == $comment->root_id)
                echo CHtml::closeTag('ul');
            if($comment->id == $comment->root_id)
                $color = $colors[(++$colorI) % $colorC];

            echo CHtml::openTag('li', array('class' => 'comments_li clearfix ' . $color));

            $this->controller->renderClip('comment', array(
                '{link}' => $comment->author->url,
                '{ava}' => $comment->author->getAvatarUrl(Avatar::SIZE_MEDIUM),
                '{author.link}' => $this->getUserLink($comment->author),
                '{datetime}' => $comment->pubDate,
                '{unixtime}' => $comment->pubUnixTime,
                '{response.link}' => $comment->response ? $this->getUserLink($comment->response->author, true) : '',
                '{comment}' => $this->normalizeText($comment->purified->text),
            ));

            if ($comment->id == $comment->root_id)
            {
                $ul = true;
                echo CHtml::openTag('ul', array('class' => 'comments_ul'));
            }

            echo CHtml::closeTag('li');
        }
        ?>
    </ul>
</div>
<?php
Yii::app()->clientScript->registerAMD('Comments#' . $this->id, array('ko' => 'knockout', 'ko_library' => 'ko_library', 'commentScroll' => 'commentScroll', "common" => "common"), 'ko.applyBindings({}, document.getElementById("' . $this->id . '_comments"));');
?>