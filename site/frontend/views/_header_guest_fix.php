<script>
    $(window).load(function() {
        /*
         block - элемент, что фиксируется
         elementStop - до какого элемента фиксируется
         blockIndent - отступ
         */
        function bJoinRowFixed() {

            var block = $('.js-b-join-row');
            var blockTop = block.offset().top;

            var startTop = $('.layout-header').height();


            $(window).scroll(function() {
                var windowScrollTop = $(window).scrollTop();
                if (windowScrollTop > startTop) {
                    block.fadeIn();
                } else {

                    block.fadeOut();

                }
            });
        }

        bJoinRowFixed('.js-b-join-row');
    })
</script>
<div class="b-join-row js-b-join-row">
    <div class="b-join-row_hold">
        <div class="b-join-row_logo"></div>
        <div class="b-join-row_tx">Более <span class="b-join-row_tx-big"> 30 000 000</span> мам и пап</div>
        <div class="b-join-row_slogan">уже посетили Веселый Жираф!</div>
        <a href="#registerWidget" class="btn-green btn-h46 popup-a">Присоединяйтесь!</a>
    </div>
</div>
