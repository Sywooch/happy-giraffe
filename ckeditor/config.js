/*
 Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    CKEDITOR.lang.languages['ru-hg'] = 1;
    config.forcePasteAsPlainText = true;
    config.language = 'ru-hg';
    config.skin = 'hgru';
    config.filebrowserBrowseUrl = '/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl = '/ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

    config.extraPlugins = 'gallery,cuttable,attach,avarageheader,smallheader,mylink,smiles,othertext';
    config.toolbarCanCollapse = false;

/*    config.smiley_path = '/images/widget/smiles/';
    config.smiley_images = ['acute (1).gif', 'acute.gif', 'air_kiss.gif', 'angel.gif', 'bad.gif', 'beach.gif',
        'beee.gif', 'blush2.gif', 'Cherna-girl_on_weight.gif', 'connie_1.gif', 'connie_33.gif', 'connie_36.gif',
        'connie_6.gif', 'connie_feedbaby.gif', 'cray.gif', 'dance.gif', 'dash2.gif', 'diablo.gif', 'dirol.gif',
        'dntknw.gif', 'drinks.gif', 'd_coffee.gif', 'd_lovers.gif', 'facepalm.gif', 'fie.gif', 'first_move.gif',
        'fool.gif', 'girl_cray2.gif', 'girl_dance.gif', 'girl_drink1.gif', 'girl_hospital.gif', 'girl_prepare_fish.gif',
        'girl_sigh.gif', 'girl_wink.gif', 'girl_witch.gif', 'give_rose.gif', 'good.gif', 'help.gif', 'JC_hiya.gif',
        'JC_hulahoop-girl.gif', 'kirtsun_05.gif', 'kuzya_01.gif', 'LaieA_052.gif', 'Laie_16.gif', 'Laie_50.gif',
        'Laie_7.gif', 'lazy2.gif', 'l_moto.gif', 'mail1.gif', 'Mauridia_21.gif', 'mosking.gif', 'music2.gif',
        'negative.gif', 'pardon.gif', 'phil_05.gif', 'phil_35.gif', 'popcorm1.gif', 'preved.gif', 'rofl.gif',
        'sad.gif', 'scratch_one-s_head.gif', 'secret.gif', 'shok.gif', 'smile3.gif', 'sorry.gif', 'tease.gif',
        'to_become_senile.gif', 'viannen_10.gif', 'wacko2.gif', 'wink.gif' , 'yahoo.gif', 'yes3.gif'];*/

    config.toolbar = 'Main';

    config.toolbar_Main =
        [

            { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'Avarageheader', 'SmallHeader' ] },
            { name:'paragraph', items:[ 'NumberedList', 'BulletedList', '-' ] },
            { name:'insert', items:[ 'Attach', 'Smiles', '-' ] },
            { name:'links', items:[ 'MyLink', 'Unlink', '-' ] },
            { name:'cut', items:[ 'Cuttable' ] },
            { name:'document', items:[ 'Source' ] }
        ];

    config.toolbar_MainGallery =
        [

            { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'Avarageheader', 'SmallHeader' ] },
            { name:'paragraph', items:[ 'NumberedList', 'BulletedList', '-' ] },
            { name:'insert', items:[ 'Attach', 'Smiles', '-' ] },
            { name:'links', items:[ 'MyLink', 'Unlink', '-' ] },
            { name:'cut', items:[ 'Cuttable' , 'Gallery' ] },
            { name:'document', items:[ 'Source' ] }
        ];

    config.toolbar_Chat =
        [
            { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', '-' ] },
            { name:'insert', items:[ 'Attach', 'Smiles' ] }
        ];

    config.toolbar_Simple =
        [
            { name:'clipboard', items:[ 'Undo', 'Redo', '-' ] },
            { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', 'Strike', '-' ] },
            { name:'paragraph', items:[ 'NumberedList', 'BulletedList' ] }
        ];

    config.toolbar_Nocut =
        [
            { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', 'Strike' ] },
            { name:'styles', items:[ 'Format', 'Font' ] },
            { name:'colors', items:[ 'TextColor', 'BGColor' ] },
            { name:'clipboard', items:[ 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
            '/',
            { name:'paragraph', items:[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ] },
            { name:'links', items:[ 'Link', 'Unlink' ] },
            { name:'insert', items:[ 'Image' ] },
            { name:'document', items:[ 'Source' ] }
        ];

    CKEDITOR.config.format_tags = 'p;h2;h3';

    config.removePlugins = 'elementspath,clipboard,smiley,contextmenu';
};