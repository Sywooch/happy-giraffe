<style>
    .questionInput{
        border: 1px solid black;
    }
    .addAnswer{
        display: inline-block;
        border: 1px solid green;
    }
    .answerInput {
        border: 1px solid black;
        margin-left: 30px;
    }
</style>

<script>
    $(document).ready(function(){

    });
</script>
<?php var_dump($questions); ?>
<?php foreach ($questions as $question): ?>
    <input class="questionInput" type="text" id="<?= $question->id; ?>" value="<?= $question->text; ?>" data-stage="<?= $question->stage; ?>"/> <a>Сохранить</a><br/>
    <?php foreach ($question->answers as $answer): ?>
        <input class="answerInput" type="text" id="<?= $answer->id?>" value="<?= $answer->text?>" /> <br/>
    <?php endforeach; ?>
<?php endforeach; ?>
