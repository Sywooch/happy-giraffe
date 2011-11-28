<?php
/* @var $this Controller
 * @var $date int
 */
if (!Yii::app()->user->isGuest){
    $user_children = User::GetCurrentUser()->babies;
    if (empty($user_children))
        $baby_id = null;
    else
        $baby_id = $user_children[0]->id;
}
else
    $baby_id = null;
?>
<style type="text/css">
    .wid100 {
        width: 100px !important; /* !important обязателен */
    }

</style>

<script type="text/javascript">
    baby_id = '<?php echo $baby_id ?>';

    $(function() {
        $('div.nav li a').click(function(){
            if ($(this).attr('rel') == undefined){
                baby_id = null;
                cuSelRefresh({refreshEl: "#month-,#day-,#year-",visRows: 5,scrollArrows: true});
            }else{
                baby_id = $(this).attr('rel');
                cuSelRefresh({refreshEl: "#month-"+baby_id+",#day-"+baby_id+",#year-"+baby_id,visRows: 8,scrollArrows: true});
            }
            return false;
        });
    });

    $(function() {
        $('body').delegate('a.decline','click',function(){
            if (!$(this).hasClass('btn-red-small') && baby_id !== null){
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl("/vaccineCalendar/default/vote") ?>",
                    data: {vote:1,id:$(this).attr('rel'),baby_id:baby_id},
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.hasOwnProperty('success') && data.success){
                            DeleteActiveVote($(this).attr('rel'),baby_id);
                            ShowNewVote($(this).attr('rel'),baby_id,data);
                            $(this).addClass("btn-red-small");
                            $(this).removeClass("btn-gray-small");
                        }
                    },
                    'context': $(this)
                });
            }
            return false;
        });
        $('body').delegate('a.agree','click',function(){
            if (!$(this).hasClass('btn-yellow-small') && baby_id !== null){
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl("/vaccineCalendar/default/vote") ?>",
                    data: {vote:2,id:$(this).attr('rel'),baby_id:baby_id},
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.hasOwnProperty('success') && data.success){
                            DeleteActiveVote($(this).attr('rel'),baby_id);
                            ShowNewVote($(this).attr('rel'),baby_id,data);
                            $(this).addClass("btn-yellow-small");
                            $(this).removeClass("btn-gray-small");
                        }
                    },
                    'context': $(this)
                });
            }
            return false;
        });
        $('body').delegate('a.did','click',function(){
            if (!$(this).hasClass('btn-green-small') && baby_id !== null){
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl("/vaccineCalendar/default/vote") ?>",
                    data: {vote:3,id:$(this).attr('rel'),baby_id:baby_id},
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.hasOwnProperty('success') && data.success){
                            DeleteActiveVote($(this).attr('rel'),baby_id);
                            ShowNewVote($(this).attr('rel'),baby_id,data);
                            $(this).addClass("btn-green-small");
                            $(this).removeClass("btn-gray-small");
                        }
                    },
                    'context': $(this)
                });
            }
            return false;
        });
    });

    function DeleteActiveVote(vaccine_id,baby_id){
        $('.vc-'+vaccine_id+baby_id+' a').each(function(index) {
            if ($(this).hasClass('btn-red-small')) {
                $(this).removeClass('btn-red-small');
                $(this).addClass("btn-gray-small");
            }
            if ($(this).hasClass('btn-green-small')) {
                $(this).removeClass('btn-green-small');
                $(this).addClass("btn-gray-small");
            }
            if ($(this).hasClass('btn-yellow-small')) {
                $(this).removeClass('btn-yellow-small');
                $(this).addClass("btn-gray-small");
            }
        });
    }
    function ShowNewVote(vaccine_id,baby_id,data){
        $('.vc-'+vaccine_id+baby_id+' span.red').html(data.decline);
        $('.vc-'+vaccine_id+baby_id+' span.orange').html(data.agree);
        $('.vc-'+vaccine_id+baby_id+' span.green').html(data.did);
    }
</script>

<div class="section-banner">
    <img src="/images/section_banner_04.jpg" />
</div>

<div class="tabs vaccination-tabs">
    <div class="nav">
        <ul>
            <?php if (isset($user_children)):?>
                <?php foreach($user_children as $baby):?>
                    <li class="vaccine-date-<?php echo $baby->id ?> <?php if ($baby_id === $baby->id) echo ' active' ?>">
                        <a href="javascript:void(0);" onclick="setTab(this, <?php echo $baby->id ?>);" href="#" rel="<?php echo $baby->id ?>">
                            <div class="pic">
                                <img src="/images/baby_pic_01.jpg" />
                            </div>
                            <span><?php echo $baby->name ?></span>
                        </a>
                    </li>
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
        <?php $this->renderPartial('_view_empty',array('baby'=>null)); ?>
    </div>
</div>