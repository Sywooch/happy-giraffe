<style type="text/css">
    .keywords, .keyword_group, .tasks{
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
    .tasks li{
        padding-bottom: 10px;
    }
    .keywords .active{
        background: #adff2f !important;
    }
</style>
<div class="clearfix" style="position: relative;">
    <div class="keywords">
        <ul>
            <?php foreach ($tempKeywords as $tempKeyword): ?>
                <li><span><?php echo $tempKeyword->keyword->name ?></span> <?php echo CHtml::link('add', '#',
                    array('onclick'=>'SeoModule.addToGroup(this, '.$tempKeyword->keyword->id.');')) ?></li>
            <?php endforeach; ?>

        </ul>
    </div>
    <div class="keyword_group">

    </div>
    <div class="tasks">
        <?php $this->renderPartial('_tasks',array('tasks' => $tasks)); ?>
    </div>

    <div class="add-group">
        <a href="javascript:void(0);" onclick="SeoModule.addGroup();">Add Group</a>
    </div>
</div>