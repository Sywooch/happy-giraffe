<?php
/* @var $this Controller
 * @var $model CommunityContent
 */
?>
<td style="width:340px;" valign="top">

    <div style="padding:10px;border:1px solid #e7e7e7;width:318px;">

        <table cellpadding="0" cellspacing="0" style="margin-bottom:8px;">
            <tbody>
            <tr>
                <td valign="top"><img src="<?=$model->contentAuthor->getAva() ?>"
                                      style="display:block;margin-top:-40px;-moz-border-radius:36px;-webkit-border-radius:36px;border-radius:36px;">
                </td>
                <td valign="top">
                    <span style="color:#38a5f4;font:12px arial, helvetica, sans-serif;margin-left:10px;vert"><?=$model->contentAuthor->first_name ?></span>
                </td>
            </tr>
            </tbody>
        </table>

        <div style="margin-bottom:5px;">
            <span style="color:#0d81d5;font:bold 18px/20 arial, helvetica, sans-serif;">
                <a href="http://www.happy-giraffe.ru<?=$model->getUrl() ?>" target="_blank" style="color:#0d81d5;font:bold 18px/20px arial, helvetica, sans-serif;"><?=$model->title ?></a></span>
        </div>

        <div style="margin-bottom:5px;">
            <span style="color:#b6b9ba;font:9px tahoma, arial, helvetica, sans-serif;"><?= Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created); ?></span>
        </div>

        <div style="margin-bottom:5px;">
            <a href="http://www.happy-giraffe.ru<?=$model->getUrl() ?>" target="_blank" style="text-decoration: none;">
                <img src="http://www.happy-giraffe.ru<?=$model->getContentImage() ?>" width="318" border="0" style="display:block;"></a>
        </div>

        <div style="font:13px arial, helvetica, sans-serif;color:#040404;">
            <?= Str::truncate(strip_tags($model->getContent()->text), 450); ?>
            <span style="color:#0d81d5;">
                <a href="http://www.happy-giraffe.ru<?=$model->getUrl() ?>" target="_blank" style="color:#0d81d5;">Читать&nbsp;всю&nbsp;запись<img
                src="http://dev.happy-giraffe.ru/images/mail/icon_more.gif" style="margin-left:5px;"></a>
            </span>
        </div>

        <table cellpadding="0" cellspacing="0" style="margin-top:20px;">
            <tbody>
            <tr>
                <td style="padding-right:10px;">
                    <span style="color:#737575;font:12px arial, helvetica, sans-serif;">
                        <img src="http://dev.happy-giraffe.ru/images/mail/icon_views.gif"
                        style="margin-right:5px;vertical-align:top;"><?=PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $model->url), true); ?>
                    </span>
                </td>
                <td style="padding-right:15px;">
                    <span style="color:#31a4f6;font:12px arial, helvetica, sans-serif;">
                        <a href="http://www.happy-giraffe.ru<?=$model->getUrl() ?>#comments" target="_blank" style="color:#31a4f6;font:12px arial, helvetica, sans-serif;"><img
                        src="http://dev.happy-giraffe.ru/images/mail/icon_comments.gif"
                        style="margin-right:5px;vertical-align:top;"><?=$model->commentsCount ?></a></span>
                </td>
                <td>
                    <?php $i = 0; foreach ($model->comments as $comment): ?>
                        <?php if (!empty($comment->author->avatar_id)):?>
                        <?php $i++ ?>
                            <img src="<?=$comment->author->getAva('small') ?>"
                                 style="margin-right:5px;-moz-border-radius:12px;-webkit-border-radius:12px;border-radius:12px;">
                        <?php if ($i == 6) break; ?>
                        <?php endif ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            </tbody>
        </table>

    </div>

</td>