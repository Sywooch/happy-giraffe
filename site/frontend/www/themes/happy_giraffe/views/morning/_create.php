<div class="morning-edit form">
    <form id="main" method="post">
        <h2>Заголовок статьи</h2><br>

        <div class="name clearfix">
            <input type="text" name="name">
        </div>

        <div class="row row-buttons">
            <button class="btn btn-green-medium">
                <span><span>Создать</span></span></button>
        </div>

    </form>
</div>
<script type="text/javascript">
    $('button').click(function () {
        if ($('.morning-edit input').val() !== '')
            this.form.submit();
        else
            return false;
    });
</script>
<style type="text/css">
    input{
        width: 500px;
    }
</style>