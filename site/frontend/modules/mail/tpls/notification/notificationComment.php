<?php
/**
 * @var MailMessageNotificationDiscuss $message
 */
?>

<tr>
    <td valign="top" style="padding-top: 5px;padding-right: 2px;">
        <img src="http://109.87.248.203/new/images/mail/comment.png" style="display:block;">
    </td>
    <td valign="top"></td>
    <td valign="top" style="padding: 12px 0 10px;">
        <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
            <?php if ($message->model instanceof CommunityContent && $message->model->type_id == CommunityContent::TYPE_QUESTION): ?>
                <tr>
                    <td valign="top" style="padding-top: 5px;padding-right: 2px;">
                        <img src="http://109.87.248.203/new/images/mail/ansver-question.png" style="display:block;">
                    </td>
                    <td valign="top"></td>
                    <td valign="top" style="padding-top: 12px;">
                        <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td style="font-size: 16px; color: #111111;">
                                    У вас <?php echo $message->totalCommentsCount; ?> <?php echo Str::GenerateNoun(array('новый ответ', 'новых ответа', 'новых ответов'), $message->totalCommentsCount); ?> <br />
                                    на ваш вопрос <a href="<?php echo $message->createUrl($message->model->getUrl(true, true)); ?>"  style="color:#3482e2;text-decoration:underline;"><?php echo $message->model->title; ?></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td style="font-size: 16px;color: #111111">
                        У вас <?php echo $message->totalCommentsCount; ?> <?php echo Str::GenerateNoun(array('новый комментарий', 'новых комментария', 'новых комментария'), $message->totalCommentsCount); ?>  <br />
                        к  вашей записи <a href="<?php echo $message->createUrl($message->model->getUrl(true, true)); ?>"  style="color:#3482e2;text-decoration:underline;"><?php echo $message->model->title; ?></a>
                    </td>
                </tr>
                <?php if ($message->model instanceof AlbumPhoto); ?>
                <tr>
                    <td style="padding-top:10px;">
                        <!-- Width 200px, height auto -->
                        <img src="<?php echo $message->model->getPreviewUrl(200, null, Image::WIDTH); ?>" alt="" />
                    </td>
                </tr>
                <?php endif; ?>
            <?php endif; ?>
        </table>
    </td>
</tr>