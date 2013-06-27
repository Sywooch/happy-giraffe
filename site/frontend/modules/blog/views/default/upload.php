<?php
Yii::app()->clientScript
    ->registerScript('file-upload2', 'var FileAPI = { debug: false, pingUrl: false }', CClientScript::POS_HEAD)
    ->registerScriptFile('/javascripts/upload/FileAPI.min.js', CClientScript::POS_BEGIN)
    ->registerScriptFile('/javascripts/upload/FileAPI.id3.js', CClientScript::POS_BEGIN)
    ->registerScriptFile('/javascripts/upload/FileAPI.exif.js', CClientScript::POS_BEGIN)
;

?>
<script type="text/javascript">
    (function(){
        var cache = {};

        this.tmpl = function tmpl(str, data){
            // Figure out if we're getting a template, or if we need to
            // load the template - and be sure to cache the result.
            var fn = !/\W/.test(str) ?
                cache[str] = cache[str] ||
                    tmpl(document.getElementById(str).innerHTML) :

                // Generate a reusable function that will serve as a template
                // generator (and which will be cached).
                new Function("obj",
                    "var p=[],print=function(){p.push.apply(p,arguments);};" +

                        // Introduce the data as local variables using with(){}
                        "with(obj){p.push('" +

                        // Convert the template into pure JavaScript
                        str
                            .replace(/[\r\t\n]/g, " ")
                            .split("<%").join("\t")
          .replace(/((^|%>)[^\t]*)'/g, "$1\r")
          .replace(/\t=(.*?)%>/g, "',$1,'")
          .split("\t").join("');")
          .split("%>").join("p.push('")
          .split("\r").join("\\'")
      + "');}return p.join('');");

    // Provide some basic currying to the user
    return data ? fn( data ) : fn;
  };
})();
</script>

<script id="b-file-ejs" type="text/ejs">
		<div id="file-<%=FileAPI.uid(file)%>" class="js-file b-file b-file_<%=file.type.split('/')[0]%>">
            <div class="js-left b-file__left">
            <img src="<%=icon[file.type.split('/')[0]]||icon.def%>" width="32" height="32" style="margin: 2px 0 0 3px"/>
            </div>
            <div class="b-file__right">
                <div><a class="js-name b-file__name"><%=file.name%></a></div>
            <div class="js-info b-file__info">size: <%=(file.size/FileAPI.KB).toFixed(2)%> KB</div>
            <div class="js-progress b-file__bar" style="display: none">
                <div class="b-progress"><div class="js-bar b-progress__bar"></div></div>
                </div>
                </div>
            <i class="js-abort b-file__abort" title="abort">&times;</i>
            </div>
</script>

<script id="b-layer-ejs" type="text/ejs">
    <div class="b-layer">
        <div class="b-layer__h1"><%=file.name%></div>
        <div class="js-img b-layer__img"></div>
        <div class="b-layer__info">
            <%
            FileAPI.each(info, function(val, key){
                if( Object.prototype.toString.call(val) == '[object Object]' ){
                    var sub = '';
                    FileAPI.each(val, function (val, key){ sub += '<div>'+key+': '+val+'</div>'; });
                    if( sub ){
                        %><%=key%><div style="margin: 0 0 5px 20px;"><%=sub%></div><%
                    }
                } else {
                    %>
                    <div><%=key%>: <%=val%></div>
                <%
                }
            });
            %>
        </div>
    </div>
</script>

<div id="preview">

</div>

<div id="oooops" style="display: none; margin: 10px; padding: 10px; border: 2px solid #f60; border-radius: 4px;">
    Увы, ваш браузер не поддерживает html5 и flash,
    поэтому смотреть тут нечего, а iframe не даёт всей красоты :]
</div>

<div id="drop-zone" class="b-dropzone" style="display: none;width: 200px;height: 200px;">
    <div class="b-dropzone__bg"></div>
    <div class="b-dropzone__txt">Drop files there</div>
</div>

<div class="b-button js-fileapi-wrapper">
    <div class="b-button__text">Multiple</div>
    <input id="upload-files-multiple" name="files" class="b-button__input" type="file" multiple />
</div>

