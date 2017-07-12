<?php
$partner = \Yii::app()->session->get("partner");
?>
<footer class="footer footer-iframe footer--style">
    <div class="b-container b-container--padding">
        <ul class="footer__list">
<!--            <li class="footer__li"><a href="--><?//=$this->createUrl('/pages/default/page', array('view' => 'advertising'))?><!--" class="footer__link">Реклама</a></li>-->
<!--            <li class="footer__li"><a href="--><?//=$this->createUrl('/pages/default/page', array('view' => 'useragreement'))?><!--" class="footer__link">Правила сервиса</a></li>-->
            <li class="footer__li footer-app__li">
                Приложения для:
                <div class="footer-app-links">
                    <a class="footer-app-links__android" href="#"></a>
                    <a class="footer-app-links__ios" href="#"></a>
                </div>
            </li>
        </ul>
    </div>
</footer>