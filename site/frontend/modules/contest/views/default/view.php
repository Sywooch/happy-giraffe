<?php
    $cs = Yii::app()->clientScript;

    $js = '
			var $container = $(\'.gallery-photos-new\');

			$container.imagesLoaded( function(){
				$container.masonry({
					itemSelector : \'li\',
					columnWidth: 240,
					saveOptions: true,
					singleMode: false,
					resizeable: true
				});
			});
    ';

    $cs
        ->registerScript('contest-view', $js)
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
        ->registerMetaTag('/images/contest/banner-social-'.$contest->id.'.jpg', null, null, array('property' => 'og:image'))
    ;
?>

<div class="contest-about clearfix">

    <?php $this->widget('MyContestWorkWidget', array('contestId' => $this->contest->id)); ?>

    <?php if (false): ?>
        <?php if (! Yii::app()->user->isGuest && Yii::app()->user->model->getContestWork($this->contest->id) !== null): ?>
            <?php $this->widget('site.frontend.widgets.user.ContestWidget', array(
                'user' => Yii::app()->user->model,
                'contest_id' => $this->contest->id,
                'registerGallery' => false,
            )); ?>
        <?php elseif ($this->contest->status == Contest::STATUS_ACTIVE): ?>
            <div class="sticker">
                <?php if ($this->contest->getCanParticipate() === Contest::STATEMENT_GUEST): ?>
                    <big>Условия конкурса:</big>
                    <p>Для того, чтобы принять участие в конкурсе, вы должны <?=CHtml::link('зарегистрироваться', '#register', array('class' => 'fancy', 'data-theme' => 'white-square'))?></p>
                <?php elseif ($this->contest->getCanParticipate() === Contest::STATEMENT_STEPS): ?>
                    <big>Условия конкурса:</big>
                    <p>Для того, чтобы принять участие в конкурсе, вы должны <?=CHtml::link('пройти 6 шагов', array('/user/profile', 'user_id' => Yii::app()->user->id))?> заполнения анкеты</p>
                <?php else: ?>
                    <p>Разместите фотографию, на которой ваш малыш сфотографирован на своем любимом транспортном средстве и примите участие в конкурсе! Не забудьте пригласить друзей в группу поддержки!</p>
                    <center>
                        <a href="<?=Yii::app()->user->isGuest ? '#' : $this->createUrl('/contest/default/statement', array('id' => $this->contest->id))?>" onclick="Contest.canParticipate(this, '<?=$this->createUrl('/contest/default/canParticipate', array('id' => $this->contest->id))?>'); return false;" class="btn-green btn-green-medium">Участвовать<i class="arr-r"></i></a>
                    </center>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="content-title">О конкурсе</div>

    <?=$contest->text?>

</div>

<div class="content-title">Вас ждут замечательные призы!</div>

<?php $this->renderPartial('prizes/' . $this->contest->id); ?>

<?php if ($contest->id == 5): ?>
<p style="color: #F66161;">Уважаемые участники конкурса!<br />
    В процесс определения победителей конкурса внесены изменения! Теперь победители будут определяться экспертным жюри из числа первых ста участников, набравших наибольшее количество голосов.<br />
    <br />
    С уважением,<br />
    администрация портала "Веселый Жираф"</p><br />
<?php endif; ?>

<?php if ($works->itemCount > 0): ?>
    <div class="content-title">
        <a href="<?=$this->createUrl('/contest/default/list', array('id' => $this->contest->id))?>" class="i-more float-r">Все участники (<?=$works->totalItemCount?>)</a>
        Последние добавленные фото
    </div>

    <div class="gallery-photos-new cols-4 clearfix">

        <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $works,
                'itemView' => '_work',
                'summaryText' => 'показано: {start} - {end} из {count}',
                'pager' => array(
                    'class' => 'AlbumLinkPager',
                ),
                'id' => 'photosList',
                'itemsTagName' => 'ul',
                //'template' => '{items}<div class="pagination pagination-center clearfix">{pager}</div>',
                'template' => '{items}',
                'viewData' => array(
                    'currentPage' => $works->pagination->currentPage,
                    'collection' => $collection,
                ),
                'emptyText'=>'В этом альбоме у вас нет фотографий'
            ));
        ?>

    </div>
<?php endif; ?>