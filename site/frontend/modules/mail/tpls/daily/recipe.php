<?php
/**
 * @var MailMessageDaily $message
 * @var CookRecipe $recipe
 */
$favourites = Favourite::model()->getAllByModel($recipe, 5);
$favouritesCount = count($favourites);
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:5px; border: 1px solid #f5f5f5;">
    <tr>
        <td style="padding: 10px 15px 5px;">
            <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:5px;">
                <tr>
                    <td valign="top" rowspan="2" style="padding-right: 10px;" >
                        <a href="<?php echo $message->createUrl($recipe->author->getUrl(true), 'userAvatar'); ?>" style="text-decoration:none;" target="_blank"><img src="<?php echo $recipe->author->getAvatarUrl(40); ?>" style="border: 0;display:block;-moz-border-radius:22px;-webkit-border-radius:22px;border-radius:22px;" /></a>
                    </td>
                    <td valign="top">
                        <a href="<?php echo $message->createUrl($recipe->author->getUrl(true), 'userLink'); ?>" style="color:#38a5f4;font:12px arial, helvetica, sans-serif; text-decoration:none;" target="_blank"><?php echo $recipe->author->getFullName(); ?></a>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <!-- bg зависит от рубрики -->
                        <a href="<?php echo $message->createUrl(array('cook/recipe/index')); ?>" style="background: #f26748;padding:2px 6px; color: #ffffff;  font-weight:bold; font-size: 10px; font-family: 'Arial black', arial, tahoma; text-decoration:none; text-transform: uppercase;" target="_blank">Рецепт дня</a>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" width="100%"  style="margin-bottom:5px;" >
                <tr>
                    <td>
                        <a href="<?php echo $message->createUrl($recipe->getUrl(false, true), 'textLink'); ?>" style="color:#186fb8;font:bold 25px/28px arial, helvetica, sans-serif;letter-spacing:-0.5px;text-decoration:underline;" target="_blank"><?php echo $recipe->title; ?></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php if ($recipe->getMainPhoto() !== null): ?>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                    <tr>
                        <td style="margin-bottom:5px;">
                            <!--  -->
                            <a href="<?php echo $message->createUrl($recipe->getUrl(false, true), 'imageLink'); ?>" style="text-decoration: none;" target="_blank"><img src="<?php echo $recipe->getMainPhoto()->getPreviewUrl(318, null, Image::WIDTH); ?>" width="318" border="0" style="display:block;" /></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endif; ?>
    <?php if (count($favourites) > 0): ?>
        <tr>
            <td style="padding: 0px 15px 15px;">

                <table cellpadding="0" cellspacing="0" border="0" style="margin-top:20px;margin-left:5px;" width="">
                    <tr>
                        <td style="padding-right:10px;" rowspan="2">
                            <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ico-cook-book.jpg" style="margin-right:5px;vertical-align:top;">
                        </td>
                        <td align="center" style="color: #333333; font-size: 12px;" colspan="2">
                            Добавили в кулинарную книгу
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php foreach ($favourites as $favourite): ?>
                            <img src="<?php echo $favourite->user->getAvatarUrl(24); ?>" style="-moz-border-radius:12px;-webkit-border-radius:12px;border-radius:12px;" />
                            <?php endforeach; ?>

                        </td>
                        <?php if ($favouritesCount > 5): ?>
                            <td style="color: #333333; font-size: 12px; padding-left: 4px;">
                                еще <?php echo ($favouritesCount - 5); ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                </table>

            </td>
        </tr>
    <?php endif; ?>
</table>