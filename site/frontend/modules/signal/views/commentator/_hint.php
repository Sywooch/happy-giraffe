<?php
/**
 * @var SeoTask $task
 */

if ($task === null):?>
<li><a href="/commentator/tasks/" onclick="CommentatorPanel.block=<?=$block ?>;" class="btn-g orange small fancy" data-theme="white-simple">Подсказка</a></li>
<?php else: ?>
<?php if ($task->status == SeoTask::STATUS_TAKEN):?>
    <li>
        <strong><?=$task->keywordGroup->keywords[0]->name ?></strong>
        <a href="javascript:;" class="icon-close" onclick="CommentatorPanel.CancelTask(<?=$task->id ?>, this)"></a>
        <input type="text" name="" class="placing" placeholder="Введите URL статьи">
        <a href="javascript:;" onclick="CommentatorPanel.Written(<?=$task->id ?>, this)" class="btn-green-small">ok</a>
    </li>
<?php else: ?>
    <li>
        <b>По подсказке:</b>
        <a href="<?=$task->article->url ?>" target="_blank"><?= $task->article->getArticleTitle() ?></a>
        <span class="done"><i class="icon"></i>Сделано</span>
        <span class="date"><?=Yii::app()->dateFormatter->format('dd MMM yyyy, HH:mm', strtotime($task->article->getArticle()->created)) ?></span>
    </li>
<?php endif ?>
<?php endif ?>