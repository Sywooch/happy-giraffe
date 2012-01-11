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

        $(".RadioClass").change(function () {
            step_result = $(this).attr('rel');
            result.push(step_result);

            if (step_count == active_step)
                $('#step' + active_step).fadeOut(300, function () {
                    ShowResult();
                });
            $('#step' + active_step).fadeOut(300, function () {
                $('#step' + active_step).fadeIn(300);
            });
            active_step++;
        });

        //$('.hair_type_bl').show();
    });

    function ShowResult() {
//        console.log(result);
        
        var res_count = new Array();
        for (var i = 0; i <= result.length - 1; i++) {
            if (isNaN(res_count[result[i]]))
                res_count[result[i]] = 1;
            else
                res_count[result[i]]++;
        }

//        console.log(res_count);

        //check result that has maximum answers
        <?php foreach ($test->testResults as $result): ?>
            if (ElementIsMax(res_count, <?php echo $result->number ?>)){
                $('#result<?php echo $result->number ?>').fadeIn(300);
                return;
            }
        <?php endforeach; ?>

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
</script>

<div class="<?php echo $test->css_class ?>" id="step0">
    <img src="/images/test/<?php echo $test->id . '/' . $test->start_image ?>" alt=""/>
    <a href="#" class="test_begin">Пройти тест</a>
</div>

<?php
$i = 1;
foreach ($test->testQuestions as $question): ?>

<div class="<?php echo $test->css_class ?>" id="step<?php echo $i; $i++ ?>" style="display: none;">
    <img src="/images/test/<?php echo $test->id . '/' . $question->image ?>" alt="" title=""/>

    <div class="inner_bl">
        <form action="">
            <span class="question_title"><?php echo $question->name ?></span>
            <ul>
                <?php foreach ($question->testQuestionAnswers as $answer): ?>
                <li>
                    <input type="radio" name="v" rel="<?php echo $answer->number ?>" id="value<?php echo $i . $answer->number ?>" class="RadioClass"/>
                    <label for="value<?php echo $i . $answer->number ?>" class="RadioLabelClass"><?php
                        echo $answer->text ?></label>
                </li>
                <?php endforeach; ?>
            </ul>
        </form>
    </div>
</div>
<?php endforeach; ?>


<div class="<?php echo $test->css_class ?>" id="unknown_result" style="display: none;">
    <img src="/images/test/<?php echo $test->id ?>/<?php
        echo empty($test->unknown_result_image)?$test->result_image:$test->unknown_result_image ?>" alt="" title="" />
    <div class="result_bl">

        <span class="your_res"><?php echo $test->result_title ?>:<ins> <?php
            echo 'Неизвестен' ?></ins></span>
        <span class="your_rec">Рекомендации</span>
        <?php echo $test->unknown_result_text ?>
    </div>
</div>

<?php foreach ($test->testResults as $result): ?>
<div class="<?php echo $test->css_class ?>" id="result<?php echo $result->number ?>" style="display: none;">
    <img src="/images/test/<?php echo $test->id ?>/<?php
        echo empty($result->image)?$test->result_image:$result->image ?>" alt="" title="" />
    <div class="result_bl">

        <span class="your_res"><?php echo $test->result_title ?>: <ins><?php echo $result->name ?></ins></span>
        <span class="your_rec">Рекомендации</span>
        <?php echo $result->text ?>
        
    </div>
</div>
<?php endforeach; ?>

<div class="seo-text">
    <?php echo $test->text ?>
</div>