<?php
/**
 * @var CommunityContest $contest
 */
?>

<div id="popup-contest-rule" class="popup-contest popup-contest__<?=$contest->cssClass?>">
    <a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-720 float-r">

            <div class="b-settings-blue">

                <div class="contest-rule">
                    <div class="heading-title">Правила конкурса</div>
                    <?=$contest->rules?>
                    <?php if ($contest->status == CommunityContest::STATUS_ACTIVE): ?>
                        <div class="textalign-c clearfix">
                            <a href="<?=$contest->getParticipateUrl()?>" class="btn-green btn-h46 fancy">Принять участие!</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </div>
</div>