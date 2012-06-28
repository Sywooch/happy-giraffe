<div class="test" id="test-pregnancy">

    <div class="step splash">

        <img src="/images/test/<?php echo $test->id . '/' . $test->start_image ?>" alt=""/>

        <div class="step-in">

            <div class="title">

                <h1><?=$test->title ?></h1>

            </div>

            <div class="text">Онлайн-тест на беременность – прекрасная возможность подтвердить или опровергнуть свои мысли по поводу возможной беременности, особенно если под рукой нет экспресс-теста,
                а приём гинеколога состоится не раньше чем завтра.
            </div>

            <div class="btn">
                <form method="POST">
                <button class="test_begin" onclick="Test.Start();">ПРОЙТИ ТЕСТ</button>
                </form>
            </div>

        </div>

    </div>

</div>

<div class="seo-text">
    <h1 class="summary-title"><?php echo $test->title ?></h1>
    <?php echo $test->text ?>
</div>