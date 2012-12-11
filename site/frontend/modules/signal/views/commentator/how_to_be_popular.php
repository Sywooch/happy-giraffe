<h1 class="title-page"><i class="icon-popular-medium"></i>Как стать популярным</h1>
<ul class="link-list">
    <li>
        <a class="q-title" href="">Как стать популярным</a>

        <div style="display: none">
            <a class="back" href="">Назад</a><br><br>

            <div>
                <p>dfsdgj</p>

                <p>dfsdgj</p>

                <p>dfsdgj</p>

                <p>dfsdgj</p>

                <p>dfsdgj</p>
            </div>
        </div>
    </li>
</ul>
<script type="text/javascript">
    $('body').delegate('.link-list a.q-title', 'click', function (e) {
        e.preventDefault();
        $(this).hide();
        $(this).next().show();
    });

    $('body').delegate('a.back', 'click', function (e) {
        e.preventDefault();
        $(this).parent().hide();
        $(this).parent().prev().show();
    });
</script>