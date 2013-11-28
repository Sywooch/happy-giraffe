<?php
/**
 * @var CommunityContest $contest
 */
?>
<div id="popup-contest-prize" class="popup-contest popup-contest__birth2">
    <a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">

        <div class="b-settings-blue">

            <div class="contest-prizes">
                <div class="heading-title">Призы конкурса</div>
                <div class="contest-prizes_i clearfix">
                    <div class="contest-prizes_l">
                        <div class="contest-prizes_img">
                            <img src="/images/contest/club/birth2/prize-1-big.jpg" alt="">
                        </div>
                        <div class="place place-1-1"></div>
                    </div>
                    <div class="contest-prizes_r">
                        <div class="contest-prizes_i-top">
                            <span class="contest-prizes_heart"></span>
                            <span class="contest-prizes_i-t">Подарочный сертификат  <strong>Л'Этуаль </strong> на 1000 рублей </span>
                        </div>
                        <div class="contest-prizes_desc">
                            <p>ПОДАРОК ДЛЯ САМЫХ КАПРИЗНЫХ - номинал 1000 рублей! </p>
                        </div>
                    </div>
                </div>

                <div class="contest-prizes_i clearfix">
                    <div class="contest-prizes_l">
                        <div class="contest-prizes_img">
                            <img src="/images/contest/club/birth2/prize-2-big.jpg" alt="">
                        </div>
                        <div class="place place-2-3"></div>
                    </div>
                    <div class="contest-prizes_r">
                        <div class="contest-prizes_i-top">
                            <span class="contest-prizes_heart"></span>
                            <span class="contest-prizes_i-t">Подарочный сертификат <strong>Л'Этуаль </strong> на 500 рублей и 2 геля для купания <strong>BABE</strong> </span>
                        </div>
                    </div>
                </div>

                <div class="contest-prizes_bottom clearfix">
                    <div class="contest-prizes_bottom-tx clearfix">
                        <span class="ico-giraffe-r"></span>
								<span class="">
									Будьте активны! Ваш рассказ будет лучшим.
								</span>
                    </div>
                    <?php if ($contest->status == CommunityContest::STATUS_ACTIVE): ?>
                        <a href="<?=$contest->getParticipateUrl()?>" class="btn-green btn-h46 fancy">Принять участие!</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</div>