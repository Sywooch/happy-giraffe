<?php
    $interestsIds = array();
    foreach ($action->data as $interest)
        $interestsIds[] = $interest['id'];

    $criteria = new CDbCriteria(array(
        'with' => array(
            'interests' => array(
                'with' => 'usersCount',
                'join' => 'JOIN interest__users_interests ON interest__users_interests.interest_id = interests.id',
            ),
        ),
    ));
    $criteria->addInCondition('interests.id', $interestsIds);

    $categories = InterestCategory::model()->findAll($criteria);
?>

<?php if (! empty($categories)): ?>
    <div class="box user-interests-box list-item">
        <div class="user-interests">

            <div class="box-title">Добавил интересы</div>

            <ul>
                <?php foreach ($categories as $category): ?>
                <li>
                    <div class="interest-cat">
                        <a href="">
                            <span class="img"><img src="/images/interest_icon_<?=$category->id?>.png" /></span>
                            <span class="text"><?=$category->title?></span>
                        </a>
                    </div>
                    <ul>
                        <?php foreach ($category->interests as $interest): ?>
                        <li><a class="interest"><?=$interest->title?><span><?=$interest->usersCount?></span></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>

            </ul>

        </div>
    </div>
<?php endif; ?>