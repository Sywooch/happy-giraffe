var userId = 12936;

$.post('/api/family/get/', JSON.stringify({ userId: userId })); // запросим семью, ее нет - success=false
$.post('/api/family/create/'); // создадим семью
$.post('/api/family/create/'); // если запусти еще раз - вернет уже созданную
$.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'adult', name: 'Леди Гага', relationshipStatus: 'engaged' }  }), function(gaga) { // создади супругу
    $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'adult', name: 'Эмма', relationshipStatus: 'wife' }  }), function() { // а так получим ошибку - у нас моногамия
        $.post('/api/family/removeMember/', JSON.stringify({ id: gaga.data.id }), function() { // удалим леди гагу
            $.post('/api/family/createMember/', JSON.stringify({ attributes: { type: 'adult', name: 'Эмма', relationshipStatus: 'wife' }  })); // эмма - наш выбор
        });
    });
}, 'json');

