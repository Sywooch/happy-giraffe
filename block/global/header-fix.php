<!-- header-fix-->
      <script>
        $(document).ready(function () {
            $(window).scroll(function () {
                var contanerScroll = $(window).scrollTop();
                var header = $('.header');
                if (contanerScroll > header.height() + header.offset().top) {
                    $('.header-fix').fadeIn(400);
                } else {
                    $('.header-fix').fadeOut(400);
                }
            });
        });
      </script>
      <div class="header-fix">
        <div class="header-fix_hold clearfix"><a href="" class="header-fix_logo"></a>
          <div class="header-fix_dropin"><a href="" class="header-fix_dropin-a"><span href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></span><span class="header_i-arrow"></span></a>
            <!-- header-drop-->
            <div class="header-drop">
              <div class="header-menu clearfix">
                <ul class="header-menu_ul">
                  <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__profile"><span href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></span></span><span class="header-menu_tx">Анкета</span></a></li>
                  <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__family"></span><span class="header-menu_tx">Семья</span></a></li>
                  <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__blog"></span><span class="header-menu_tx">Блог</span></a></li>
                  <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__photo"></span><span class="header-menu_tx">Фото</span></a></li>
                  <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__favorite"></span><span class="header-menu_tx">Избранное</span></a></li>
                  <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__settings"></span><span class="header-menu_tx">Настройки</span></a></li>
                  <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__logout"></span><span class="header-menu_tx"></span></a></li>
                </ul>
              </div>
              <!-- header-drop_b-->
              <div class="header-drop_b">
                <div class="float-r margin-t3"><a href="">Жираф рекомендует</a></div>
                <div class="heading-small">Мои клубы <span class="color-gray"> (5)</span></div>
                <div class="club-list club-list__small clearfix">
                  <ul class="club-list_ul clearfix">
                    <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/2-w50.png" alt="" class="club-list_img"/></span></a></li>
                    <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/5-w50.png" alt="" class="club-list_img"/></span></a></li>
                    <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/7-w50.png" alt="" class="club-list_img"/></span></a></li>
                    <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/8-w50.png" alt="" class="club-list_img"/></span></a></li>
                    <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/9-w50.png" alt="" class="club-list_img"/></span></a></li>
                  </ul>
                </div>
              </div>
              <!-- /header-drop_b-->
            </div>
            <!-- /header-drop -->
          </div>
          <div class="header-fix-menu">
            <ul class="header-menu_ul clearfix">
              <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">прямой эфир</span></a></li>
              <li class="header-fix-menu_li active"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">мой жираф</span><span class="header-fix-menu_count">256</span></a></li>
              <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">диалоги</span></a></li>
              <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">друзья</span><span class="header-fix-menu_count">2</span></a></li>
              <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">сигналы</span></a></li>
              <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">успехи</span></a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- /header-fix-->