<div class="test" id="test-pregnancy">

<div class="step splash">

	<img src="/images/test/<?php echo $test->id . '/' . $test->start_image ?>" alt=""/>

    <div class="step-in">

        <div class="title">

            <h1><?=$test->title ?></h1>

        </div>

        <div class="text">Онлайн-тест на беременность – прекрасная возможность подтвердить или опровергнуть свои мысли по поводу возможной беременности, особенно если под рукой нет экспресс-теста, а приём гинеколога состоится не раньше чем завтра.</div>

        <div class="btn"><button class="test_begin" onclick="Test.Start();">ПРОЙТИ ТЕСТ</button></div>

    </div>

</div>

<?php
$i = 1;
foreach ($test->testQuestions as $question):?>

<div class="step question-div" id="step<?php echo $i; $i++ ?>" style="display: none;">

	<img src="/images/test/<?php echo $test->id . '/' . $question->image ?>" alt="" title=""/>

    <div class="step-in">
		<div class="question">
			<form action="">
				<div class="q-title"><?php echo $question->title ?></div>

				<?php if ($test->type == Test::TYPE_YES_NO):?>
					<a href="#" class="yes_button">Да</a>
					<a href="#" class="no_button">Нет</a>
				<?php else: ?>
				<ul class="q-options">
				<?php foreach ($question->testQuestionAnswers as $answer): ?>
					<li>

						<label for="value<?php echo $i . $answer->number ?>">
                            <input
                               data-points="<?php echo $answer->points ?>"
                               onchange="Test.Next(this);"
                               type="radio"
                               name="v"
                               rel="<?php echo $answer->number ?>"
                               id="value<?php echo $i . $answer->number ?>"
                               data-last="<?=$answer->islast?>" /> <span><?php
							echo $answer->text ?></span></label>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif ?>

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
<div class="step result-div" id="result<?php echo $result->number ?>" style="display: none;" data-points="<?=$result->points ?>">
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

		<div class="btn"><button class="test_begin" onclick="Test.Restart(); return false;">ПРОЙТИ ЕЩЕ РАЗ</button></div>

    </div>
</div>
<?php endforeach; ?>
</div>

<?php $this->widget('application.widgets.serviceSocial.serviceSocialWidget', array(
    'service' => Service::model()->findByPk(9),
    'image' => '/images/test/3/bg_test_pregnancy.jpg',
    'description' => 'Онлайн-тест на беременность – прекрасная возможность подтвердить или опровергнуть свои мысли по поводу возможной беременности, особенно если под рукой нет экспресс-теста, а приём гинеколога состоится не раньше чем завтра.',
    'counter_title'=>array('Тест на беременность прошли уже', array('пользователь','пользователя','пользователей'))
)); ?>

<br><br>
<div class="wysiwyg-content">
    <h1><?php echo $test->title ?></h1>
    <?php echo $test->text ?>
</div>