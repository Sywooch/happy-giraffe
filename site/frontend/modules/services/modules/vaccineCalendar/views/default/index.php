<?php
/* @var $this HController
 * @var $date int
 */
$this->meta_description = 'Календарь прививок для детей поможет маме проконтролировать правильность вакцинации её ребенка, узнать, какая прививка идет следующей по графику, и познакомиться с вакцинами, которые могут быть использованы';

if (!Yii::app()->user->isGuest){
    $user_children = User::GetCurrentUserWithBabies()->babies;
    if (empty($user_children))
        $baby_id = null;
    else
        $baby_id = $user_children[0]->id;
}
else
    $baby_id = null;
?>
<?php
$cs = Yii::app()->clientScript;
$js = "
    baby_id = '".$baby_id."';

    $(function() {
        $('#baby div.nav li a').click(function(){
            if ($(this).attr('rel') == undefined){
                baby_id = null;
            }else{
                baby_id = $(this).attr('rel');
            }
            return false;
        });
    });
";
    $cs->registerScript('vaccine_calendar', $js);
?>

<div class="section-banner">
    <img src="/images/section_banner_04.jpg" />
</div>
<?php $i=1; ?>
<div class="tabs vaccination-tabs">
    <div class="nav">
        <ul>
            <?php if (isset($user_children)):?>
                <?php foreach($user_children as $baby):?>
                    <li class="vaccine-date-<?php echo $baby->id ?> <?php if ($baby_id === $baby->id) echo ' active' ?>">
                        <a href="javascript:void(0);" onclick="setTab(this, <?php echo $baby->id ?>);" href="#" rel="<?php echo $baby->id ?>">
                            <div class="pic">
<?php if ($i % 2 == 0): ?>
                                    <img src="/images/baby_pic_02.jpg" />
<?php else: ?>
                                <img src="/images/baby_pic_01.jpg" />
<?php endif; ?>
                            </div>
                            <span><?php echo $baby->name ?></span>
                        </a>
                    </li>
                <?php $i++ ?>
                <?php endforeach ?>
            <?php endif ?>
            <li class="empty-vaccine-date<?php if ($baby_id === null) echo ' active' ?>">
                <a href="javascript:void(0);" onclick="setTab(this, 0);">
                    <div class="box-in">
                        <span>Укажите дату<br/>рождения</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <?php if (isset($user_children)):?>
        <?php foreach($user_children as $baby):?>
            <div class="tab-box tab-box-<?php echo $baby->id ?>" <?php if ($baby_id === $baby->id) echo ' style="display:block;"' ?>>
                <?php $this->renderPartial('_view',array('baby'=>$baby)); ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>

    <div class="empty-vaccine-date tab-box tab-box-0" <?php if ($baby_id === null) echo ' style="display:block;"' ?>>
        <?php $this->renderPartial('_view_empty',array('baby'=>null, 'date'=> new DateForm())); ?>
    </div>
</div>