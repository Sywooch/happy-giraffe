if (!RedactorPlugins) var RedactorPlugins = {};

RedactorPlugins.formatbtn = {
    init: function ()
    {
        var dropdown = {};

        dropdown['paragraph'] = { title: "Обычный текст", callback: this.paragraph };
        dropdown['italic'] = { title: "Курсив", callback: this.italic };
        dropdown['bold'] = { title: "Жирный", callback: this.bold };

        dropdown['separator1'] = { title: "", callback: this.separator1 };
        dropdown['orderedlist'] = { title: "Нумерованный список", callback: this.orderedlist };
        dropdown['unorderedlist'] = { title: "Маркированный список", callback: this.unorderedlist };

        dropdown['separator2'] = { title: "", callback: this.separator2 };
        dropdown['h2'] = { title: "Заголовок Н2", callback: this.h2 };
        dropdown['h3'] = { title: "Заголовок Н3", callback: this.h3 };
        dropdown['h4'] = { title: "Заголовок Н4", callback: this.h4 };
        
        dropdown['separator3'] = { title: "", callback: this.separator3 };
        dropdown['deleted'] = { title: "Зачеркнутый", callback: this.deleted };
        dropdown['small'] = { title: "Маленький", callback: this.small };
        dropdown['code'] = { title: "Code", callback: this.code };


        this.buttonAddFirst('formatbtn', 'formatbtn', false, dropdown);
    },
    paragraph: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.formatBlocks('p');
    },
    italic: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.exec('italic');
    },
    bold: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.exec('bold');
    },
    separator1: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.name = 'separator';
        //this.formatBlocks('separator');
    },
    separator2: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.name = 'separator';
    },
    orderedlist: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.exec('insertorderedlist');
    },
    unorderedlist: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.exec('insertunorderedlist');
    },
    h2: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.formatBlocks('h2');
    },
    h3: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.formatBlocks('h3');
    },
    h4: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.formatBlocks('h4');
    },
    deleted: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.exec('strikethrough');
    },
    small: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.inlineFormat('small');
    },
    code: function(buttonName, buttonDOM, buttonObj, e)
    {
        this.formatBlocks('pre');
    },
    
};