<div class="questions-categories">
    <?php
        $title       = isset($title) ? $title : null;
        $titlePrefix = isset($titlePrefix) ? $titlePrefix : null;
        $viewFileName = isset($viewFileName) ? $viewFileName : 'view';

        $this->widget('site\frontend\modules\som\modules\qa\widgets\usersTop\UsersTopWidget', [
            'authorId'      => $member,
            'titlePrefix'   => $titlePrefix,
            'title'         => $title,
            'viewFileName'  => $viewFileName,
        ]);
    ?>
</div>