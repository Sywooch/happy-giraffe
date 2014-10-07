<?php
$this->pageTitle = 'Как выбрать ' . $model->title_accusative;

$this->breadcrumbs = array(
    '<div class="ico-club ico-club__s ico-club__7"></div>' => array('/cook/default/index'),
    'Как выбрать продукты?' => array('/cook/choose/index'),
    //$model->category->title => $model->category->url,
    $model->title,
);
$imgSet = false;
if (isset($model->photo))
{
    $imgSet[] = $model->photo->getPreviewUrl(460, 460, Image::WIDTH) . ' 460w';
    $imgSet[] = $model->photo->getPreviewUrl(640, 640, Image::WIDTH) . ' 640w';
    $imgSet = implode(', ', $imgSet);
}
mb_internal_encoding("UTF-8");
$kak_viglyadat = (mb_substr($model->title_quality, -2, 2) == 'ки') ? 'Как выглядят' : 'Как выглядит';
?>
<div class="cook-choose">
    <div class="b-main_cont">
        <div class="b-main_col-wide">   
            <h1 class="heading-link-xxl heading-link-xxl__center">Как выбирать <?= $model->title_accusative ?></h1>
        </div>
    </div>
    <div class="b-main_row b-main_row__blue b-main_row__blue-quotes">
        <div class="b-main_cont">
            <div class="b-main_col-article b-main_col-article__center">
                <div class="wysiwyg-content textalign-c">
                    <?= $model->desc ?>
                </div>
            </div>
        </div>
    </div>
    <div class="b-main_row">
        <div class="b-main_cont">
            <div class="b-main_wide-phone textalign-c">
                <!-- При возможности используем адаптивные изображенияВ srcset указываем изображения и размеры -->
                <?php
                if ($imgSet)
                {
                    ?>
                    <img srcset="<?= $imgSet ?>" alt="<?= $model->title ?>">
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="b-main_row cook-choose-quality cook-choose-quality__good">
        <div class="b-main_cont">
            <div class="verticalalign-m-help"></div>
            <div class="wysiwyg-content verticalalign-m-el">
                <h2><?= $kak_viglyadat ?> <?= $model->title_quality ?></h2>
                <?= $model->desc_quality ?>
            </div>
        </div>
    </div>
    <div class="b-main_row cook-choose-quality cook-choose-quality__bad">
        <div class="b-main_cont">
            <div class="verticalalign-m-help"></div>
            <div class="wysiwyg-content verticalalign-m-el">
                <h2><?= $kak_viglyadat ?> <?= $model->title_defective ?></h2>
                <?= $model->desc_defective; ?>
            </div>
        </div>
    </div>
    <div class="b-main_row product-verif">
        <div class="b-main_cont">
            <div class="wysiwyg-content">
                <div class="product-verif_hold product-verif_hold__cook">
                    <h2>Как проверить <?= $model->title_check; ?></h2>
                    <?= $model->desc_check; ?>
                </div>
                <!--<ol>
                    <li>Не позволяйте продавцу сразу упаковать рыбу в пакет – сначала понюхайте её. Если запах «свежей рыбы» – берите. Если сомневаетесь – отложите покупку.</li>
                    <li>Дома проткните рыбу горячей спицей: если приятно пахнет – готовьте. Почувствовали неприятный запах – лучше выбросьте. Некачественная рыба очень опасна для здоровья.</li>
                </ol>-->
            </div>
        </div>
    </div>
    <div class="b-main_row">
        <div class="b-main_cont">
            <div class="b-main_col-article b-main_col-article__center">
                <div class="custom-likes">
                    <div class="custom-likes_slogan">Поделитесь с друзьями!</div>
                    <div class="custom-likes_in">
                        <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                        <div data-yasharel10n = "ru" data-yasharequickservices = "vkontakte,facebook,twitter,odnoklassniki,moimir" data-yasharetheme = "counter" data-yasharetype = "small" class = "yashare-auto-init"></div>
                    </div>
                </div>
                <?php $this->renderPartial('//banners/_cookChoose'); ?>
                <div class = "margin-b40"></div>
            </div>
        </div>
    </div>
</div>