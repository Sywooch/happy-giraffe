if (!RedactorPlugins) var RedactorPlugins = {};
 
RedactorPlugins.formatbtn = function()
{
    return {
        init: function ()
        {
            var dropdown = {};

            dropdown.paragraph = { title: "Обычный текст", func: this.formatbtn.paragraph };
            dropdown.italic  = { title: "Курсив", func: this.formatbtn.italic };
            dropdown.bold  = { title: "Жирный", func: this.formatbtn.bold };

            dropdown.separator1  = { title: "", func: {} };
            dropdown.orderedlist  = { title: "Нумерованный список", func: this.formatbtn.orderedlist };
            dropdown.unorderedlist  = { title: "Маркированный список", func: this.formatbtn.unorderedlist };

            dropdown.separator2  = { title: "", func: {}};
            dropdown.h2  = { title: "Заголовок Н2", func: this.formatbtn.h2 };
            dropdown.h3  = { title: "Заголовок Н3", func: this.formatbtn.h3 };
            dropdown.h4  = { title: "Заголовок Н4", func: this.formatbtn.h4 };
            
            dropdown.separator3  = { title: "", func: this.formatbtn.separator3 };
            dropdown.deleted  = { title: "Зачеркнутый", func: this.formatbtn.deleted };
            dropdown.small  = { title: "Маленький", func: this.formatbtn.small };
            dropdown.code  = { title: "Code", func: this.formatbtn.code };


            //this.buttonAddFirst('formatbtn', 'formatbtn', false, dropdown);

            var button = this.button.add('formatbtn', 'Форматирование');
            //-this.button.setAwesome('formatbtn', 're-formatting');
 
            this.button.addDropdown(button, dropdown);
        },
        paragraph: function(buttonName)
        {
            this.inline.removeFormat();
            this.block.format('p');
        },
        italic: function(buttonName)
        {
            this.inline.format('italic');
        },
        bold: function(buttonName)
        {
            this.inline.format('bold');
        },
        separator1: function(buttonName)
        {
            this.name = 'separator';
        },
        separator2: function(buttonName)
        {
            this.name = 'separator';
        },
        orderedlist: function(buttonName)
        {
            this.list.toggle('orderedlist');
        },
        unorderedlist: function(buttonName)
        {
            this.list.toggle('unorderedlist');
        },
        h2: function(buttonName)
        {
            this.block.format('h2');
        },
        h3: function(buttonName)
        {
            this.block.format('h3');
        },
        h4: function(buttonName)
        {
            this.block.format('h4');
        },
        deleted: function(buttonName)
        {
            this.inline.format('del');
        },
        small: function(buttonName)
        {
            this.inline.format('small');
        },
        code: function(buttonName)
        {
            this.block.format('pre');
        },
    };
};