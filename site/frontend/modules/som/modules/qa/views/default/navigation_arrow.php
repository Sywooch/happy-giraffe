<table class="article-nearby clearfix">
    <tr>
        <td><?= $previous ? '<a href="' . $previous->url . '" class="article-nearby_a article-nearby_a__l" rel="prev"><span class="article-nearby_tx">' . strip_tags($previous->title) . '</span></a>' : '&nbsp;' ?></td>
        <td><?= $next ? '<a href="' . $next->url . '" class="article-nearby_a article-nearby_a__r" rel="next"><span class="article-nearby_tx">' . strip_tags($next->title) . '</span></a>' : '&nbsp;' ?></td>
    </tr>
</table>