define(['knockout', 'text!md-redactor/md-redactor.html', 'extensions/epiceditor/marked', 'extensions/epiceditor/epiceditor', 'ko_library'], function(ko, template, marked, EpicEditor) {
    function MdRedactorView(params) {

        this.editor = {};
        this.idElement = ko.observable(params.id);
        this.textareaId = params.textareaId;
        this.htmlId = params.htmlId;

        /**
         * Начинаем h-тэги с h2
         * @param text
         * @param level
         * @returns {string}
         */
        this.rendererHeadingIncrement = function rendererHeadingIncrement(text, level) {
            var escapedText = text.toLowerCase().replace(/[^\w]+/g, '-');
            level++;
            return '<h' + level + '>' + escapedText +'</h' + level + '>';
        };

        /**
         * Генерируем новый объект Render из marked.js
         * @param markedInstance
         * @returns {marked.Renderer}
         */
        this.newRenderer = function newRenderer (markedInstance) {
            var renderer = new marked.Renderer();
            renderer.heading = this.rendererHeadingIncrement;
            return renderer
        };


        /**
         * Установка опций для парсера
         */
        marked.setOptions({
            renderer:  this.newRenderer(this)
        });


        /**
         * Генератор опций для редактора
         * @param id
         * @param textareaId
         * @param htmlId
         * @returns {{container: *, textarea: *, html: *, basePath: string, clientSideStorage: boolean, localStorageName: *, useNativeFullscreen: boolean, parser: *, file: {name: string, defaultContent: string, autoSave: number}, theme: {base: string, preview: string, editor: string}, button: {preview: boolean, fullscreen: boolean, bar: string}, focusOnLoad: boolean, shortcut: {modifier: number, fullscreen: number, preview: number}, string: {togglePreview: string, toggleEdit: string, toggleFullscreen: string}, autogrow: boolean}}
         */
        this.generateNewOpts = function (id, textareaId, htmlId) {
            var opts = {
                container: id,
                textarea: textareaId,
                html: htmlId,
                basePath: '/new/javascript/modules/extensions/epiceditor/themes/',
                clientSideStorage: true,
                localStorageName: id,
                useNativeFullscreen: true,
                parser: marked,
                file: {
                    name: 'epiceditor',
                    defaultContent: '',
                    autoSave: 100
                },
                theme: {
                    base: 'epiceditor.css',
                    preview: 'github.css',
                    editor: 'epic-light.css'
                },
                button: {
                    preview: true,
                    fullscreen: true,
                    bar: "auto"
                },
                focusOnLoad: false,
                shortcut: {
                    modifier: 18,
                    fullscreen: 70,
                    preview: 80
                },
                string: {
                    togglePreview: 'Включить превью',
                    toggleEdit: 'Включить редактирование',
                    toggleFullscreen: 'Полный экран'
                },
                autogrow: false
            };
            return opts;
        };

        /**
         * Загрузка редактора после рендера шаблона
         */
        this.loadEditor = function loadEditor () {
            this.editor = new EpicEditor(this.generateNewOpts( this.idElement(), this.textareaId, this.htmlId )).load();
        };
    }

    return { viewModel: MdRedactorView, template: template };
});