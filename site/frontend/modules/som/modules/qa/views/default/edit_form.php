<?php

use site\frontend\modules\som\modules\qa\components\QaManager;

/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var site\frontend\modules\som\modules\qa\models\QaQuestion             $question
 */

$this->pageTitle = 'Редактировать вопрос';

?>

<mp-question-form params='question: <?= CJSON::encode($question->toJSON()); ?>, tags: <?= CJSON::encode($tagsData); ?>, chieldId: <?= $question->attachedChild; ?>'>

	<div class="preloader">
        <div class="preloader__inner">
            <div class="preloader__box"><span class="preloader__ico preloader__ico--xl"></span>
            </div><span class="preloader__text">Загрузка</span>
        </div>
    </div>

</mp-question-form>

<?php

\Yii::app()->clientScript->registerAMD(
    'Realplexor-reg',
    [
        'common',
        'comet'
    ],
    'comet.connect(\'http://' . \Yii::app()->comet->host . '\', \'' . \Yii::app()->comet->namespace . '\', \'' . QaManager::getEditedQuestionChannelId($question->id) . '\');'
);

?>
