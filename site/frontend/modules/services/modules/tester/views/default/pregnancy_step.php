<?
//print_r($question->title);
?>
<div class="test" id="test-pregnancy">


    <div class="step question-div">

        <img src="/images/test/<?php echo $test->id . '/' . $question->image ?>" alt="" title=""/>

        <div class="step-in">
            <div class="question">
                <form id="step" method="post">
                    <input type="hidden" name="question[id]" value="<?=$question->id?>">
                    <input type="hidden" name="question[number]" value="<?=$question->number?>">

                    <div class="q-title"><?=$question->title ?></div>
                    <ul class="q-options">
                        <?php foreach ($question->testQuestionAnswers as $answer): ?>
                        <li>
                            <label for="value<?=$answer->id?>" onclick="$(this).find('input').attr('checked', true);$('#step').submit();">
                                <input
                                    type="radio"
                                    name="question[answer_id]"
                                    value="<?=$answer->id?>"
                                    id="value<?=$answer->id?>

                                    "/>
                                <span><?=$answer->text ?></span>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                </form>
            </div>
        </div>
    </div>


    <div class="wysiwyg-content">
        <h1><?php echo $test->title ?></h1>
        <?php echo $test->text ?>
    </div>
</div>