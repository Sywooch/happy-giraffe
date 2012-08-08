<?php
/* @var $this Controller
 * @var $test Test
 */
?>
<script type="text/javascript">
    var active_step = 1;
    var filled = false;
    var step_result = null;
    var result = new Array();
    var step_count = <?php echo $test->questionsCount ?>;
    var priority = null;

    $(function () {
        priority = new Array();
        <?php foreach ($test->testResults as $result): ?>
        priority[<?php echo $result->number ?>] = <?php echo empty($result->priority)?0:$result->priority ?>;
        <?php endforeach; ?>

        $('.RadioClass').attr('checked', false);

        $('#next-step-button').click(function () {
            filled = false;
            $('#step' + active_step + ' input').each(function () {
                if ($(this).is(':checked')) {
                    filled = true;
                    step_result = $('#step' + active_step + ' input').index($(this)) + 1;
                }
            });

            if (filled) {
                result.push(step_result);
//                console.log(result);

                if (step_count == active_step)
                    return ShowResult();
                $('#test-inner').animate({left:-active_step * 400}, 500);
                active_step++;
            } else {
                $('.error').show().fadeOut(2000);
            }
            return false;
        });

        $('#step0 .test_begin').click(function () {
            $('#step0').fadeOut(300, function () {
                $('#step1').fadeIn(300);
            });
            return false;
        });

        $(".q-options input").change(function () {
            step_result = $(this).attr('rel');
            result.push(step_result);

            if($(this).attr('data-last')=="1"){
                $('#step' + active_step).fadeOut(300, function () {
                    ShowResult();
                });
                active_step++;
                return;
            }
            NextStep();
            console.log(result);
            console.log(step_result);
        });

        $('.step-in a.yes_button').click(function(){
            result.push(2);
            NextStep();
            return false;
        });
        $('.step-in a.no_button').click(function(){
            result.push(1);
            NextStep();
            return false;
        });

        //$('.<?php //echo $test->css_class ?>').show();
    });

    function NextStep(){
        if (step_count == active_step){
            $('#step' + active_step).fadeOut(300, function () {
                ShowResult();
            });
            active_step++;
            return;
        }
        $('#step' + active_step).fadeOut(300, function () {
            $('#step' + active_step).fadeIn(300);
        });
        active_step++;
    }

    function ShowResult() {
        //console.log(result);
        
        var res_count = new Array();
        for (var i = 0; i <= result.length - 1; i++) {
            if (isNaN(res_count[result[i]]))
                res_count[result[i]] = 1;
            else
                res_count[result[i]]++;
        }

        //check result that has maximum answers
        <?php if ($test->NoPointResults()):?>
            <?php foreach ($test->testResults as $result): ?>
                if (ElementIsMax(res_count, <?php echo $result->number ?>)){
                    $('#result<?php echo $result->number ?>').fadeIn(300);
                    return;
                }
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach ($test->testResults as $result): ?>
            if (HasPoints(res_count, <?php echo $result->number ?>, <?php echo $result->points ?>)){
                $('#result<?php echo $result->number ?>').fadeIn(300);
                return;
            }
            <?php endforeach; ?>
        <?php endif ?>

        $('#unknown_result').fadeIn(300);
    }

    function ElementIsMax(arr, el_index){
        if (isNaN(arr[el_index]))
            return false;

        for (var key in arr) {
            var val = arr[key];
            if (key != el_index && val > arr[el_index])
                return false;

            //if equal then check priority
            if (key != el_index && val == arr[el_index]){
                if (priority[el_index] <= priority[key])
                    return false;
            }
        }
        return true;
    }

    function HasPoints(arr, el_index, points){
        if (isNaN(arr[el_index]))
            return false;

        if (arr[el_index] >= points)
            return true;
    }
</script>

<div class="test" id="<?php echo $test->css_class ?>">

<div class="step" id="step0">
    
	<img src="/images/test/<?php echo $test->id . '/' . $test->start_image ?>" alt=""/>
    
	<div class="step-in">
	
		<div class="btn"><button class="test_begin">ПРОЙТИ ТЕСТ</button></div>
		
	</div>
	
</div>

<?php
$i = 1;
foreach ($test->testQuestions as $question):?>

<div class="step" id="step<?php echo $i; $i++ ?>" style="display: none;">
    
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
						
						<label for="value<?php echo $i . $answer->number ?>"><input type="radio" name="v" rel="<?php echo $answer->number ?>" id="value<?php echo $i . $answer->number ?>" data-last="<?=$answer->islast?>" /> <span><?php
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
		
		<!--<div class="your_res"><?php echo $test->result_title ?>:<ins> <?php echo 'Неизвестен' ?></ins></div>
        <span class="your_rec">Рекомендации</span>-->
        
    </div>
</div>

<?php foreach ($test->testResults as $result): ?>
<div class="step" id="result<?php echo $result->number ?>" style="display: none;">
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
<br><br>
<div class="wysiwyg-content">
    <h1><?php echo $test->title ?></h1>
    <?php echo $test->text ?>
</div>