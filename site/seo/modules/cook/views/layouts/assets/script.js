/**
 * Author: alexk984
 * Date: 05.09.12
 */
var CookModule = {
    addTaskByName:function () {
        $.post('/cook/cook/addByName/', $('#add-by-name').serialize(), function (response) {
            if (response.status) {

            }
        }, 'json');
    }
}