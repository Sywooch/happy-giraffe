if (!RedactorPlugins) var RedactorPlugins = {};

RedactorPlugins.btnvideo = {
        init: function ()
        {
            this.buttonAdd('btnvideo', 'Вставить видео', this.videoShowBtn);
        },
        // Изменена и расширена стандартная функция videoShow
        videoShowBtn: function()
        {

            this.opts.modal_video = String()
            + ' <div class="redactor-modal_in"> '
                + ' <div class="postAdd"> '
                    + ' <div class="postAdd_video-serv"> '
                        + ' <div class="postAdd_video-serv-t">URL видео:</div> '
                        + ' <div class="postAdd_video-serv-hold"> '
                            + ' <div class="postAdd_video-serv-desc">Поддерживаемые сервисы:</div> '
                            + ' <div class="postAdd_video-serv-i postAdd_video-serv-i__youtube"></div> '
                            + ' <div class="postAdd_video-serv-i postAdd_video-serv-i__rutube"></div> '
                            + ' <div class="postAdd_video-serv-i postAdd_video-serv-i__vimeo"></div> '
                        + ' </div> '
                    + ' </div> '
                    + ' <div class="inp-valid"> '
                        + ' <input type="text" placeholder="Вставьте ссылку на видео" class="itx-gray"> '
                    +' </div> '
                +' </div> '
            +' </div> '
            //this.videoShow();

            this.selectionSave();

            this.modalInit(this.opts.curLang.video, this.opts.modal_video, 730, $.proxy(function()
            {
                // Кнопка добавления видео в редактор. В верстке нету.
                $('#redactor_insert_video_btn').click($.proxy(this.videoInsert, this));

                setTimeout(function()
                {
                    $('#redactor_insert_video_area').focus();

                }, 200);

            }, this));
            
            this.$redactorModal.addClass('redactor-modal redactor-modal__video');
            console.log(this.$redactorModal)
        }
};