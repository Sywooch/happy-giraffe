<?php if (! empty($club_id)):?>
<div class="b-settings-blue_row clearfix">
    <label for="" class="b-settings-blue_label">Подфорум</label>

    <div class="w-400 float-l">
        <div class="chzn-itx-simple js-select-rubric">
            <select name="<?=CHtml::activeName($model, 'forum_id')?>" id="<?=CHtml::activeId($model, 'forum_id')?>" data-bind="options: rubricsList,
                    value: selectedRubric,
                    optionsText: function(rubric) {
                        return rubric.title;
                    },
                    optionsValue: function(rubric) {
                        return rubric.id;
                    },
                    chosenRubricClub: {}" data-placeholder="Выберите подфорум"></select>
            <?=$form->error($model, 'forum_id')?>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="b-settings-blue_row clearfix">
        <label for="" class="b-settings-blue_label">Рубрика</label>

        <div class="w-400 float-l">
            <div class="chzn-itx-simple js-select-rubric">
                <select name="<?=CHtml::activeName($model, 'rubric_id')?>" id="<?=CHtml::activeId($model, 'rubric_id')?>" data-bind="options: rubricsList,
                    value: selectedRubric,
                    optionsText: function(rubric) {
                        return rubric.title;
                    },
                    optionsValue: function(rubric) {
                        return rubric.id;
                    },
                    chosenRubric: {}" data-placeholder="Выберите рубрику или создайте новую"></select>
                <?=$form->error($model, 'rubric_id')?>
            </div>
            <div class="b-settings-blue_row-desc">Если вы не выберете рубрику, запись добавится в рубрику "Обо всем"</div>
        </div>
    </div>
<?php endif; ?>
