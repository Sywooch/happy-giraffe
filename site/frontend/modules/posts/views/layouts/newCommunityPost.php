<?php
$this->beginContent('//layouts/lite/community');
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
			<community-add params="forumId: <?= $this->forum->id ?>, clubSubscription: <?= CJSON::encode(UserClubSubscription::subscribed(Yii::app()->user->id, $this->club->id)) ?>, clubId: <?= $this->club->id ?>, subsCount: <?= (int)UserClubSubscription::model()->getSubscribersCount($this->club->id) ?>"></community-add>

            <div class="menu-simple">
                <ul class="menu-simple_ul">
                    <?php
                    foreach ($this->forum->rubrics as $rubric) {
                        // Если рубрика корневая
                        if (!$rubric->parent) {
                            $sub = '';
                            if(!empty($rubric->childs)) {
                                $sub = '<ul class="menu-simple_ul">';
                                foreach ($rubric->childs as $child) {
                                    $content = HHtml::link($child->title, $child->url, array('class' => 'menu-simple_a'));
                                    $class = 'menu-simple_li' . (($this->rubric && $this->rubric->id == $child->id) ? ' active' : '');
                                    $sub .= CHtml::tag('li', array('class' => $class), $content);
                                }
                                $sub .= '</ul>';
                            }
                            $content = HHtml::link($rubric->title, $rubric->url, array('class' => 'menu-simple_a')) . $sub;
                            $class = 'menu-simple_li' . (($this->rubric && $this->rubric->id == $rubric->id) ? ' active' : '');
                            echo CHtml::tag('li', array('class' => $class), $content);
                        }
                    }
                    ?>
                </ul>
            </div>
        </aside>
    </div>
</div>
<?php
$this->endContent();
