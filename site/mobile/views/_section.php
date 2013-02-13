<?php
    $section = null;

    switch (get_class($data)) {
        case 'BlogContent':
        case 'CommunityContent':
            if ($data->isFromBlog) {
                $section = array(
                    'title' => 'Личный блог',
                    'url' => Yii::app()->createUrl('/community/user', array('user_id' => $data->author_id)),
                );
            } elseif ($data->rubric->community->mobileCommunity !== null) {
                $section = array(
                    'title' => $data->rubric->community->mobileCommunity->title,
                    'url' => $data->rubric->community->mobileCommunity->url,
                );
            }
            break;
        case 'CookRecipe':
            $section = array(
                'title' => $data->typeString,
                'url' => Yii::app()->createUrl('/community/index', array('type' => $data->type, 'section' => $data->section)),
            );
            break;
    }
?>

<?php if ($section !== null): ?>
    <div class="margin-b10">
        <?=CHtml::link($section['title'], $section['url'], array('class' => 'text-small'))?>
    </div>
<?php endif; ?>