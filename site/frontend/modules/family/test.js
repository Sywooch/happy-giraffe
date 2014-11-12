var userId = 12936;

$.post('/api/family/get/', JSON.stringify({ userId: userId })); // запросим семью, ее нет - success=false
$.post('/api/family/create/', function(family) { // создадим семью
    $.post('/api/family/update/', JSON.stringify({ attributes: { description: 'Команда мечты' }, id: family.data.id }));

    // моя половинка
    $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'adult', name: 'Леди Гага', relationshipStatus: 'engaged' }  }), function(gaga) { // создади супругу
        $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'adult', name: 'Эмма', relationshipStatus: 'married' }  }), function() { // а так получим ошибку - у нас моногамия
            $.post('/api/family/removeMember/', JSON.stringify({ id: gaga.data.id }), function() { // удалим леди гагу
                $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'adult', name: 'Эмма', relationshipStatus: 'married' }  })); // эмма - наш выбор
            });
        });
    }, 'json');

    // дети
    $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'child', name: 'Вася', description: 'Пупкин', birthday: '1998-05-12', gender: '1' }  }), function(putin) {
        $.post('/api/family/updateMember/', JSON.stringify({ attributes: { name: 'Владимир', description: 'Путин' }, id: putin.data.id })); // исправим ребеночка
    });
    $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'child', name: 'Гага', description: 'Младшая', birthday: '2014-08-12', gender: '0' }  }));
    $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'child', name: 'Курт', birthday: '2013-09-03', gender: '1' }  }), function(kurt) {
        $.post('/api/family/removeMember/', JSON.stringify({ id: kurt.data.id }), function() { // стреляем
            $.post('/api/family/restoreMember/', JSON.stringify({ id: kurt.data.id })); // воскрешаем
        });
    });

    // беременность и планирование
    $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'waiting', birthday: '2014-11-25', gender: '1' }  }), function(pregnancy) { // создаем беременность
        $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'planning', planningWhen: 'soon' } }, function() { // запланировать нельзя - уже есть беременность
            $.post('/api/family/removeMember/', JSON.stringify({ id: pregnancy.data.id }), function() { // удалим леди гагу
                $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'planning', planningWhen: 'soon' } })); // запланируем все-таки
            });
        }));
    });

    $.post('/api/family/create/'); // если запустить еще раз - вернет уже созданную
});