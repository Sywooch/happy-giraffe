<?php
/* @var $this CommentatorController
 */
?><div class="seo-table">
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

    </ul>
</div>