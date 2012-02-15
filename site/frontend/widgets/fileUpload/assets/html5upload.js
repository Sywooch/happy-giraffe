var HTML5Upload = {
    input:null,
    form:null,
    files:null,
    imgList:null,
    dropBox:null,
    imgCount:null,
    imgSize:null,
    uploadedCount:null,
    init:function (input, form) {
        this.input = input;
        this.form = form;
        //form.attr('action', upload_ajax_url);
        /* динамически создаем компоненты для drag and drop */
        this.input.after('<div id="img-upload-container"><div class="text">Сюда можно перетащить одно или одновременно несколько фото</div><ul id="img-upload-list"></ul></div>');

        // ul-список, содержащий миниатюрки выбранных файлов
        this.imgList = $('ul#img-upload-list'),

            // Контейнер, куда можно помещать файлы методом drag and drop
            this.dropBox = $('#img-upload-container'),

            // Счетчик всех выбранных файлов и их размера
            this.imgCount = 0,
            this.imgSize = 0,
            this.uploadedCount = 0;

        // удаление выбранного фото
        $(".delpreview").live("click", function () {
            $(this).parent().remove();
        });

        // Обработка события выбора файлов через стандартный input
        // (при вызове обработчика в свойстве files элемента input содержится объект FileList,
        //  содержащий выбранные файлы)
        this.input.bind({
            change:function () {
                HTML5Upload.displayFiles(this.files);
            }
        });

        this.form.bind({
            submit:function () {
                return HTML5Upload.submitForm();
            }
        });

        // Обработка событий drag and drop при перетаскивании файлов на элемент dropBox
        // (когда файлы бросят на принимающий элемент событию drop передается объект Event,
        //  который содержит информацию о файлах в свойстве dataTransfer.files. В jQuery "оригинал"
        //  объекта-события передается в св-ве originalEvent)
        this.dropBox.bind({
            dragenter:function () {
                $(this).addClass('highlighted');
                return false;
            },
            dragover:function () {
                return false;
            },
            dragleave:function () {
                $(this).removeClass('highlighted');
                return false;
            },
            drop:function (e) {
                var dt = e.originalEvent.dataTransfer;
                HTML5Upload.displayFiles(dt.files);
                return false;
            }
        });
    },

    submitForm:function () {
        var result = false;
        var alldone = 0;
        if (this.imgList.find('li').length == 0) {
            result = true;
        }
        else if (alldone == 1) {
            result = true;
        }
        else {
            result = false;
        }

        if (result == false) {
            this.imgList.find('li').each(function () {

                var uploadItem = this;
                var pBar = $(uploadItem).find('.progress');

                new uploaderObject({
                    file:uploadItem.file,

                    /*переменная ulr - адрес скрипта, который будет принимать фото со стороны сервера (в моём случае это значение action нашей формы)*/

                    url : HTML5Upload.form.attr('action'),
                    fieldName : HTML5Upload.input.attr('name'),

                    onprogress:function (percents) {
                        ProgressBar.update(pBar, percents);
                    },

                    oncomplete:function (done, data) {
                        if (done) {
                            ProgressBar.update(pBar, 100);
                            HTML5Upload.uploadedCount++;
                            if (HTML5Upload.uploadedCount == jQuery('#img-upload-list li').length) {
                                alldone = 1;
                                result = false;
                                ajax_upload_success(data);
                            }
                        } else {

                        }
                    }
                });
            });
        }
        return result;
    },

    // Отображение выбраных файлов и создание миниатюр
    displayFiles:function (files) {
        var imageType = /image.*/;
        var num = 0;

        $.each(files, function (i, file) {
            // Отсеиваем не картинки
            if (!file.type.match(imageType)) {
                alert('загрузить можно только изображения');
                return true;
            }

            num++;

            // Создаем элемент li и помещаем в него название, миниатюру и progress bar,
            // а также создаем ему свойство file, куда помещаем объект File (при загрузке понадобится)
            var li = $('<li/>').appendTo(HTML5Upload.imgList);
            $('<div class="photoName"/>').text(file.name).appendTo(li);
            $('<span class="delpreview">X</span>').appendTo(li);
            var img = $('<img/>').appendTo(li);
            ProgressBar.create(li);
            li.get(0).file = file;

            // Создаем объект FileReader и по завершении чтения файла, отображаем миниатюру и обновляем
            // инфу обо всех файлах
            var reader = new FileReader();
            reader.onload = (function (aImg) {
                return function (e) {
                    aImg.attr('src', e.target.result);
                    HTML5Upload.imgCount++;
                    HTML5Upload.imgSize += file.size;
                };
            })(img);

            reader.readAsDataURL(file);
        });
    }
}


