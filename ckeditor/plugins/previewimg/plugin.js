CKEDITOR.plugins.add('previewimg', {

    init:function (editor) {
        editor.on( 'instanceReady', function( ev )
        {
            // c примерами изображений
            $(".cke_toolbox").before('<span class="cke_previewimg" data-bind="foreach: uploadedImages"><span class="cke_previewimg_i" title="Название файла"> <img alt="" data-bind="attr: { src : preview }"><a href="javascript:void(0)" class="cke_previewimg_del" data-bind="click: $root.removeImage"></a></span></span>');
            ko.applyBindings(vm, $('.cke_previewimg').get(0));
        })
    }
});