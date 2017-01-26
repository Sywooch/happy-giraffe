<?php

/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 */

$this->pageTitle = 'Задать вопрос';

?>

<mp-question-form params='tags: <?= CJSON::encode($tagsData); ?>'>

	<div class="preloader">
        <div class="preloader__inner">
            <div class="preloader__box"><span class="preloader__ico preloader__ico--xl"></span>
            </div><span class="preloader__text">Загрузка</span>
        </div>
    </div>

</mp-question-form>