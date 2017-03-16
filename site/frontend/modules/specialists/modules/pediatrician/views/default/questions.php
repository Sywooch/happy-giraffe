<?php

/**
 * @var LiteController $this
 * @var CActiveDataProvider $dp
 * @var boolean $authorizationIsDone
 * @var boolean $photoUploadIsDone
 * @var boolean $pactIsDone
 */
$this->pageTitle = 'Жираф педиатр - Вопросы';

?>

<div data-bind="template: {name: 'js-tpl-requirements'}, visible: !authorizationIsDone()"></div>

<script type="text/html" id="js-tpl-requirements">
<div class="pediator-container">
 	<div class="landing-question pediator">
    	<div class="statistik statistik--style">
      		<div class="font__title-sn font__semi margin-b15"> Чтобы отвечать на вопросы, необходимо:</div>
      		<div class="statistic-table--bg-green statistik__answer" data-bind="visible: !photoUploadIsDone()">
        		<p class="font-m font__color--grey">
        			<span class="statistik__num margin-r15">1</span>
        			<span class="margin-r15">Ваше фото для анкеты специалиста</span>
        			<span class="statistik__upload font__color--blue" style="cursor: default">
        				<span id="upload-link" style="cursor: pointer;">Загрузить фото</span>
						<one-step-avatar-uploader></one-step-avatar-uploader>
        			</span>
        		</p>
      		</div>
      		<div class="statistic-table--bg-green statistik__answer" data-bind="visible: !pactIsDone()">
        		<p class="font-m font__color--grey">
        			<span class="statistik__num margin-r15">2</span>
        			<span class="margin-r15">Ознакомиться с правилами сервиса</span>
        			<span class="statistik__upload font__color--blue" data-bind="click: openServiceRulesPopup">Читать правила</span>
        		</p>
      		</div>
    	</div>
  	</div>
</div>
</script>

<div class="landing-question pediator pediator-top" data-bind="css: {'pediator--opacity': !authorizationIsDone()}">

<?php

$this->widget('\site\frontend\modules\specialists\modules\pediatrician\widgets\SpecialistStatistic', [
    'viewName' => 'statistic'
]);

$this->widget('\site\frontend\modules\specialists\modules\pediatrician\widgets\ListView', [
    'htmlOptions' => ['class' => 'questions questions-modification'],
    'dataProvider' => $dp,
    'itemView' => '_question',
    'itemsTagName' => 'ul',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => [
        'class'           => 'LitePagerDots',
        'prevPageLabel'   => '&nbsp;',
        'nextPageLabel'   => '&nbsp;',
        'showPrevNext'    => TRUE,
        'showButtonCount' => 5,
        'dotsLabel'       => '<li class="page-points">...</li>'
    ]
]);
    
?>

</div>