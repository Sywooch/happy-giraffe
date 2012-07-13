<div class="test" id="test-pregnancy">


    <div class="step result-div" id="result<?php echo $result->number ?>">
        <img src="/images/test/<?php echo $test->id ?>/<?php
        echo empty($result->image) ? $test->result_image : $result->image ?>" alt="" title=""/>

        <div class="step-in">

            <div class="title">

                <h1><?=$test->title ?></h1>

            </div>

            <div class="result">

                <div class="r-title">Результат</div>

                <div class="r-text">

                    <?php echo $result->text ?>

                </div>

            </div>

            <div class="btn">
                <button class="test_begin" onclick="window.location = '/tester/<?=$test->slug?>/'; return false;">ПРОЙТИ ЕЩЕ РАЗ</button>
            </div>

        </div>
    </div>
</div>

<div class="wysiwyg-content">
    <h1><?php echo $test->title ?></h1>
    <?php echo $test->text ?>
</div>