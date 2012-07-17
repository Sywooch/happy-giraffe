$(function(){

    $('.gallery-album').each(function(){

        var album = $(this);

        album.imagesLoaded(function(){
          
          
          var albumSize = album.data('count');
          alert(albumSize);
          

          var hh = new Array, ttall = new Array, ssmall = new Array;
          var min, max, tall = 0;


          // находим минимальный, максимальный, сумму, забиваем общий массив высот

          var i = 0;

          album.find('.album-photos li:not(.more) img').each(function(){

              if (i == 0) min = max = $(this).height();

              if ($(this).height() < min) min = $(this).height();
              if ($(this).height() > max) max = $(this).height();

              hh[i] = $(this).height();

              $(this).parent().addClass('id-'+i); //помечаем список айдишками

              i++;

          })


          // тут считаем колво "высоких". высокая = 130% от среднего между min и max (собственно это значение я подбирал)

          $.each(hh, function(i, v){
              if (v > (min+max)/2*1.2) {
                  ttall.push(v);
                  tall++;
              } else {
                  ssmall.push(v)
              }

          })


          // тут в зависимости от кол-ва высоких фото, надо использовать определенное соотношение: 0:5, 1:3, 2:1

          var scount = 5;
          var tcount = tall;

          switch (tall){
              case 1: {scount = 3;break;}
              case 2: {scount = 1;break;}
              case 3: {scount = 1;tcount=2;break;}
              case 4: {scount = 1;tcount=2;break;}
              case 5: {scount = 0;tcount=2;break;}
          }

          // сортируем мелкие, чтоб "еще" попало на "6 позицию"

          ssmall.sort();


          // создаем новый список, который будем заполнять сами

          album.find('.album-photos ul').addClass('old');
          album.find('.album-photos').append('<ul class="sorted"></ul>');


          // собственно вытягиваем из старого списка, нужное кол-во нужных фоток

          var texcept = []; // массив исключений, чтоб не использовать 2 раза фотки одной высоты

          for (k=0;k<tcount;k++){

              $('#log').append('val: '+ttall[k]+'<br/>');

              $.each(hh, function(hi,hv){

                  if (hv == ttall[k]) {

                      if ($.inArray(hi, texcept) == -1) {
                          album.find('.album-photos .sorted').append(album.find('ul.old li.id-'+hi));
                          texcept.push(hi);
                          return false;
                      }

                  }

              })

          }

          var sexcept = [];

          for (k=0;k<scount;k++){

              $('#log').append('val: '+ssmall[k]+'<br/>');

              $.each(hh, function(hi,hv){

                  if (hv == ssmall[k]) {

                      if ($.inArray(hi, sexcept) == -1) {
                          $('#log').append('id: '+hi+'<br/>');
                          album.find('.album-photos .sorted').append(album.find('ul.old li.id-'+hi));
                          sexcept.push(hi);
                          return false;
                      }

                  }

              })

          }


          // добавляем "еще" и удаляем старый список
          
          var total = albumSize - tcount - scount;

          album.find('.album-photos .sorted').append(album.find('ul.old li.more'));
          if (total > 0) {album.find('.album-photos .sorted .more').show().find('.count').html(total);}
          
          album.find('ul.old').remove()


          // применяем плагин для "сетки"

          album.find('.album-photos').masonry({
              itemSelector : 'li',
              columnWidth: 230
          });

        })

    })

});