CKEDITOR.plugins.add('previewimg', {

    init:function (editor) {
        editor.on( 'instanceReady', function( ev )
        {
            // c примерами изображений
            $(".cke_toolbox").before('<span class="cke_previewimg"> <span class="cke_previewimg_i" title="Название файла"> <img alt="" src="/images/example/w200-h182-1.jpg"> <a href="" class="cke_previewimg_del"></a> </span> <span class="cke_previewimg_i" title="Название файла"> <img alt="" src="/images/example/w220-h165-1.jpg"> <a href="" class="cke_previewimg_del"></a> </span> </span>');
        })
    }
});