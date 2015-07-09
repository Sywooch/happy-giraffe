define(['jquery', 'knockout', 'text!md-redactor/md-redactor.html', 'extensions/epiceditor/marked', 'extensions/epiceditor/epiceditor', "user-config", 'ko_photoUpload', 'ko_library'], function mdRedactorViewHandler($, ko, template, marked, EpicEditor, userConfig) {
    function MdRedactorView(params) {
        this.editor = {};
        this.idElement = ko.observable(params.id);
        this.textareaId = params.textareaId;
        this.htmlId = params.htmlId;
        this.full = params.full;
        this.photo = ko.observable(null);
        this.collectionId = ko.observable();
        this.videoSample = '[w:video (youtube-link)]';
        this.typeOfImage = ko.observable(null);
        this.signedImageSample = '[w:image (image-link) (source-link) "link-title"]';
        this.compareSample = '\n[w:compare (left|right) "Title" "First Text" () "Second Text"]\n\n';
        /**
         * Загружаем popup загрузчика фотографий
         * @param data
         * @param event
         */
        this.loadPhotoComponent = function (data, event) {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
            this.typeOfImage('single');
        };
        /**
         * Подписка на изменение фотографии
         */
        this.photo.subscribe(function (img) {
            if (this.typeOfImage() === 'single') {
                this.appendToText(this.generateSimpleImg(img.getGeneratedPreset('postImage'), img.title(), img.id()));
            }
            if (this.typeOfImage() === 'signed') {
                this.appendToText(this.generateSingnedImageSample(img.getGeneratedPreset('postImage'), img.id()));
            }
            if (this.typeOfImage() === 'number') {
                this.appendToText(this.generateNumberImageSample(img.getGeneratedPreset('postImage'), img.id()));
            }
            if (this.typeOfImage() === 'day') {
                this.appendToText(this.generateDayImageSample(img.getGeneratedPreset('postImage'), img.id()));
            }
            if (this.typeOfImage() === 'compare') {
                this.appendToText(this.generateCompareImageSample(img.getGeneratedPreset('postImage'), img.id()));
            }
        }, this);
        this.generateDayImageSample = function generateDayImageSample(link, collectionId) {
            return '\n[w:day (morning|noon|evening) "First Text" (' + link + ') "Second Text"]\n\n';
        };
        this.generateCompareImageSample = function generateCompareImageSample(link, collectionId) {
            return '\n[w:compare (left|right) "Title" "First Text" (' + link + ') "Second Text"]\n\n';
        };
        this.generateSingnedImageSample = function generateSingnedImageSample(link, collectionId) {
            return '[w:image (' + link + ') (source-link) "link-title"]';
        };
        this.generateNumberImageSample = function generateNumberImageSample(link, collectionId) {
            return '[w:image (' + link + ') (source-link) "link-title"]\n[w:number "sample text"]';
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
            var content = this.editor.exportFile('epiceditor');
            this.editor.importFile('epiceditor', content + text);
        };
        /**
         * Вставка видео
         */
        this.insertVideo = function instertVideo() {
            this.appendToText(this.videoSample);
        }
        /**
         * Вставка сравнения без фото
         */
        this.insertCompareImageSampleNoPhoto = function insertCompareImageSampleNoPhoto(link, collectionId) {
            this.appendToText(this.compareSample);
        };
        /**
         * Вставка подписанного изображения
         */
        this.insertSignedImage = function insertSignedImage() {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
            this.typeOfImage('signed');
        };
        /**
         * Вставка нумерации
         */
        this.insertNumberImage = function insertSignedImage() {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
            this.typeOfImage('number');
        };
        /**
         * Вставка рассказа о моем дне
         */
        this.insertDayImage = function insertSignedImage() {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
            this.typeOfImage('day');
        };
        /**
         * Вставка сравнения
         */
        this.insertCompareImage = function insertSignedImage() {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
            this.typeOfImage('compare');
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
                autogrow: {
                    minHeight: 300
                }
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