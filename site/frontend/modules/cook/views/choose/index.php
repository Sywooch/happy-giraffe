<?php
$this->pageTitle = 'Как выбрать продукты?';

$this->breadcrumbs = array(
    '<div class="ico-club ico-club__s ico-club__7"></div>' => array('/cook/default/index'),
    'Как выбрать продукты?',
);
?>
<div class="cook-choose">
    <div class="b-main_cont">
        <div class="b-main_col-wide">   
            <h1 class="heading-link-xxl heading-link-xxl__center">Как выбирать продукты</h1>
        </div>
    </div>
    <div class="b-main_row b-main_row__blue b-main_row__blue-quotes">
        <div class="b-main_cont">
            <div class="b-main_col-article b-main_col-article__center">
                <div class="wysiwyg-content">
                    <p>Задумываетесь ли вы о том, как правильно выбрать продукты в супермаркете, магазине или на рынке? Скорее всего – да. Каждый здравомыслящий человек понимает, что «он есть то, что он ест», а потому к выбору продуктов относится серьёзно.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="b-main_row">
        <div class="b-main_cont">
            <?php $this->renderPartial('_menu', array('categories' => $categories)); ?>
        </div>
    </div>
    <div class="b-main_row">
        <div class="b-main_cont margin-b40">
            <div class="b-main_col-article b-main_col-article__center">
                <div class="wysiwyg-content">
                    <p>Реалии нашей жизни таковы, что продавцы и производители продуктов в погоне за большей прибылью стараются снизить себестоимость продукции, а это чревато тем, что в состав привычныхнам изделий попадают некачественные компоненты: натуральные красители заменяются химическими «аналогами», аромат создаётся искусственными добавками, чтобы продукт хранился дольше –добавляются консерванты и так далее.</p>
                    <p>Хорошо, когда состав продукта написан на упаковке, а если это рынок и нужно выбрать овощи, фрукты, зелень или ягоды? Как выбрать спелый и полезный плод? Ведь, чтобы скоропортящийсятовар хранился подольше, продавцы могут орошать его специальными растворами, предотвращающими порчу, однако пользы для здоровья от оросителей, конечно, нет, а вот вред они принестимогут серьёзный.</p>
                    <p>Поэтому мы решили создать своеобразный справочник по выбору качественных продуктов. Заходите в любой из разделов и ищите то, что вы собираетесь купить в ближайшее время. Читайтекороткие статьи – практические советы, конкретные, простые и понятные, которые подскажут вам, как выбрать спелый фрукт, прекрасное вино и другие нужные вам продукты.</p>
                    <p>Мы очень рассчитываем на вашу помощь. Возможно, у вас есть какие-то свои хитрости, касающиеся того, как правильно выбрать любимые продукты, или, наоборот, вам хочется узнать, каквыбрать какой-то конкретный товар. Пишите комментарии – мы с большим вниманием относимся к вашим просьбам, пожеланиям, советам и обещаем очень быстро отреагировать на все вашипослания новыми интересными материалами.</p>
                </div>
            </div>
        </div>
    </div>
</div>