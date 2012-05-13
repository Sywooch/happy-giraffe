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
                <li id="keyword-<?=$tempKeyword->keyword->id ?>"><span><?php echo $tempKeyword->keyword->name ?></span> <?php echo CHtml::link('add', '#',
                    array('onclick'=>'return SeoModule.addToGroup(this);')) ?></li>
            <?php endforeach; ?>

        </ul>
    </div>
    <div class="keyword_group">
        <?php //$this->renderPartial('_tasks',array('tasks' => $tasks)); ?>
    </div>

    <div class="add-group">
        <a href="javascript:void(0);" onclick="return SeoModule.addGroup(1);">Moder task</a><br>
        <a href="javascript:void(0);" onclick="return SeoModule.addGroup(2);">Journalist task</a>
    </div>
</div>