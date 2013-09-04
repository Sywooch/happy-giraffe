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
                    <?= empty($club_id) ? 'chosenRubric' : 'chosenRubricClub' ?>: {}" data-placeholder="<?=empty($club_id)?'Выберите рубрику или создайте новую':'Выберите рубрику' ?>"></select>
            <?=$form->error($model, 'rubric_id')?>
        </div>
        <?php if (empty($club_id)):?>
            <div class="b-settings-blue_row-desc">Если вы не выберете рубрику, запись добавится в рубрику "Обо всем"</div>
        <?php endif ?>
    </div>
</div>