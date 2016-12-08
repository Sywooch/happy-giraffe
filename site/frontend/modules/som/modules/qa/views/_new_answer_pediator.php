<?php
 /**
  * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $data
  */
$specialistProfile = $data->author->specialistProfile;
 ?>
 <li class="b-answer__item">
    <div class="b-pediator-answer">
        <div class="b-pediator-answer__left">
            <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                <a href="<?=$data->author->getUrl()?>" class="ava ava--theme-pedaitor ava--medium ava--medium_male">
                    <img src="<?=$data->author->getAvatarUrl(40)?>" class="ava__img" />
                </a>
            </div>
        </div>
        <div class="b-pediator-answer__right b-pediator-answer__right--pink">
            <div class="b-answer__header b-answer-header">
            	<a href="<?=$data->author->getUrl()?>" class="b-answer-header__link"><?=$data->user->getFullName()?></a>
                <?=HHtml::timeTag($data, array('class' => 'b-answer-header__time'))?>
                <div class="b-answer-header__spezialisation"><?=$specialistProfile->getSpecsString()?></div>
                <div class="b-answer-header__box b-answer-header-box">
                    <div class="b-answer-header-box__item"><span class="b-text-color--grey b-text--size-12">Ответы 562</span>
                    </div>
                    <div class="b-answer-header-box__item"><span class="b-answer-header-box__roze"><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span>
                        <span
                        class="b-answer-header-box__ico"></span>
                            </span><span class="b-text-color--grey b-text--size-12">869</span>
                    </div>
                </div>
            </div>
            <div class="b-answer__body b-answer-body">
                <p class="b-pediator-answer__text">Добрый день. Конечно же можно. Но только нужно гулять чтобы была комфортная температура для ребенка, не кутайте его. и поменьше контактируйте с другими людьми. Можно подключить противовоспалительные препараты
                    для носа или противовирусные средства: Назаваль плюс, Анаферон, Гриппферон, Виферон. Можно выбрать любое из этих средств, только внимательно посмотрите на необходимую дозировку.</p><a href="javascript:voit(0);"
                class="b-text--link-color b-title--bold b-title--h9">Зеленые сопли у грудничка</a>
            </div>
        </div>
        <div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">
            <div class="b-pedaitor-answer__footer__item"><a href="javascript:voit(0);" class="b-answer-footer__age b-text--link-color">1 - 12</a>
            </div>
            <div class="b-pedaitor-answer__footer__item"><a href="javascript:voit(0);" class="b-answer-footer__comment">10</a>
                <button type="button" class="btn-answer btn-answer--theme-green btn-answer--active"><span class="btn-answer__num btn-answer__num--theme-green">Спасибо 98</span>
                </button>
            </div>
        </div>
    </div>
</li>