<div class="b-main_col-article">
    <!-- comments-->
    <div class="comments comments__buble">
        <div class="comments-menu">
            <ul data-tabs="tabs" class="comments-menu_ul">
                <li class="comments-menu_li active"><a href="#commentsList" data-toggle="tab" class="comments-menu_a comments-menu_a__comments">Комментарии 68 </a></li>
                <li class="comments-menu_li"><a href="#likesList" data-toggle="tab" class="comments-menu_a comments-menu_a__likes">Нравится 865</a></li>
                <li class="comments-menu_li"><a href="#favoritesList" data-toggle="tab" class="comments-menu_a comments-menu_a__favorites">Закладки 865</a></li>
            </ul>
            <div class="tab-content">
                <div id="commentsList" class="comments_hold tab-pane active">
                    <div class="comment-add">
                        <div class="comment-add_hold"> Комментировать от
                            <div class="ico-social-hold"><a href="" class="ico-social ico-social__odnoklassniki"></a><a href="" class="ico-social ico-social__vkontakte"></a></div> или <a class="comment-add_a">Войти</a>
                        </div>
                        <div class="comment-add_editor display-n"></div>
                    </div>
                    <ul class="comments_ul">
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
            <!-- ava--><a href="" class="ava ava__middle ava__small-sm-mid"><img alt="" src="{ava}" class="ava_img"></a>
        </div>
        <div class="comments_frame">
            <div class="comments_header"><a href="" rel="author" class="a-light comments_author">{author.name}</a>
                <time datetime="{datetime}" pubdate class="tx-date">2 минуты назад</time>
            </div>
            <div class="comments_cont">
                <div class="wysiwyg-content">
                    {comment}
                </div>
            </div>
        </div>
    </article>
    <ul class="comments_ul">
        {comments}
    </ul>
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
$colorI = 0;
$colorC = sizeof($colors);
$comments = '';
foreach ($iterator as $comment)
{
    if ($comment->root_id == $comment->id)
    {
        $color = $colors[$colorI % $colorC];
        $colorI++;
        if($root)
        {
            $this->controller->renderClip('comment', array(
                '{colorClass}' => $color,
                '{ava}' => $root->author->getAvatarUrl(Avatar::SIZE_MEDIUM),
                '{author.name}' => $root->author->fullName,
                '{comment}' => $root->text,
                '{comments}' => $comments,
            ));
        }
        $root = $comment;
        $comments = '';
    }
    else
    {
        $comments .= $this->controller->renderClip('comment', array(
            '{colorClass}' => $color,
            '{ava}' => $comment->author->getAvatarUrl(Avatar::SIZE_MEDIUM),
            '{author.name}' => $comment->author->fullName,
            '{comment}' => $comment->text,
            '{comments}' => '',
        ), true);
    }
}
?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /comments-->
</div>
