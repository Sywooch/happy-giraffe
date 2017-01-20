<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var site\frontend\modules\som\modules\qa\models\QaQuestion             $question
 */

$this->pageTitle = 'Редактировать вопрос';

?>

<mp-question-form params='question: <?= CJSON::encode($question->toJSON()); ?>'>

	<div class="preloader">
        <div class="preloader__inner">
            <div class="preloader__box"><span class="preloader__ico preloader__ico--xl"></span>
            </div><span class="preloader__text">Загрузка</span>
        </div>
    </div>

</mp-question-form>