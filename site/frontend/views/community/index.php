<div class="main">
    <div class="main-right">
        <div class="clubs-list">
            <?php $n = 0; ?>
            <?php foreach($categories as $title => $category): ?>
                <div class="category-title <?php echo $category['css'] ?>"><?php echo CHtml::encode($title); ?></div>
                <?php if(isset($category['items'])): ?>
                    <?php foreach($category['items'] as $subtitle => $subcount): ?>
                    <div class="subcategory <?php echo $category['css'] ?>">
                        <div class="subcategory-title"><?php echo $subtitle; ?></div>
                        <ul>
                            <?php for($i = 0;$i < $subcount; $i++): ?>
                                <li class="club-img <?php echo $category['css'] ?>">
                                    <a href="<?php echo $this->createUrl('community/list', array('community_id' => $communities[$n]->id)); ?>">
                                        <img src="/images/club_img_<?php echo $communities[$n]->position; ?>.png">
                                        <?php echo CHtml::encode($communities[$n]->title); ?>
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
                                    <?php echo CHtml::encode($communities[$n]->title); ?>
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
    <?php $this->widget('application.widgets.activity.CommunityPopularWidget'); ?>
</div>