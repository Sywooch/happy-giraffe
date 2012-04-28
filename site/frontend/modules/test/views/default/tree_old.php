<div class="test" id="<?php echo $test->css_class ?>">

<div class="step" id="step0">

	<img src="/images/test/<?php echo $test->id . '/' . $test->start_image ?>" alt=""/>

    <div class="step-in">

        <div class="title">

            <h1><?=$test->title ?></h1>

        </div>

        <div class="text">Онлайн тест на беременность – прекрасная возможность подтвердить или опровергнуть свои мысли по поводу возможной беременности, особенно, если под рукой нет экспресс-теста, а приём гинеколога состоится не раньше чем завтра</div>

        <div class="btn"><button class="test_begin" onclick="Test.Start();">ПРОЙТИ ТЕСТ</button></div>

    </div>

</div>

<?php
$i = 1;
foreach ($test->testQuestions as $question):?>

<div class="step question-div" id="step<?php echo $i; $i++ ?>" style="display: none;" data-number="<?php echo $question->number ?>">

	<img src="/images/test/<?php echo $test->id . '/' . $question->image ?>" alt="" title=""/>

    <div class="step-in">
		<div class="question">
			<form action="">
				<div class="q-title"><?php echo $question->title ?></div>

				<ul class="q-options">
				<?php foreach ($question->testQuestionAnswers as $answer): ?>
					<li>

						<label for="value<?php echo $i . $answer->number ?>">
                            <input onchange="Test.Next(this);"
                               <?php if (!empty($answer->next_question_id)) echo 'data-next-question="'.$answer->next_question->number.'" '?>
                                <?php if (!empty($answer->result_id)) echo 'data-result="'.$answer->result->number.'" '?>
                               type="radio" name="v" id="value<?php echo $i . $answer->number ?>" /> <span><?= $answer->text ?></span>
                        </label>
					</li>
					<?php endforeach; ?>
				</ul>

			</form>
		</div>
    </div>
</div>

<?php endforeach; ?>

<div class="step" id="unknown_result" style="display: none;">
    <img src="/images/test/<?php echo $test->id ?>/<?php
        echo empty($test->unknown_result_image)?$test->result_image:$test->unknown_result_image ?>" alt="" title="" />
    <div class="step-in">

		<div class="result">

			<div class="r-title">Результат</div>

			<div class="r-text">

				<?php echo $test->unknown_result_text ?>

			</div>

		</div>

		<div class="btn"><button class="test_begin">ПРОЙТИ ТЕСТ</button></div>

    </div>
</div>

<?php foreach ($test->testResults as $result): ?>
<div class="step result-div" id="result<?php echo $result->number ?>" style="display: none;" data-number="<?php echo $result->number ?>" >
    <img src="/images/test/<?php echo $test->id ?>/<?php
        echo empty($result->image)?$test->result_image:$result->image ?>" alt="" title="" />
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

		<div class="btn"><button class="test_begin" onclick="document.location.reload();">ПРОЙТИ ЕЩЕ РАЗ</button></div>

    </div>
</div>
<?php endforeach; ?>
</div>

<div class="seo-text">
    <h1 class="summary-title"><?php echo $test->title ?></h1>
    <?php echo $test->text ?>
</div>