<script type="text/javascript">
    $(function() {
        if( !(FileAPI.support.cors || FileAPI.support.flash) ){
            $('#oooops').show();
            $('#buttons-panel').hide();
        }

        if( FileAPI.support.dnd ){
            $('#drop-zone').show();
            $(document).dnd(function (over){}, function (files){
                onFiles(files);
            });
        }

        $('#upload-files-multiple').on('change', function (evt){
            var files = FileAPI.getFiles(evt);
            onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });


        var FU = {
            files: [],
            index: 0,
            active: false,

            add: function (file){
                FU.files.push(file);

                if( /^image/.test(file.type) ){
                    FileAPI.Image(file).preview(35).rotate('auto').get(function (err, img){
                        if( !err ){
                            FU._getEl(file, '.js-left')
                                .addClass('b-file__left_border')
                                .html(img)
                            ;
                        }
                    });
                }
            },

            getFileById: function (id){
                var i = FU.files.length;
                while( i-- ){
                    if( FileAPI.uid(FU.files[i]) == id ){
                        return	FU.files[i];
                    }
                }
            },

            showLayer: function (id){
                var $Layer = $('#layer-'+id), file = this.getFileById(id);

                if( !$Layer[0] ){
                    $Layer = $('<div/>').appendTo('body').attr('id', 'layer-'+id);
                }

                $Layer.css('top', $(window).scrollTop() + 30);

                FileAPI.getInfo(file, function (err, info){
                    $Layer
                        .click(function (){ $(document).click(); })
                        .html(tmpl($('#b-layer-ejs').html(), {
                            file: file
                            , info: $.extend(err ? {} : info, { size: (file.size/1024).toFixed(3) + ' KB' })
                        }))
                    ;

                    if( /image/i.test(file.type) ){
                        if( err ){
                            $Layer.find('.js-img').html('Ooops.');
                        }
                        else {
                            FileAPI.Image(file).preview(300).rotate('auto').get(function (err, img){
                                $Layer.find('.js-img').append(img);
                            });
                        }
                    } else {
                        $Layer.find('.js-img').remove();
                    }

                    $(document).off('click.layer keyup.layer').one('click.layer keyup.layer', function (evt){
                        $Layer.remove();
                    });
                });
            },

            start: function (){
                if( !FU.active && (FU.active = FU.files.length > FU.index) ){
                    FU._upload(FU.files[FU.index]);
                }
            },

            abort: function (id){
                var file = this.getFileById(id);
                if( file.xhr ){
                    file.xhr.abort();
                }
            },

            _getEl: function (file, sel){
                var $el = $('#file-'+FileAPI.uid(file));
                return	sel ? $el.find(sel) : $el;
            },

            _upload: function (file){
                if( file ){
                    file.xhr = FileAPI.upload({
                        url: '/ajaxSimple/uploadPhoto/',
                        imageAutoOrientation: true,
                        files: { file: file },
                        upload: function (){
                            FU._getEl(file).addClass('b-file_upload');
                            FU._getEl(file, '.js-progress')
                                .css({ opacity: 0 }).show()
                                .animate({ opacity: 1 }, 100)
                            ;
                        },
                        progress: function (evt){
                            FU._getEl(file, '.js-bar').css('width', evt.loaded/evt.total*100+'%');
                        },
                        complete: function (err, xhr){
                            var state = err ? 'error' : 'done';

                            FU._getEl(file).removeClass('b-file_upload');
                            FU._getEl(file, '.js-progress').animate({ opacity: 0 }, 200, function (){ $(this).hide() });
                            FU._getEl(file, '.js-info').append(', <b class="b-file__'+state+'">'+(err ? (xhr.statusText || err) : state)+'</b>');

                            FU.index++;
                            FU.active = false;

                            FU.start();
                        }
                    });
                }
            }
        };

        function onFiles(files){
            var $Queue = $('<div/>').prependTo('#preview');

            FileAPI.each(files, function (file){
                if( file.size >= 25*FileAPI.MB ){
                    alert('Sorrow.\nMax size 25MB')
                }
                else if( file.size === void 0 ){
                    $('#oooops').show();
                    $('#buttons-panel').hide();
                }
                else {
                    $Queue.append(tmpl($('#b-file-ejs').html(), { file: file }));

                    FU.add(file);
                    FU.start();
                }
            });
        }


        $(document)
            .on('click', '.js-abort', function (evt){
                FU.abort($(evt.target).closest('.js-file').attr('id').split('-')[1]);
                evt.preventDefault();
            })
        ;
    }); // ready
</script>