/*
 * Объект-загрузчик файла на сервер.
 * Передаваемые параметры:
 * file       - объект File (обязателен)
 * url        - строка, указывает куда загружать (обязателен)
 * fieldName  - имя поля, содержащего файл (как если задать атрибут name тегу input)
 * onprogress - функция обратного вызова, вызывается при обновлении данных
 *              о процессе загрузки, принимает один параметр: состояние загрузки (в процентах)
 * oncopmlete - функция обратного вызова, вызывается при завершении загрузки, принимает два параметра:
 *              uploaded - содержит true, в случае успеха и false, если возникли какие-либо ошибки;
 *              data - в случае успеха в него передается ответ сервера
 *
 *              если в процессе загрузки возникли ошибки, то в свойство lastError объекта помещается
 *              объект ошибки, содержащий два поля: code и text
 */

var uploaderObject = function (params) {

    if (!params.file || !params.url) {
        return false;
    }

    this.xhr = new XMLHttpRequest();
    this.reader = new FileReader();

    this.progress = 0;
    this.uploaded = false;
    this.successful = false;
    this.lastError = false;

    var self = this;

    self.reader.onload = function () {
        self.xhr.upload.addEventListener("progress", function (e) {
            if (e.lengthComputable) {
                self.progress = (e.loaded * 100) / e.total;
                if (params.onprogress instanceof Function) {
                    params.onprogress.call(self, Math.round(self.progress));
                }
            }
        }, false);

        self.xhr.upload.addEventListener("load", function () {
            self.progress = 100;
            self.uploaded = true;
        }, false);

        self.xhr.upload.addEventListener("error", function () {
            self.lastError = {
                code:1,
                text:'Error uploading on server'
            };
        }, false);

        self.xhr.onreadystatechange = function () {
            var callbackDefined = params.oncomplete instanceof Function;
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (!self.uploaded) {
                        if (callbackDefined) {
                            params.oncomplete.call(self, false);
                        }
                    } else {
                        self.successful = true;
                        if (callbackDefined) {
                            params.oncomplete.call(self, true, this.responseText);
                        }
                    }
                } else {
                    self.lastError = {
                        code:this.status,
                        text:'HTTP response code is not OK (' + this.status + ')'
                    };
                    if (callbackDefined) {
                        params.oncomplete.call(self, false);
                    }
                }
            }
        };

        self.xhr.open("POST", params.url);

        var boundary = "xxxxxxxxx";
        self.xhr.setRequestHeader("Content-Type", "multipart/form-data, boundary=" + boundary);
        self.xhr.setRequestHeader("Cache-Control", "no-cache");

        var fileName = encodeURIComponent(params.file.name);

        var body = "--" + boundary + "\r\n";
        body += "Content-Disposition: form-data; name='" + (params.fieldName || 'file') + "'; filename='" + fileName + "'\r\n";
        body += "Content-Type: application/octet-stream\r\n\r\n";
        body += self.reader.result + "\r\n";
        body += "--" + boundary + "--";

        if (self.xhr.sendAsBinary) {
            // firefox
            self.xhr.sendAsBinary(body);
        } else {
            // chrome (W3C spec.)
            self.xhr.send(body);
        }

    };

    self.reader.readAsBinaryString(params.file);
};