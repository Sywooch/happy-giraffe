<!DOCTYPE html>
<html class="no-js">
  <head>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
  </head>
  <body class="body">
    <div class="layout-container">

      <div class="layout-wrapper">
        <div class="layout-wrapper_frame clearfix">
          <div class="layout-wrapper_hold clearfix">
            <div class="layout-content clearfix">
              <div class="margin-20">
                <h2>Аватары</h2><a href="#avatar-load" class="popup-a">Загрузка аватара</a><br><br><br><a href="#avatar-load-img" class="popup-a">Загрузка аватара. Загружено изображение</a><br><br><br>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div onclick="$('html, body').animate({scrollTop:0}, 'normal')" class="btn-scrolltop"></div>
    </div>
    <div class="popup-container display-n"> 
      <div id="avatar-load" class="popup popup-sign">
        <div class="popup-sign_hold">
          <div class="popup-sign_top">
            <div class="popup-sign_title">Главное фото</div>
          </div>
          <div class="popup-sign_cont popup-sign_cont__wide">
            <div class="popup-sign_img-upload">
              <div class="img-upload">
                <div class="img-upload_hold">
                  <div class="img-upload_top">
                    <div class="img-upload_btn-desc">
                      <div class="img-upload_t">Загрузите фотографию с компьютера</div>
                      <div class="img-upload_help">Поддерживаемые форматы: jpg и png</div>
                    </div>
                    <div class="file-fake">
                      <button class="btn-green-simple btn-m file-fake_btn">Обзор</button>
                      <input type="file" class="file-fake_inp">
                    </div>
                  </div>
                  <div class="img-upload_desc">
                    <div class="img-upload_help">Загружайте пожалуйста только свои фотографии</div>
                  </div>
                </div>
                <div class="img-upload_i-load">
                  <div style="width: 50%;" class="img-upload_i-load-progress"></div>
                </div>
                <div class="img-upload_uploaded"></div>
              </div>
            </div>
            <div class="popup-sign_col-ava popup-sign_col-ava__think">
              <div class="popup-sign_col-ava-t">Просмотр</div><a href="" class="ava ava__large"><span class="ico-status"></span><img alt="" src="" class="ava_img"/></a>
              <div class="popup-sign_ava-row display-n"><a href="" class="ava ava__middle"><span class="ico-status"></span><img alt="" src="" class="ava_img"/></a><a href="" class="ava ava__female"><span class="ico-status"></span><img alt="" src="" class="ava_img"/></a><a href="" class="ava ava__small ava__female"><span class="ico-status"></span><img alt="" src="" class="ava_img"/></a>
              </div>
              <div class="margin-t5">
                <div class="popup-sign_tx-help">Так будет выглядеть ваше главное фото <br>на страницах Веселого Жирафа</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /popup-sign-->
      <!-- .popup-sign-->
      <div id="avatar-load-img" class="popup popup-sign">
        <div class="popup-sign_hold">
          <div class="popup-sign_top">
            <div class="popup-sign_title">Главное фото</div>
          </div>
          <div class="popup-sign_cont popup-sign_cont__wide">
            <div class="popup-sign_img-upload">
              <div class="img-upload img-upload__uploaded">
                <!-- Блок загрузки изображения-->
                <div class="img-upload_hold">
                  <div class="img-upload_top">
                    <div class="img-upload_btn-desc">
                      <div class="img-upload_t">Загрузите фотографию с компьютера</div>
                      <div class="img-upload_help">Поддерживаемые форматы: jpg и png</div>
                    </div>
                    <div class="file-fake">
                      <button class="btn-green-simple btn-m file-fake_btn">Обзор</button>
                      <input type="file" class="file-fake_inp">
                    </div>
                  </div>
                  <div class="img-upload_desc">
                    <div class="img-upload_help">Загружайте пожалуйста только свои фотографии</div>
                  </div>
                </div>
                <!-- Заглушка при загрузке файла-->
                <div class="img-upload_i-load">
                  <!-- ширина для примера, ее нужно считать динамически-->
                  <div style="width: 50%;" class="img-upload_i-load-progress"></div>
                </div>
                <!-- Блок обрезки аватара-->
                <div class="img-upload_uploaded"><a href="" title="Удалить" class="img-upload_i-del powertip"></a><img id="jcrop_target" src="/new/images/example/w500-h376.jpg">
                  <script>
                    jQuery(function($){
                        var api;
                        $('#jcrop_target').Jcrop({
                          // start off with jcrop-light class
                          bgOpacity: 0.6,
                          bgColor: '#2c87c0',
                          addClass: 'jcrop-blue'
                        },function(){
                          api = this;
                          api.setSelect([130,65,130+350,65+285]);
                          api.setOptions({ bgFade: true });
                          api.ui.selection.addClass('jcrop-selection');
                        });
                    });
                  </script>
                </div>
              </div>
            </div>
            <div class="popup-sign_col-ava popup-sign_col-ava__think">
              <div class="popup-sign_col-ava-t">Просмотр</div><a href="" class="ava ava__large ava__female"><span class="ico-status"></span><img alt="" src="/new/images/example/ava-large2.jpg" class="ava_img"/></a>
              <div class="popup-sign_ava-row"><a href="" class="ava ava__middle ava__female"><span class="ico-status"></span><img alt="" src="/new/images/example/ava-large2.jpg" class="ava_img"/></a><a href="" class="ava ava__female"><span class="ico-status"></span><img alt="" src="/new/images/example/ava-large2.jpg" class="ava_img"/></a><a href="" class="ava ava__small ava__female"><span class="ico-status"></span><img alt="" src="/new/images/example/ava-large2.jpg" class="ava_img"/></a>
              </div>
              <div class="margin-t5">
                <div class="popup-sign_tx-help">Так будет выглядеть ваше главное фото <br>на страницах Веселого Жирафа</div>
              </div>
            </div>
          </div>
        </div>
        <div class="popup-sign_b clearfix margin-t20">
          <div class="float-r">
            <div class="btn-green-simple btn-l">Сохранить</div>
          </div>
        </div>
      </div>
      <!-- /popup-sign-->
    </div>
  </body>
</html>