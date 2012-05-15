<div class="clearfix" style="position: relative;">
    <div class="keywords">
        <ul>
            <?php foreach ($tempKeywords as $tempKeyword): ?>
                <li id="keyword-<?=$tempKeyword->keyword->id ?>"><span><?php echo $tempKeyword->keyword->name ?></span>
                    <?php echo CHtml::link('add', '#', array('onclick'=>'return SeoModule.addToGroup(this);return false;')) ?></li>
            <?php endforeach; ?>

        </ul>
    </div>
    <div class="keyword_group">

    </div>
    <div class="urls">
        <input type="text" size="50">
        <input type="text" size="50">
        <input type="text" size="50">
        <input type="text" size="50">
        <input type="text" size="50">
    </div>

    <div class="add-group">
        <?php foreach (Yii::app()->user->getModel()->authors as $author): ?>
            <?php if (Yii::app()->authManager->checkAccess('author', $author->id)):?>
                <a href="javascript:void(0);" onclick="return SeoModule.addGroup(2, <?php echo $author->id ?>, 1);return false;">Journalist task (<?=$author->name ?>)</a>
            <br>
            <?php endif ?>
        <?php endforeach; ?>

    </div>
</div>

<div class="tasks">
    <?php $this->renderPartial('_tasks', compact('tasks')); ?>
</div>
<br><br>
<div class="history">
    <?php foreach ($success_tasks as $success_task): ?>
        <div>
            <?=$success_task->getText() ?>
        </div>
    <?php endforeach; ?>

</div>



<style type="text/css">
    .keywords, .keyword_group{
        float: left;
        width: 300px;
        min-height: 500px;
        border: 1px solid #000;
    }
    .add-group{
        position: absolute;
        top: 100px;
        left: 500px;
    }

    .keywords .active{
        background: #adff2f !important;
    }
    .status-0{
        background: #dbffdd;
    }
    .status-1{
        background: #aaffb0;
    }
    .status-2{
        background: #67ff70;
    }
    .status-3{
        background: #00ff01;
    }
    .status-4{
        background: #00cd0d;
    }
</style>