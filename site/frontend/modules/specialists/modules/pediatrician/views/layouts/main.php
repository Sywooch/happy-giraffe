<?php

/**
 * @var LiteController $this
 * @var string $content
 */
$this->beginContent('//layouts/lite/common');

$formattedName = Str::ucFirst(Yii::app()->user->getModel()->first_name) . '<br>' . Str::ucFirst(Yii::app()->user->getModel()->middle_name);

?>

<div id="js-pediatrician">
    <div class="layout-header">
        <header class="header header__redesign pediator-header clearfix">
            <a class="js-pediator-menu pediator-menu"><span></span></a>
            <div class="float-l">
                <div class="pediator-header__left">
                    <div class="pediator-header__ico"></div>
                </div>
            </div>
            <nav class="pediator-nav__wrapper">
                <ul class="pediator-nav__lists">
                    <li class="pediator-nav__list<?php if ($this->action->id == 'questions'): ?> pediator-nav__list-active<?php endif; ?>">
                        <a href="<?=$this->createUrl('/specialists/pediatrician/default/questions')?>" class="pediator-nav__link">Вопросы</a>
                    </li>
                    <li class="pediator-nav__list<?php if ($this->action->id == 'pulse'): ?> pediator-nav__list-active<?php endif; ?>">
                    	<a href="<?=$this->createUrl('/specialists/pediatrician/default/pulse')?>" class="pediator-nav__link">Пульс</a>
                    </li>
                    <li class="pediator-nav__list<?php if ($this->action->id == 'answers'): ?> pediator-nav__list-active<?php endif; ?>">
                        <a href="<?=$this->createUrl('/specialists/pediatrician/default/answers')?>" class="pediator-nav__link">Мои ответы</a>
                    </li>
                    <li class="pediator-nav__list<?php if ($this->action->id == 'stats'): ?> pediator-nav__list-active<?php endif; ?>">
                    	<a href="<?=$this->createUrl('/specialists/pediatrician/default/stats')?>" class="pediator-nav__link">Статистика</a>
                    </li>
                    <li class="pediator-nav__list<?php if ($this->action->id == 'rating'): ?> pediator-nav__list-active<?php endif; ?>">
                    	<a href="<?=$this->createUrl('/specialists/pediatrician/default/rating')?>" class="pediator-nav__link">Рейтинг</a>
                    </li>
                   	<li class="pediator-nav__list pediator-nav__list--answer visibles-lg">
                    	<a href="#" class="pediator-nav__link pediator-nav__link--answer" style="display: none;" data-bind="visible: pactIsDone(), click: openServiceRulesPopup">?</a>
                    </li>
                    <li class="pediator-nav__list hidden-desktop">
                        <a href="#" class="pediator-nav__link" data-bind="visible: pactIsDone(), click: openServiceRulesPopup">Правила</a>
                    </li>
                    <li class="pediator-nav__list hidden-desktop">
                        <a href="<?=$this->createUrl('/site/logout')?>" class="pediator-nav__link">Выход</a>
                    </li>
                </ul>
            </nav>
            <div class="float-r">
                <div class="pediator-header__log margin-t22">
                    <div class="user-on <?php if ($this->action->id == 'profile'): ?> pediator-nav__list-active<?php endif; ?>">
                        <a href="<?=$this->createUrl('/specialists/pediatrician/default/profile')?>" class="pediator-header__name"><?php echo $formattedName; ?></a>
                        <div class="ava ava-pediator"><a href="<?=$this->createUrl('/specialists/pediatrician/default/profile')?>" class="js-ava__link ava__link"><img src="<?=Yii::app()->user->model->getAvatarUrl(Avatar::SIZE_SMALL)?>"></a></div>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <div class="layout-loose_hold clearfix">
        <?php echo $content; ?>
    </div>
</div>

<script type="text/html" id="js-tpl-popup-service-rules">
	<div id="rules" class="popup popup-add popup-add__photos js-popup">
      	<button title="Закрыть (Esc)" type="button" class="mfp-close mfp-close--style">×</button>
      	<div class="popup-add_hold">
        	<div class="popup-add__header clearfix"></div>
        	<div class="textalign-c">
          		<div class="font__title-s font__semi">Правила для участников</div>
        	</div>
        	<div class="popup-add__content">
          		<div class="margin-b20 clearfix">
            		<div class="popup-add__content-num">1</div>
            		<div class="popup-add__content-text">Ответы не должны содержать явную или скрытую рекламу лекарственных средств и медицинских клиник.</div>
          		</div>
          		<div class="margin-b20 clearfix">
            		<div class="popup-add__content-num">2</div>
            		<div class="popup-add__content-text">Ответы должны быть развернутыми и популярно раскрывать вопросы лечения и профилактики заболеваний, здорового образа жизни.</div>
          		</div>
          		<div class="margin-b20 clearfix">
            		<div class="popup-add__content-num">3</div>
           	 		<div class="popup-add__content-text">Ответы должны быть оригинальными/уникальным, только на основании собственного опыта и приобретенных знаний, и не являться плагиатом с других ресурсов.</div>
          		</div>
        		</div>
        		<div class="popup-add__footer-big">
          			<div class="textalign-c" data-bind="visible: !pactIsDone()">
                        <a href="#" class="btn btn-ml green-btn" data-bind="click: handlerAcceptServiceRules">Принимаю</a>
                    </div>
          			<div class="textalign-c" data-bind="visible: pactIsDone()">
            			<p class="font__semi font__color--grey-lighten" data-bind="text: 'Ознакомлен(а) ' + dateOfPactIsDone"></p>
          			</div>
        		</div>
      	</div>
	</div>
</script>

<?php

/**
 * @var CClientScript $cs
 */
$cs = Yii::app()->clientScript;

$specialistJSON = $this->getSpecialistJSON();

$cs->registerAMD(
    'specialist',
    [
        'Specialist'    => 'specialists/pediatrician/specialist',
        'ko'            => 'knockout'
    ],
    '
        ko.cleanNode(document.getElementById("js-pediatrician"));
        ko.applyBindings(new Specialist(' . $specialistJSON . '), document.getElementById("js-pediatrician"));
    '
);

?>

<?php $this->endContent(); ?>
