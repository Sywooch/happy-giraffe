<?php
/**
 * @var MailMessageDaily $message
 * @var CommunityContent $post
 * @todo Цвета рубрик
 * @todo Капс рубрики
 */
$photo = $post->getPhoto();
$commentsCount = $post->getCommentsCount();
$comments = $post->getLastCommentators(5);
?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:5px; border: 1px solid #f5f5f5;">
    <tr>
        <td style="padding: 10px 15px 5px;">
            <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:5px;">
                <tr>
                    <td valign="top" rowspan="2" style="padding-right: 10px;" >
                        <a href="" style="text-decoration:none;"><img src="<?php echo $post->author->getAvatarUrl(40); ?>" style="border: 0;display:block;-moz-border-radius:22px;-webkit-border-radius:22px;border-radius:22px;" /></a>
                    </td>
                    <td valign="top">
                        <a href="<?php echo $message->createUrl($post->author->getUrl(true)) ?>" style="color:#38a5f4;font:12px arial, helvetica, sans-serif;text-decoration:none;"><?php echo $post->author->getFullName(); ?></a>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <!-- bg зависит от рубрики -->
                        <a href="" style="background: #5ebdff;padding:2px 6px; color: #ffffff;  font-weight:bold; font-size: 10px; font-family: 'Arial black', arial, tahoma; text-decoration:none;"><?php echo $post->rubric->community->title; ?></a>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:5px;">
                <tr>
                    <td>
                        <a href="<?php echo $message->createUrl($post->getUrl(false, true), 'title'); ?>" target="_blank" style="color:#186fb8;font:bold 25px/28px arial, helvetica, sans-serif;letter-spacing:-0.5px;text-decoration:underline; "><?php echo $post->title; ?></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php if ($photo !== null): ?>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                <tr>
                    <td style="margin-bottom:5px;">
                        <a href="<?php echo $message->createUrl($post->getUrl(false, true)); ?>" target="_blank" style="text-decoration: none;"><img src="<?php echo $photo->getPreviewUrl(318, null, Image::WIDTH); ?>" width="318" border="0" style="display:block;" /></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td style="padding: 10px 15px 15px;">

            <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                <tr>
                    <td style="font:13px/18px arial, helvetica, sans-serif;color:#040404;">
                        <?php echo $post->getContentText(256); ?>
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" border="0" style="margin-top:20px;">
                <tr>
                    <td style="padding-right:10px;">
                        <span style="color:#737575;font:12px arial, helvetica, sans-serif;"><img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ico-views-small.png" style="margin-right:5px;vertical-align:top;"><?php echo PageView::model()->viewsByPath($post->getUrl()); ?></span>
                    </td>
                    <?php if ($commentsCount > 0): ?>
                        <td style="padding-right:5px;">
                            <a href="<?php echo $this->createUrl($post->getUrl(true, true)); ?>" target="_blank" style="color:#31a4f6;font:12px arial, helvetica, sans-serif;"><img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ico-comments-small.png" style="margin-right:5px;vertical-align:top;"></a>
                        </td>
                        <td>
                            <?php foreach ($comments as $comment): ?>
                                <img src="<?php echo $comment->author->getAvatarUrl(24); ?>" style="-moz-border-radius:12px;-webkit-border-radius:12px;border-radius:12px;" />
                            <?php endforeach; ?>

                        </td>
                        <?php if ($commentsCount > 5); ?>
                            <td style="color: #333333; font-size: 12px; padding-left: 4px;">
                                еще <?php echo ($commentsCount - 5); ?>
                            </td>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
            </table>

        </td>
    </tr>
</table>