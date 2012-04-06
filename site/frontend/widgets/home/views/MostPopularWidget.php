<div class="box homepage-most">

    <div class="title"><span>Самое-самое</span> интересное</div>

    <ul>
        <?php foreach ($models as $model): ?>
            <li>
                <?php echo CHtml::link($model->name, $model->url); ?>
                <a href="<?=$model->url ?>"><?php
                $content = '';
                switch ($model->type->slug)
                {
                    case 'post':
                        if (preg_match('/src="([^"]+)"/', $model->post->text, $matches)) {
                            $content = '<img src="' . $matches[1] . '" alt="' . $model->name . '" width="200" />';
                        }
                        else
                        {
                            if (preg_match('/<p>(.+)<\/p>/Uis', $model->post->text, $matches2)) {
                                $content = strip_tags($matches2[1]);
                            }
                        }
                        break;
                    case 'travel':
                        if (preg_match('/src="([^"]+)"/', $model->travel->text, $matches)) {
                            $content = '<img src="' . $matches[1] . '" alt="' . $model->name . '" width="200" />';
                        }
                        else
                        {
                            if (preg_match('/<p>(.+)<\/p>/Uis', $model->travel->text, $matches2)) {
                                $content = strip_tags($matches2[1]);
                            }
                        }
                        break;
                    case 'video':
                        $video = new Video($model->video->link);
                        $content = '<img src="' . $video->preview . '" alt="' . $video->title . '" />';
                        break;
                }
                echo $content;
                ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>