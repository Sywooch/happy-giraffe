<?php
/**
 * @var \LiteController $this
 * @var \CActiveDataProvider $dp
 */
$this->pageTitle = 'Консультация';
?>

<div class="b-main_col-article">
    <div class="b-consult-bubble">
        <div class="b-consult-bubble-text">Грудное молоко – естественное и наиболее правильное питание для новорождённого. Но иногда у молодых мам возникают проблемы с грудным вскармливанием: молока становится меньше, чем требуется малышу, либо оно совсем пропадает. Причины могут быть разные, но самыми частыми считаются кесарево сечение, позднее и неправильное прикладывание к груди, преждевременные роды, стресс и переутомление. Как понять, хватает ли ребёнку молока? Как наладить процесс лактации, чтобы малыш всегда был сыт? Как правильно давать грудь?``</div>
        <div class="b-consult-bubble-who">
            Ответы на эти и другие вопросы вы можете узнать у <br />
            специалиста по грудному вскармливанию, врача-педиатра, <br />
            кандидата медицинских наук, научного сотрудника. <br />
            Научно-исследовательского клинического института педиатрии ГБОУ ВПО РНИМУ им. Н.И. Пирогова <br />
            Морозова Сергея Леонидовича.
        </div>
    </div>
    <div class="b-consult-qa comments__buble">
        <div class="b-consult-qa-title">Вопросы и ответы</div>

        <?php $this->widget('LiteListView', array(
            'dataProvider' => $dp,
            'itemView' => '_question',
            'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
        )); ?>
    </div>
</div>
<div class="b-main_col-sidebar visible-md">
    <div class="b-consult-specialist">
        <div class="b-consult-specialist__img"><img src="/lite/images/services/consult/consult-man.png" alt=""></div>
        <div class="b-consult-specialist__name">Морозов Сергей Леонидович</div>
        <div class="b-consult-specialist__position">Врач педиатр</div>
        <div class="b-consult-specialist__edu">

            Кандидат медицинских наук, <br />
            Научный сотрудник Научно-исследовательского <br />
            клинического института педиатрии <br />
            ГБОУ ВПО РНИМУ им. Н.И. Пирогова
        </div><a href="<?=$this->createUrl('create', array('slug' => $this->consultation->slug))?>" class="b-consult-button">Задать вопрос        </a>
    </div>
</div>