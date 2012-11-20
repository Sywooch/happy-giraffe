<div class="problem">
    <a href="javascript:void(0);" class="pseudo" onclick="$(this).next().toggle()">Возникла проблема</a>

    <div class="problem-in" style="display: none;">
        <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Problem(<?=$task->id ?>)">Ok</a>

        <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 1)">В черный список</a>
        <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 2)">Отложить на 3 дня</a>
        <a href="javascript:;" class="radio" onclick="ExtLinks.riseLimit(<?=$task->site_id ?>, <?=$task->site->comments_count ?>)">Недостаточно комментариев</a>

    </div>
    <div class="problem-in" style="display: none;">
        <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Problem(<?=$task->id ?>)">Ok</a>
    </div>
</div>