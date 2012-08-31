<?php
/* @var $this SController
 * @var $commentator CommentatorWork
 */
$user = User::model()->findByPk($commentator->user_id)
?>
<div class="clearfix user-info-center">
    <div class="user-info ">
        <?= CHtml::link(CHtml::image($user->getAva()), 'http://www.happy-giraffe.ru/user/'.$user->id.'/', array('target'=>'_blank', 'class'=>'ava'))?>

        <div class="details">
            <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/" class="username" target="_blank"><?=$user->fullName ?></a>

            <div class="user-fast-nav">
                <ul>
                    <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/" target="_blank">Анкета</a>&nbsp;|&nbsp;
                    <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/blog/" target="_blank">Блог</a>&nbsp;|&nbsp;
                    <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/albums/" target="_blank">Фото</a>&nbsp;|&nbsp;
                    <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/activity/" target="_blank">Что нового</a>&nbsp;|&nbsp;
                    <span class="drp-list"><a href="javascript:;" class="more" onclick="$(this).next().toggle()">Еще</a>
                        <ul style="display: none;">
                            <li>
                                <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/clubs/"
                                   target="_blank">Клубы</a></li>
                            <li>
                                <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/friends/" target="_blank">Друзья</a>
                            </li>
                        </ul>
                    </span>

                </ul>
            </div>
        </div>
    </div>
</div>