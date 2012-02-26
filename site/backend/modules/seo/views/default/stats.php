<?php
/* @var $this Controller
 * @var $keywords SeoKeywords[]
 * @var $stats SeoStats=[]
 */
?>
<style type="text/css">
    table.sample .keyword{width: 25%;}
    table.sample {
        border-width: 1px;
        border-spacing: 1px;
        border-style: none;
        border-color: black;
        border-collapse: collapse;
        background-color: white;
        width: 100%;
    }
    table.sample th {
        border-width: 1px;
        padding: 1px;
        border-style: solid;
        border-color: gray;
        background-color: ;
        -moz-border-radius: ;
    }
    table.sample td {
        border-width: 1px;
        padding: 1px;
        border-style: solid;
        border-color: gray;
        background-color: ;
        padding: 1px 2px;
    }
    body > .page {
        width: 100%;
    }
    table.sample a.active{
        color: #000;
        cursor: default;
        text-decoration: none;
    }
    table.sort thead td.curcol{
        background-color:#BBCAFF;
        color:#000
    }
</style>
<table class="sample sort">
    <thead>
    <tr>
        <td><?php echo 'Ключевое слово' ?></td>
<!--        <td>--><?php //echo CHtml::link('суммарно, <br>запросов', '#', array('class'=>'active')); ?><!--</td>-->
<!--        <td>--><?php //echo CHtml::link('средн., <br>запросов', '#'); ?><!--</td>-->
        <td><?php echo 'суммарно, <br>запросов'; ?></td>
        <td><?php echo 'средн., <br>запросов' ?></td>
        <?php foreach (HDate::ruShortMonths() as $month): ?>
