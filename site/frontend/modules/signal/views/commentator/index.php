<?php
/* @var $this CommentatorController
 */
$tasks = SeoTask::getCommentatorActiveTasks(2);
?>
<div class="seo-table">
    <ul class="task-list">

        <li>
            <div class="task" id="block-blog">
                <?php $this->renderPartial('_blog_posts', array('blog_posts' => $this->commentator->blogPosts())) ?>
            </div>
        </li>
        <li>
            <div class="task" id="block-club">
                <?php $this->renderPartial('_club_posts', array('club_posts' => $this->commentator->clubPosts())) ?>
            </div>
        </li>
        <li>
            <div class="task" id="block-comments">
                <?php $this->renderPartial('_comments') ?>
            </div>
        </li>
        <li>
            <div class="task">
                <span class="item-title">4. Хочу премию</span>
                <ul>
                    <?php if ($this->commentator->clubPostsCount() >= 2 && count($this->commentator->blogPosts()) >= 1): ?>
                        <?php foreach ($tasks as $task): ?>
                        <li>
                            <?php $this->renderPartial('_hint', array('task' => $task, 'block' => 1)) ?>
                        </li>
                        <?php endforeach; ?>
                        <?php if (count($tasks) < 3 && !SeoTask::commentatorHasActiveTasks(2)):?>
                            <?php $this->renderPartial('_hint', array('task' => null, 'block' => 2)) ?>
                        <?php endif ?>
                    <?php else: ?>
                        <a href="javascript:;" class="btn-g orange small disabled">Подсказка</a>
                    <?php endif ?>
                </ul>
            </div>
        </li>
    </ul>
</div>