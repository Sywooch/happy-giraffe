<?php
/* @var $this Controller
 * @var $models CommunityContent[]
 */
$i = 0;
?><table style="width:100%;margin-bottom:50px;" cellpadding="0" cellspacing="0">
    <tbody><tr>
        <?php foreach ($models as $model): ?>
    <?php $this->render('_view',compact('model')); ?>
        <?php $i++; ?>
                <?php if ($i % 2 == 0):?>
                    <?php if ($i != count($models)):?>
                        </tr>
        </tbody>
    </table>
        <table style="width:100%;margin-bottom:50px;" cellpadding="0" cellspacing="0">
        <tbody><tr>
                    <?php endif ?>
                <?php else: ?>
                    <td height="100%" width="20">
                        <img src="http://dev.happy-giraffe.ru/images/mail/blank.gif" width="20" height="100%" border="0">
                    </td>
                <?php endif ?>
        <?php endforeach; ?>

        </tr>
    </tbody>
</table>