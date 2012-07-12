<div class="test" id="prikorm">

<div class="step splash">
    
	<img src="/images/test/<?php echo $test->id . '/' . $test->start_image ?>" alt=""/>
    
	<div class="step-in">
	
		<div class="btn"><button class="test_begin" onclick="Test.Start();">ПРОЙТИ ТЕСТ</button></div>
		
	</div>
	
</div>

<?php
$i = 1;
foreach ($test->testQuestions as $question):?>

<div class="step q" id="step<?php echo $i; $i++ ?>">
    
	<img src="/images/test/<?php echo $test->id . '/' . $question->image ?>" alt="" title=""/>

    <div class="step-in">
		<div class="question">
			<form action="">
				<div class="q-title"><?php echo $question->title ?></div>
					<a href="#" class="yes_button" data-answer="1" onclick="Test.Next(this); event.preventDefault();">Да</a>
					<a href="#" class="no_button" data-answer="0" onclick="Test.Next(this); event.preventDefault();">Нет</a>
			</form>
		</div>
    </div>
</div>

<?php endforeach; ?>


<?php foreach ($test->testResults as $result): ?>
<div class="step r" data-points="<?=$result->points ?>" data-number="<?=$result->number ?>">
    <img src="/images/test/<?php echo $test->id ?>/<?php
        echo empty($result->image)?$test->result_image:$result->image ?>" alt="" title="" />
    <div class="step-in">

        <div class="result">
								
			<div class="r-title">Результат</div>

            <div class="your_res"><?php echo $test->result_title ?>: <ins><?php echo $result->title ?></ins></div>

            <div class="r-text">

                <span class="your_rec">Рекомендации</span>
                <?php echo $result->text ?>
				
			</div>

		</div>
		
		<div class="btn"><button class="test_begin">ПРОЙТИ ТЕСТ</button></div>
		
    </div>
</div>
<?php endforeach; ?>
</div>

<div class="wysiwyg-content">
    <h1><?php echo $test->title ?></h1>
    <?php echo $test->text ?>
</div>