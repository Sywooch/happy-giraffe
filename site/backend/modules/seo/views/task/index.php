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
        background: #adff2f;
    }
    .keywords .used{
        background: #5bbdff;
    }
</style>
<div class="clearfix" style="position: relative;">
    <div class="keywords">
        <?=CHtml::textField('keyword', ''); ?>

        <a href="javascript:void(0);" onclick="SeoModule.searchKeywords($(this).prev().val());">search</a>
        <div class="result">

        </div>
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
<script type="text/javascript">
    $(function () {
        SeoModule.refreshKeywordsDrag();

        $('#keyword').change(function () {
            SeoModule.searchKeywords($(this).val())
        });
        $('div.keyword_group').droppable({drop:SeoModule.dropToGroup});
        $('div.tasks').droppable({drop:SeoModule.dropToTask});
    });
</script>