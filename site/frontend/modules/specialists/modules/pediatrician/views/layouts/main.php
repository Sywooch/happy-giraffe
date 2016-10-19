<?php

/**
 * @var LiteController $this
 * @var string $content
 */
$this->beginContent('//layouts/lite/common');

?>

<div id="js-pediatrician">
    <div class="layout-header">
        <header class="header header__redesign pediator-header clearfix">
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
                    <li class="pediator-nav__list">
                    	<a href="#" class="pediator-nav__link">Пульс</a>
                    </li>
                    <li class="pediator-nav__list<?php if ($this->action->id == 'answers'): ?> pediator-nav__list-active<?php endif; ?>">
                        <a href="<?=$this->createUrl('/specialists/pediatrician/default/answers')?>" class="pediator-nav__link">Мои ответы</a>
                    </li>
                    <li class="pediator-nav__list">
                    	<a href="#" class="pediator-nav__link">Статистика</a>
                    </li>
                    <li class="pediator-nav__list">
                    	<a href="#" class="pediator-nav__link">Рейтинг</a>
                    </li>              
                    <li class="pediator-nav__list" style="display: none;" data-bind="visible: pactIsDone(), click: openServiceRulesPopup">
                    	<a href="#" class="pediator-nav__link pediator-nav__link--answer">?</a>
                    </li>
                </ul>
            </nav>
            <div class="float-r">
                <div class="pediator-header__log margin-t22">
                    <div class="user-on">
                        <a href="<?=$this->createUrl('/specialists/pediatrician/default/profile')?>" class="pediator-header__name"><?=Yii::app()->user->model->getFullName()?></a>
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
            		<div class="popup-add__content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
          		</div>
          		<div class="margin-b20 clearfix">
            		<div class="popup-add__content-num">2</div>
            		<div class="popup-add__content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
          		</div>
          		<div class="margin-b20 clearfix">
            		<div class="popup-add__content-num">3</div>
           	 		<div class="popup-add__content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
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
