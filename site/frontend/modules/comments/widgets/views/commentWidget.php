<div id="commentsList" class="comments_hold tab-pane active">
    <div class="comments-add">
        <div class="comments_add-hold"> Комментировать от
            <?php $this->widget('site.frontend.modules.signup.widgets.AuthWidget', array('view' => 'simple')); ?> или <a href="?openLogin" onclick="$('[href=#loginWidget]').trigger('click')" class="comment-add_a">Войти</a>
        </div>
        <div class="comment-add_editor display-n"></div>
    </div>
    <ul class="comments_ul" id="<?= $this->id ?>_comments">
        <?php
        /**
         * @var $this site\frontend\modules\comments\widgets\CommentWidget
         * @var $dataProvider CActiveDataProvider
         */
        $this->beginClip('comment');
        ?>
        <li class="comments_li {colorClass} clearfix">
            <article class="comments_i">
                <div class="comments_ava">
                    <!-- Аватарки размером 40*40-->
                    <!-- ava--><a href="{link}" class="ava ava__middle ava__small-sm-mid"><img alt="" src="{ava}" class="ava_img"></a>
                </div>
                <div class="comments_frame">
                    <div class="comments_header">
                        {author.link}
                        <time datetime="{datetime}" pubdate class="tx-date" data-bind="moment: {unixtime}"></time>
                    </div>
                    <div class="comments_cont">
                        <div class="wysiwyg-content">
                            {comment}
                        </div>
                    </div>
                </div>
            </article>
            {comments}
        </li>
        <?php
        $this->endClip();
        $colors = array(
            'comments_li__lilac',
            'comments_li__yellow',
            'comments_li__red',
            'comments_li__blue',
            'comments_li__green',
        );

        $iterator = new CDataProviderIterator($dataProvider);
        $root = false;
        $colorI = -1;
        $colorC = sizeof($colors);
        $color = $colors[0];
        $comments = '';
        foreach ($iterator as $comment)
        {
            if ($comment->root_id == $comment->id)
            {
                if ($root)
                {
                    $this->controller->renderClip('comment', array(
                        '{colorClass}' => $color,
                        '{author.link}' => $this->getUserLink($root->author),
                        '{ava}' => $root->author->getAvatarUrl(Avatar::SIZE_MEDIUM),
                        '{datetime}' => $root->pubDate,
                        '{unixtime}' => $root->pubUnixtime,
                        '{comment}' => $root->purified->text,
                        '{comments}' => '<ul class="comments_ul">' . $comments . '</ul>',
                    ));
                }
                $root = $comment;
                $comments = '';
                $colorI++;
                $color = $colors[$colorI % $colorC];
            }
            else
            {
                $comments .= $this->controller->renderClip('comment', array(
                    '{colorClass}' => $color,
                    '{author.link}' => $this->getUserLink($comment->author),
                    '{ava}' => $comment->author->getAvatarUrl(Avatar::SIZE_MEDIUM),
                    '{datetime}' => $comment->pubDate,
                    '{unixtime}' => $comment->pubUnixtime,
                    '{comment}' => $comment->purified->text,
                    '{comments}' => '',
                    ), true);
            }
        }
        ?>
    </ul>
</div>
</div>
<?php
Yii::app()->clientScript->registerAMD('Comments#' . $this->id, array('ko' => 'knockout', 'ko_library' => 'ko_library'), 'ko.applyBindings({}, document.getElementById("' . $this->id . '_comments"))');
?>