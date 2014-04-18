<?php
/**
 * @var MailMessageDaily $message
 * @var CommunityContent $post
 */
$commentsCount = $post->getCommentsCount();
$comments = $post->getLastCommentators(5);
$urlParams = $post->getUrlParams();
$galleryUrlParams = CMap::mergeArray(array($urlParams[0]), $urlParams[1], array('openGallery' => 1));
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#c2aee5">
    <tr>
        <td style="padding: 10px 15px 0;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td valign="top" width="40">
                                    <a href="<?php echo $message->createUrl($post->author->getUrl(true), 'userAvatar'); ?>" style="text-decoration:none;" target="_blank"><img src="<?php echo $post->author->getAvatarUrl(40); ?>" style="border: 0;display:block;-moz-border-radius:22px;-webkit-border-radius:22px;border-radius:22px;" /></a>
                                </td>

                                <td width="10">
                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="20" width="10" border="0" />
                                </td>
                                <td valign="top">
                                    <a href="<?php echo $message->createUrl($post->author->getUrl(true), 'userLink'); ?>" style="color:#ffffff;font:12px arial, helvetica, sans-serif;text-decoration:none;" target="_blank"><?php echo $post->author->getFullName(); ?></a>
                                </td>
                                <?php if (! $post->getIsFromBlog()): ?>
                                <td valign="top" style="padding:2px 5px;">
                                    <!-- bg зависит от рубрики -->
                                    <a href="" style="background: #<?php echo $post->rubric->community->club->section->color; ?>;padding:2px 6px; color: #ffffff;  font-weight:bold; font-size: 10px; font-family: 'Arial black', arial, tahoma; text-decoration:none; text-transform: uppercase;" target="_blank"><?php echo $post->rubric->community->title; ?></a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <a href="<?php echo $message->createUrl($post->getUrl(false, true), 'textLink'); ?>" style="color:#ffffff;font:bold 34px/38px arial, helvetica, sans-serif;text-decoration:none;" target="_blank"><?php echo $post->title; ?></a>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px 0 18px;">
            <a href="<?php echo $message->createUrl($post->getUrl(false, true), 'imageLink'); ?>" style="border: 0;" target="_blank">
                <!--
                    Ширина 660пк, высота пропорциональна исходнику

                    Водяной знак
                    Поверх изображения нужно накладывать
                    /new/images/mail/water-mark.png  151*151px
                    По центру вертикали и горизонтали изображения
                    Текст
                    font-family:Arial;
                    font-size: 18px;
                    color: #333333;
                    Отступ от верха водяного знака 113px.
                    По ширине по центру
                -->
                <img src="<?php echo $message->getPhotoPostImage($post); ?>" alt="" style="border: 0;"/>
            </a>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 20px 20px;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="padding-right:10px;">
                                    <span style="color:#ffffff;font:12px arial, helvetica, sans-serif;"><img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ico-views-white-small.png" style="margin-right:5px;vertical-align:top;"><?php echo PageView::model()->viewsByPath($post->getUrl()); ?></span>
                                </td>
                                <?php if ($commentsCount > 0): ?>
                                    <td style="padding-right:2px;">
                                        <a href="<?php echo $message->createUrl($post->getUrl(true, true)); ?>" style="color:#ffffff;font:12px arial, helvetica, sans-serif;text-decoration:none;" target="_blank"><img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ico-comments-small.png" style="margin-right:5px;vertical-align:top;"></a>
                                    </td>
                                    <td>
                                        <?php foreach ($comments as $comment): ?>
                                            <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/ava.jpg" style="-moz-border-radius:12px;-webkit-border-radius:12px;border-radius:12px;" />
                                        <?php endforeach; ?>

                                    </td>
                                    <?php if ($commentsCount > 5): ?>
                                    <td style="color: #333333; font-size: 12px; padding-left: 4px;">
                                        еще <?php echo ($commentsCount - 5); ?>
                                    </td>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </td>
                    <td align="right">
                        <table border="0" cellpadding="0" cellspacing="0" style="background-color:#2ea0f7; border-radius:4px;">
                            <tr>
                                <td align="center" valign="middle" style="color:#ffffff; font-size:16px;  line-height:150%; padding-top:5px; padding-right:15px; padding-bottom:5px; padding-left:15px;">
                                    <a href="<?php echo $message->createUrl($galleryUrlParams, 'galleryLink'); ?>" style="color:#ffffff; text-decoration:none;" target="_blank">Смотреть галерею</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>