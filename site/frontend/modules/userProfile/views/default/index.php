<?php
/**
 * @var LiteController $this
 * @var \User $user
 */
$this->pageTitle = $user->getFullName() . ' на Веселом Жирафе';
$this->breadcrumbs[] = $this->widget('Avatar', array(
    'user' => $user,
    'size' => \Avatar::SIZE_MICRO,
    'tag' => 'span',
), true);
?>

<?php $this->widget('site\frontend\modules\userProfile\widgets\UserSectionWidget', array('user' => $user, 'showToOwner' => true)); ?>

<div class="b-main_cont b-main_cont__broad">
    <div class="b-main_col-hold clearfix">
        <!--/////     -->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <?php if ($dataProvider->totalItemCount > 0): ?>
            <div class="heading-sm">Моя активность</div>
                <?php
                $this->widget('LiteListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => 'site.frontend.modules.posts.views.list._view',
                    'tagName' => 'div',
                    'itemsTagName' => false,
                    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
                    'pager' => array(
                        'class' => 'LitePager',
                        'maxButtonCount' => 10,
                        'prevPageLabel' => '&nbsp;',
                        'nextPageLabel' => '&nbsp;',
                        'showPrevNext' => true,
                    ),
                ));
                ?>
            <?php else: ?>
                <div class="cap-empty cap-empty__user-profile">
                    <div class="verticalalign-m-help"></div>
                    <div class="cap-empty_hold">
                        <div class="cap-empty_img"></div>
                        <div class="cap-empty_t">Пользователь пока не был активен на сайте </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <!--/////-->
        <!-- Сайд бар  -->
        <aside class="b-main_col-sidebar visible-md">
            <?php $this->widget('site\frontend\modules\userProfile\widgets\PhotoWidget', compact('user')); ?>
            <!-- виджет друзья-->
                <friends-section params="userId: <?= $user->id ?>"></friends-section>
            <!-- /виджет друзья-->
            <!-- виджет клубы-->
                <clubs-section params="userId: <?= $user->id ?>"></clubs-section>
            <!-- /виджет клубы-->

        </aside>
    </div>
</div>