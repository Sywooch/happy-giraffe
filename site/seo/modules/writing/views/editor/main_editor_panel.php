<?php
/* @var $this Controller
 * @var $tempKeywords TempKeyword[]
 * @var $editors SeoUser[]
 */
Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<div class="clearfix">

    <div class="seo-table table-tasks">
        <div class="table-box">
            <table>
                <tr>
                    <th><input type="checkbox" id="select-all"/></th>
                    <th class="col-1">Ключевое слово или фраза</th>
                    <th>Частота</th>
                    <th>Действие</th>
                </tr>
                <?php foreach ($tempKeywords as $tempKeyword): ?>
                <tr data-id="<?=$tempKeyword->keyword->id; ?>" id="keyword-<?=$tempKeyword->keyword->id ?>"<?php if (!empty($tempKeyword->keyword->group)) echo ' style="display:none;"' ?>>
                    <td>
                        <input type="checkbox" data-id="<?=$tempKeyword->keyword->id; ?>"/>
                    </td>
                    <td class="col-1">
                        <div class="item">
                            <span><?=$tempKeyword->keyword->name ?></span>
                        </div>
                    </td>
                    <td><span><?=$tempKeyword->keyword->getFreqIcon() ?></span> <span class="freq-val"><?= $tempKeyword->keyword->getRoundFrequency() ?></span></td>
                    <td>
                        <ul style="width: 100px;display: inline;">
                            <div class="admins redactor js-editor-list-button">
                                <a href="javascript:;" class="btn-redactor" onclick="$(this).next().toggle();"></a>
                                <ul class="js-editor-list" style="display:none;z-index: 100;">
                                    <?php foreach ($editors as $editor): ?>
                                        <li><a href="javascript:;" onclick="TaskDistribution.transferKeyword(<?=$tempKeyword->keyword_id ?>, <?= $editor->id ?>);"><?=$editor->name ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </ul>
                        <a href="javascript:;" class="icon-remove" onclick="TaskDistribution.removeFromSelected(this)"></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="admins redactor js-editor-list-button" style="margin-left: 614px;">
            <a href="javascript:;" class="btn-redactor" onclick="$(this).next().toggle();"></a>
            <ul class="js-editor-list" style="display:none;z-index: 100;">
                <?php foreach ($editors as $editor): ?>
                    <li><a href="javascript:;" onclick="TaskDistribution.transferKeywords(<?= $editor->id ?>);"><?=$editor->name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
</div>
<script type="text/javascript">
    $('#select-all').click(function(event) {
        var selected = this.checked;
        $(':checkbox').each(function () {    this.checked = selected; });
    });
</script>