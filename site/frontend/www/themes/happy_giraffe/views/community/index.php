<div class="main">
    <div class="main-right">
        <div class="clubs-list">
            <?php $n = 0; ?>
            <?php foreach($categories as $title => $category): ?>
                <div class="category-title <?php echo $category['css'] ?>"><?php echo $title; ?></div>
                <?php if(isset($category['items'])): ?>
                    <?php foreach($category['items'] as $subtitle => $subcount): ?>
                    <div class="subcategory <?php echo $category['css'] ?>">
                        <div class="subcategory-title"><?php echo $subtitle; ?></div>
                        <ul>
                            <?php for($i = 0;$i < $subcount; $i++): ?>
                                <li class="club-img <?php echo $category['css'] ?>">
                                    <a href="<?php echo $this->createUrl('community/list', array('community_id' => $communities[$n]->id)); ?>">
                                        <img src="/images/club_img_<?php echo $communities[$n]->position; ?>.png">
                                        <?php echo $communities[$n]->name; ?>
                                    </a>
                                </li>
                                <?php $n++; ?>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <ul>
                        <?php for($i = 0;$i < $category['count']; $i++): ?>
                            <?php if(!isset($communities[$n])) continue; ?>
                            <li class="club-img <?php echo $category['css'] ?>">
                                <a href="<?php echo $this->createUrl('community/list', array('community_id' => $communities[$n]->id)); ?>">
                                    <img src="/images/club_img_<?php echo $communities[$n]->position; ?>.png">
                                    <?php echo $communities[$n]->name; ?>
                                </a>
                            </li>
                            <?php $n++; ?>
                        <?php endfor; ?>
                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="side-right">
    <div class="popular-topics">
        <div class="block-in">
            <div class="top-count">ТОР <b>5</b></div>
            <div class="title">Популярные темы</div>
            <ul>
                <?php foreach($top5 as $data): ?>
                <li>
                    <?php echo CHtml::link(CHtml::tag('b', array(), $data->name), $data->url); ?>
                    <div class="date"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $data->created); ?></div>
                    <div class="content">
                    <?php
                        $content = '';
                        switch ($data->type->slug)
                        {
                            case 'post':
                                if (preg_match('/src="([^"]+)"/', $data->post->text, $matches)) {
                                    $content = '<img src="' . $matches[1] . '" alt="' . $data->name . '" width="150" />';
                                }
                                else
                                {
                                    if (preg_match('/<p>(.+)<\/p>/Uis', $data->post->text, $matches2)) {
                                        $content = strip_tags($matches2[1]);
                                    }
                                }
                                break;
                            case 'travel':
                                if (preg_match('/src="([^"]+)"/', $data->travel->text, $matches)) {
                                    $content = '<img src="' . $matches[1] . '" alt="' . $data->name . '" width="150" />';
                                }
                                else
                                {
                                    if (preg_match('/<p>(.+)<\/p>/Uis', $data->travel->text, $matches2)) {
                                        $content = strip_tags($matches2[1]);
                                    }
                                }
                                break;
                            case 'video':
                                $video = new Video($data->video->link);
                                $content = '<img src="' . $video->preview . '" alt="' . $video->title . '" />';
                                break;
                        }
                        echo $content;
                    ?>

                        <?php
                            /*$p = new CHtmlPurifier();
                            $p->options = array(
                                'URI.AllowedSchemes'=>array(
                                    'http' => true,
                                    'https' => true,
                                ),
                                'HTML.Nofollow' => true,
                                'HTML.TargetBlank' => true,
                                'HTML.AllowedComments' => array('more' => true),

                            );
                            echo $p->purify(Str::truncate($data->preview, 300));
                            if($data->type->slug == 'video')
                            {
                                $video = new Video($data->video->link);
                                echo CHtml::image($video->preview);
                            }*/
                        ?>
                    </div>
                    <div class="meta">
                        <div class="fast-rank">
                            <span><?php echo Rating::model()->countByEntity($data); ?></span>
                            рейтинг
                        </div>
                        <span class="views">Просмотров: <?php echo PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $data->url), true); ?></span><br>
                        <span>Комментариев: <?php echo $data->commentsCount; ?></span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>