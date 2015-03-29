<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common_menu');
?>

    <div class="b-main clearfix">
        <div class="b-consult">
            <div class="b-consult-top">
                <div class="b-consult-top__t">
                    <h1 class="b-consult-top__title">Консультация</h1>
                    <div class="b-consult-top__text">
                        Обсуждаем проблему <br />
                        недостаток грудного молока
                    </div>
                </div>
            </div>
            <div class="b-main_cont">
                <div class="b-main_col-hold clearfix">
                    <?=$content?>
                </div>
            </div>
        </div>
    </div>

<?php $this->endContent(); ?>