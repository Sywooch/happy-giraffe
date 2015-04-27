<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common_menu');
?>

    <div class="b-main clearfix">
        <div class="b-consult">
            <a href="<?=$this->consultation->getUrl()?>">
              <div class="b-consult-top">
                <div class="b-consult-top__t">
                  <h1 class="b-consult-top__title">Консультация</h1>
                  <div class="b-consult-top__text">
                    Обсуждаем проблему <br>
                    недостатка грудного молока
                  </div>
                </div>
                <div class="b-consult-top__r">
                  <a href="http://apilak.ru/?utm_source=happy-giraffe&utm_medium=consultation&utm_campaign=2015" class="b-consult-top__link">
                    <img src="/lite/images/services/consult/medicine.png" alt="">
                  </a>
                  <a href="http://apilak.ru/?utm_source=happy-giraffe&utm_medium=consultation&utm_campaign=2015" class="b-consult-top__button">Узнать подробнее &gt;&gt;</a>
                </div>
              </div>
            </a>
            <div class="b-main_cont">
                <div class="b-main_col-hold clearfix">
                    <?=$content?>
                </div>
            </div>
        </div>
    </div>

<script language="javascript">

    var odinkod = {

        "type": "homepage"

    };

    var cbu = Math.round(Math.random() * 10000);

    var odinkodscript = document.createElement('script');

    odinkodscript.src = (document.location.protocol === 'https:' ? 'https://' : 'http://') +

    'cdn.odinkod.ru/tags/19355706-13d570.js?cbu='+ cbu +'';

    odinkodscript.async=true;

    document.body.appendChild(odinkodscript);

</script>

<?php $this->endContent(); ?>
