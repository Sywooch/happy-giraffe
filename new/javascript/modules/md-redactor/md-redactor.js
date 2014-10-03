define(['knockout', 'text!md-redactor/md-redactor.html', 'extensions/epiceditor/marked', 'extensions/epiceditor/epiceditor', 'ko_library'], function(ko, template, marked, EpicEditor) {
    function MdRedactorView(params) {

        this.editor = {};
        this.idElement = ko.observable(params.id);
        this.textareaId = params.textareaId;
        this.htmlId = params.htmlId;

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

        this.loadEditor = function loadEditor () {
            this.editor = new EpicEditor(this.generateNewOpts( this.idElement(), this.textareaId, this.htmlId )).load();
        };

        this.submitContent = function submitContent() {
            console.log(this.editor.editor.innerText);
            console.log(this.editor.previewer.innerHTML);
        };
    }

    return { viewModel: MdRedactorView, template: template };
});