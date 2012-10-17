<?php
    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.img > a',
        'entity' => 'Contest',
        'entity_id' => $contest->id,
        'query' => array('sort' => $sort),
    ));

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
    ;
?>

<div class="contest-about clearfix">

    <?php if (! Yii::app()->user->isGuest && Yii::app()->user->model->getContestWork($this->contest->id) !== null): ?>
        <?php $this->widget('site.frontend.widgets.user.ContestWidget', array(
            'user' => Yii::app()->user->model,
            'contest_id' => $this->contest->id,
            'registerGallery' => false,
        )); ?>
    <?php else: ?>
        <div class="sticker">
            <?php if (Yii::app()->user->isGuest): ?>
                <big>Условия конкурса:</big>
                <p>Для того, чтобы принять участие в конкурсе, вы должны <?=CHtml::link('зарегистрироваться', '#register', array('class' => 'fancy', 'data-theme' => 'white-square'))?></p>
            <?php elseif (Yii::app()->user->model->scores->full != 2): ?>
                <big>Условия конкурса:</big>
                <p>Для того, чтобы принять участие в конкурсе, вы должны <?=CHtml::link('пройти 6 шагов', array('/user/profile', 'user_id' => Yii::app()->user->id))?> заполнения анкеты</p>
            <?php else: ?>
                <p>Разместите фотографию, на которой вы с малышом получились наиболее удачно и примите участие в конкурсе! Не забудьте пригласить друзей в группу поддержки!                </p>
                <center>
                    <a href="<?=$this->createUrl('/contest/default/statement', array('id' => $this->contest->id))?>" onclick="Contest.canParticipate(this, '<?=$this->createUrl('/contest/default/canParticipate', array('id' => $this->contest->id))?>'); return false;" class="btn-green btn-green-medium">Участвовать<i class="arr-r"></i></a>
                </center>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="content-title">О конкурсе</div>

    <p>Говорят, что самая прекрасная из женщин – это женщина с ребенком на руках. Общаясь на «Веселом Жирафе», мы поняли, что у нас самые прекрасные мамы, которые держат на руках самых красивых малышей. Теперь мы хотим показать их всем!</p>
    <p>Примите участие в конкурсе «Мама и я» – покажитесь всему миру! Посмотрите на другие счастливые лица малышей и их мам из разных городов. А кроме приятного общения, которое гарантировано для всех участников конкурса, авторы самых интересных по мнению пользователей фотографий получат отличные призы.</p>

</div>

<div class="content-title">Вас ждут замечательные призы!</div>

<div class="contest-prizes-list contest-prizes-list-2 clearfix">

    <ul>
        <li>
            <div class="img">
                <img src="/images/prize_6.jpg" />
            </div>
            <div class="place place-1-1"></div>
            <div class="title">
                <a href="">Фотоаппарат<br/><b>SONY Cyber-shot DSC-HX10</b></a>
            </div>
        </li>
        <li>
            <div class="img">
                <img src="/images/prize_7.jpg" />
            </div>
            <div class="place place-2-3"></div>
            <div class="title">
                <a href="">Фоторамка<br/><b>SONY DPF-D830LB 8"</b></a>
            </div>
        </li>

    </ul>

</div>

<?php if ($works->itemCount > 0): ?>
    <div class="content-title">
        Последние добавленные фото
        <a href="<?=$this->createUrl('/contest/default/list', array('id' => $this->contest->id))?>" class="btn-blue-light btn-blue-light-small">Показать все</a>
    </div>

    <div class="gallery-photos-new cols-4 clearfix">

        <?php
            $this->widget('MyListView', array(
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
                ),
                'emptyText'=>'В этом альбоме у вас нет фотографий'
            ));
        ?>

    </div>
<?php endif; ?>