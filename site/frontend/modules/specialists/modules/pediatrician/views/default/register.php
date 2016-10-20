<?php
/**
 * @var site\frontend\modules\specialists\modules\pediatrician\controllers\DefaultController $this
 * @var \site\frontend\modules\specialists\models\SpecialistSpecialization[] $specs
 */

$this->pageTitle = 'Регистрация детского врача';
?>

<div class="pediator__header-box">
    <div class="pediator-container">
        <div class="pediator__header-left">
            <div class="display-ib">
                <div class="pediator__header-senks"></div>
                <div class="pediator__header-descr">Отвечай и получай<br>«Спасибо» от родителей!</div>
            </div>
        </div>
        <div class="pediator__header-right">
            <div class="display-ib">
                <div class="pediator__header-top"></div>
                <div class="pediator__header-descr">Войди в ТОП-100<br>лучших педиатров</div>
            </div>
        </div>
    </div>
</div>
<div class="pediator-container">
    <div class="landing-question pediator">
        <div class="pediator-step__wrapper">
            <pediatrician-register-form params='specializations: <?=\HJSON::encode($specs)?>'></pediatrician-register-form>
        </div>
    </div>
</div>