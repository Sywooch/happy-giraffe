<div id="test-navel">

<div class="step splash">

    <img src="/images/test/4/bg_test_navel.jpg"/>

    <div class="step-in">
        <div class="title">
            <h1><?=$test->title ?></h1>
        </div>
        <div class="text">С помощью данного теста вы сможете узнать, в норме ли пупочная ранка у вашего малыша на всех стадиях её заживления</div>
        <div class="btn">
            <button onclick="Test.Start();">УЗНАТЬ</button>
        </div>
    </div>
</div>




<?php foreach ($test->testQuestions as $question): ?>

<div class="step q" data-id="<?=$question->id?>">
    <img src="/images/test/<?php echo $test->id . '/' . $question->image ?>"/>

    <div class="step-in">
        <div class="question">
            <div class="q-number">Вопрос <span></span></div>
            <div class="q-title"><?=$question->title?></div>
            <ul class="q-options">
                <?php foreach ($question->testQuestionAnswers as $answer): ?>
                    <li>
                        <label for="answer<?=$answer->id?>">
                            <input
                                id="answer<?=$answer->id?>"
                                type="radio"
                                name="answer<?=$answer->id?>"
                                data-next="<?=$answer->next_question_id?>"
                                data-points="<?=$answer->points?>"
                                onchange="Test.Next(this);"
                            />
                            <span><?=$answer->text?></span>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?php endforeach; ?>




<?php foreach ($test->testResults as $result): ?>
<div class="step r" data-points="<?=$result->points?>">
    <img src="/images/test/<?php echo $test->id . '/' . $result->image ?>"/>
    <div class="step-in">
        <div class="result">
            <div class="r-title">Совет</div>
            <div class="r-text">
                <?php $img = ($result->points<0) ? "alert" : "ok"; ?>
                <p><img src="/images/img_test_navel_<?=$img?>.png" align="center"/></p>
                <p class="<?php if($result->points<0){echo "red";} ?>">
                    <?=$result->text?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>
</div>

<div class="wysiwyg-content">
    <?php echo $test->text ?>
</div>