<!--            <td>--><?php //echo CHtml::link($month, '#'); ?><!--</td>-->
            <td><?php echo $month ?></td>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($keywords as $keyword): ?>
        <tr>
            <td class="keyword"><?php echo $keyword->name ?></td>
            <td><?php echo $keyword->GetSummStats() ?></td>
            <td><?php echo $keyword->GetAverageStats() ?></td>
            <?php for($i=12;$i>=1;$i--){
                $val = $keyword->GetMonthStats($i);
                echo "<td>".$val."</td>";
            } ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    var img_dir = "/i/";
    var sort_case_sensitive = false; // вид сортировки (регистрозависимый или нет)

    // ф-ция, определяющая алгоритм сортировки
    function _sort(a, b) {
        var a = a[0];
        var b = b[0];
        var _a = (a + '').replace(/,/, '.');
        var _b = (b + '').replace(/,/, '.');
        if (parseFloat(_a) && parseFloat(_b) || (_b == 0) || (_a == 0)) return sort_numbers(parseFloat(_a), parseFloat(_b));
        else if (!sort_case_sensitive) return sort_insensitive(a, b);
        else return sort_sensitive(a, b);
    }

    // ф-ция сортировки чисел
    function sort_numbers(a, b) {
        return b-a;
    }

    // ф-ция регистронезависимой сортировки
    function sort_insensitive(a, b) {
        var anew = a.toLowerCase();
        var bnew = b.toLowerCase();
        if (anew < bnew) return -1;
        if (anew > bnew) return 1;
        return 0;
    }

    // ф-ция регистрозависимой сортировки
    function sort_sensitive(a, b) {
        if (a < b) return -1;
        if (a > b) return 1;
        return 0;
    }

    // вспомогательная ф-ция, выдирающая из дочерних узлов весь текст
    function getConcatenedTextContent(node) {
        var _result = "";
        if (node == null) {
            return _result;
        }
        var childrens = node.childNodes;
        var i = 0;
        while (i < childrens.length) {
            var child = childrens.item(i);
            switch (child.nodeType) {
                case 1: // ELEMENT_NODE
                case 5: // ENTITY_REFERENCE_NODE
                    _result += getConcatenedTextContent(child);
                    break;
                case 3: // TEXT_NODE
                case 2: // ATTRIBUTE_NODE
                case 4: // CDATA_SECTION_NODE
                    _result += child.nodeValue;
                    break;
                case 6: // ENTITY_NODE
                case 7: // PROCESSING_INSTRUCTION_NODE
                case 8: // COMMENT_NODE
                case 9: // DOCUMENT_NODE
                case 10: // DOCUMENT_TYPE_NODE
                case 11: // DOCUMENT_FRAGMENT_NODE
                case 12: // NOTATION_NODE
                    // skip
                    break;
            }
            i++;
        }
        return _result;
    }

    // суть скрипта
    function sort(e) {
        var el = window.event ? window.event.srcElement : e.currentTarget;
        while (el.tagName.toLowerCase() != "td") el = el.parentNode;
        var a = new Array();
        var name = el.lastChild.nodeValue;
        var dad = el.parentNode;
        var table = dad.parentNode.parentNode;
        var up = table.up;
        var node, arrow, curcol;
        for (var i = 0; (node = dad.getElementsByTagName("td").item(i)); i++) {
            if (node.lastChild.nodeValue == name){
                curcol = i;
                if (node.className == "curcol"){
                    arrow = node.firstChild;
                    table.up = Number(!up);
                }else{
                    node.className = "curcol";
                    arrow = node.insertBefore(document.createElement("img"),node.firstChild);
                    table.up = 0;
                }
                arrow.src = img_dir + table.up + ".gif";
                arrow.alt = "";
            }else{
                if (node.className == "curcol"){
                    node.className = "";
                    if (node.firstChild) node.removeChild(node.firstChild);
                }
            }
        }
        var tbody = table.getElementsByTagName("tbody").item(0);
        for (var i = 0; (node = tbody.getElementsByTagName("tr").item(i)); i++) {
            a[i] = new Array();
            a[i][0] = getConcatenedTextContent(node.getElementsByTagName("td").item(curcol));
            a[i][1] = getConcatenedTextContent(node.getElementsByTagName("td").item(1));
            a[i][2] = getConcatenedTextContent(node.getElementsByTagName("td").item(0));
            a[i][3] = node;
        }
        a.sort(_sort);
        if (table.up) a.reverse();
        for (var i = 0; i < a.length; i++) {
            tbody.appendChild(a[i][3]);
        }
    }

    // ф-ция инициализации всего процесса
    function init(e) {
        if (!document.getElementsByTagName) return;

        for (var j = 0; (thead = document.getElementsByTagName("thead").item(j)); j++) {
            var node;
            for (var i = 0; (node = thead.getElementsByTagName("td").item(i)); i++) {
                if (node.addEventListener) node.addEventListener("click", sort, false);
                else if (node.attachEvent) node.attachEvent("onclick", sort);
                node.title = "Нажмите на заголовок, чтобы отсортировать колонку";
            }
            thead.parentNode.up = 0;

            if (typeof(initial_sort_id) != "undefined"){
                td_for_event = thead.getElementsByTagName("td").item(initial_sort_id);
                if (document.createEvent){
                    var evt = document.createEvent("MouseEvents");
                    evt.initMouseEvent("click", false, false, window, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, td_for_event);
                    td_for_event.dispatchEvent(evt);
                } else if (td_for_event.fireEvent) td_for_event.fireEvent("onclick");
                if (typeof(initial_sort_up) != "undefined" && initial_sort_up){
                    if (td_for_event.dispatchEvent) td_for_event.dispatchEvent(evt);
                    else if (td_for_event.fireEvent) td_for_event.fireEvent("onclick");
                }
            }
        }
    }

    // запускаем ф-цию init() при возникновении события load
    var root = window.addEventListener || window.attachEvent ? window : document.addEventListener ? document : null;
    if (root){
        if (root.addEventListener) root.addEventListener("load", init, false);
        else if (root.attachEvent) root.attachEvent("onload", init);
    }
    //-->
</script>
