<?php
/**
 * @var $this site\frontend\modules\iframe\controllers\DefaultController
 * @var string $content
 */

$this->beginContent('/layouts/parts/main');
$this->renderSidebarClip();
?>
<div class="b-col__container">
    <?=$content?>
    <aside class="b-main__aside b-col b-col--3 b-hidden-md">
        <?php $this->widget('site\frontend\modules\iframe\widgets\Statistic\CommonStatistic'); ?>
        <?php
            $this->widget('site\frontend\modules\som\modules\qa\widgets\usersTop\NewUsersTopWidget', [
                'titlePrefix'   => 'Педиатр',
                'onlyUsers'     => FALSE,
                'viewFileName'  => 'new_view_specialists',
            ]);
         ?>
        <?php
            $this->widget('site\frontend\modules\som\modules\qa\widgets\usersTop\NewUsersTopWidget', [
                'titlePrefix'   => 'Знаток',
                'viewFileName'  => 'new_view_users',
            ]);
        ?>
    </aside>
</div>
<?php $this->endContent(); ?>