<?php
/**
 * @var string $displayType
 */
$this->pageTitle = 'Жираф педиатр - Ответы';
?>

<?php switch ($displayType) {?>
<?php case 'accessDenied':?>
        <div class="landing-question pediator pediator-top"">
            <div class="questions margin-t0">
               Доступ запрещен!
            </div>
        </div>
<?php break; ?>
<?php case 'noAnswers':?>
        <div class="landing-question pediator textalign-c">
    	<div class="pediator-ico-shape pediator-ico-shape--style"></div>
    	<p class="font-m color-grey-l margin-b40">
    		Нет вопросов для отображения.
    	</p>
    	<a href="/pediatrician/questions/" class="btn b-btn--xl green-btn">Перейти к вопросам</a>
    </div>
<?php break; ?>
<?php default:?>
        <div class="landing-question pediator pediator-top"">
            <div class="questions margin-t0">
               Контент не определен!
            </div>
        </div>
<?php break; ?>
<?php } ?>

