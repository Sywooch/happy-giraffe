<?php
/**
 * @var site\frontend\modules\specialists\modules\pediatrician\controllers\DefaultController $this
 * @var \site\frontend\modules\specialists\models\SpecialistSpecialization[] $specs
 */

$this->pageTitle = 'Регистрация детского врача';
?>

<div class="layout-loose_hold clearfix">
    <div class="pediator-container">
        <div class="landing-question pediator">
            <div class="pediator-step__wrapper">
                <pediatrician-register-form params='specializations: <?=\HJSON::encode($specs)?>'></pediatrician-register-form>
            </div>
        </div>
    </div>
</div>