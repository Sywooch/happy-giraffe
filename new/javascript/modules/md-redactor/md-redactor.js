define(['jquery', 'knockout', 'text!md-redactor/md-redactor.html', 'extensions/epiceditor/marked', 'extensions/epiceditor/epiceditor', "user-config" ,'ko_photoUpload', 'ko_library'], function mdRedactorViewHandler($, ko, template, marked, EpicEditor, userConfig) {
    function MdRedactorView(params) {
        this.editor = {};
        this.idElement = ko.observable(params.id);
        this.textareaId = params.textareaId;
        this.htmlId = params.htmlId;
        this.photo = ko.observable(null);
        this.collectionId = ko.observable();
        var mdThat = this;
        /**
         * Загружаем popup загрузчика фотографий
         * @param data
         * @param event
         */
        this.loadPhotoComponent = function (data, event) {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
        };
        /**
         * Начинаем h-тэги с h2
         * @param text
         * @param level
         * @returns {string}
         */
        this.rendererHeadingIncrement = function rendererHeadingIncrement(text, level) {
            level++;
            return '<h' + level + '>' + text + '</h' + level + '>';
        };
        this.photoInsertion = function photoInsertion(img, instance) {
            console.log(instance);
            var content = instance.exportFile('epiceditor');
            instance.importFile('epiceditor', content + mdThat.generateSimpleImg(img.getGeneratedPreset('myPhotosAlbumCover'), img.title(), img.id()));
        };
        /**
         * Новая генерация изображения с атрибутами
         * @param href
         * @param title
         * @param text
         * @param attrs
         * @returns {string}
         */
        this.rendererImageAttribute = function rendererImageAttribute(href, title, text, attrs) {
            var out = '<img src="' + href + '" alt="' + text + '" ';
            if (title) {
                out += 'title="' + title + '" ';
            }
            if (attrs) {
                out += attrs;
            }
            out += this.options.xhtml ? '/>' : '>';
            return out;
        };
        /**
         * Генерируем новый объект Render из marked.js
         * @param markedInstance
         * @returns {marked.Renderer}
         */
        this.newRenderer = function newRenderer(markedInstance) {
            var renderer = new markedInstance.Renderer();
            renderer.heading = this.rendererHeadingIncrement;
            renderer.image = this.rendererImageAttribute;
            return renderer;
        };
        this.generateCollectionItemAttr = function generateCollectionItemAttr(imageId) {
            return 'collection-item="' + imageId + '"';
        };
        /**
         * Генерация простого изображения
         * @param url
         * @param title
         * @returns {string}
         */
        this.generateSimpleImg = function generateSimpleImg(url, title, imageId) {
            return "\n![" + title + "](" + url + " " + title + ")(" +  this.generateCollectionItemAttr(imageId) + ")\n";
        };
        /**
         * Вставка тега в текст
         * @param text
         */
        this.appendToText = function appendToText(text) {

        };
        /**
         * Установка опций для парсера
         */
        marked.setOptions({
            renderer: this.newRenderer(marked)
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
        this.loadEditor = function loadEditor() {
            this.editor = new EpicEditor(this.generateNewOpts(this.idElement(), this.textareaId, this.htmlId)).load();
        };
    }
    return {
        viewModel: MdRedactorView,
        template: template
    };
});