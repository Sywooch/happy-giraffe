<!DOCTYPE html>
<html lang="ru" class="no-js">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title><?=$this->pageTitle?></title>
        <meta content="" name="description" />
        <meta content="" name="keywords" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="telephone=no" name="format-detection" />
        <meta name="HandheldFriendly" content="true" />

        <meta property="og:title" content="Happy Girafe" />
        <meta property="og:title" content="" />
        <meta property="og:url" content="" />
        <meta property="og:description" content="" />
        <meta property="og:image" content="" />
        <meta property="og:image:type" content="image/jpeg" />
        <meta property="og:image:width" content="500" />
        <meta property="og:image:height" content="300" />
        <meta property="twitter:description" content="" />
        <link rel="image_src" href="" />
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <script>
            (function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)
        </script>
    </head>

    <body class="page--bg add-question">
        <div class="js-overlay-menu overlay-menu"></div>
        <div class="js-overlay-user overlay-user"></div>
        <div class="b-layout b-container b-container--white b-container--style">
            <header class="header header-question header--question">
                <div class="header-question__item">
                    <div class="header-question__title">Задать вопрос</div>
                </div>
                <div class="header-question__item header-question__item--close">
                    <button type="button" class="header-question__close"></button>
                </div>
            </header>
            <main class="b-main">
                 <div class="b-main__inner">
                    <div class="b-col__container">
                        <div class="b-col b-col--6 b-col-sm--10 b-col-xs">
                            <div class="add-question">
                            <?=$content?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php $this->renderPartial('//_new_footer'); ?>
        </div>
    </body>
</html>