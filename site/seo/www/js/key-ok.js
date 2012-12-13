/**
 * Author: alexk984
 * Date: 12.12.12
 */

var KeyOk = {
    page:0,
    term:'',
    searchKeywords:function () {
        $('div.loading').show();
        $.post('/keywords/default/searchKeywords/', {term:this.term, page:this.page}, function (response) {
            $('div.loading').hide();
            if (response.status) {
                $('.search .result').html(response.count);
                $('div.table-box tbody').html(response.table);
                $('div.pagination').html(response.pagination);
                $('html,body').animate({scrollTop:$('html').offset().top}, 'fast');
            }
            else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Не удалось получить кейворды, обратитесь к разработчику'
                });
            }
        }, 'json');
    }
}