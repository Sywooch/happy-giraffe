<style>
    .album .title {
        font-size: 21px;
        font-weight: bold;
    }

    .album .photo {
        display: inline-block;
        margin: 10px;
    }
</style>

<div class="layout-wrapper_frame clearfix">
    <div class="layout-wrapper_hold clearfix">
        <div class="layout-content clearfix">
            <div id="albums">
                <!-- ko foreach: albums -->
                <div class="album">
                    <p class="title">Название: <span data-bind="text: title"></span></p>
                    <p class="description">Описание: <span data-bind="text: description"></span></p>
                    <!-- ko foreach: photoCollection().attaches() -->
                    <p class="photo">
                        <img src="" data-bind="thumb: { photo: photo(), preset: 'uploadPreview' }">
                    </p>
                    <!-- /ko -->
                    <p>
                        <a href="" data-bind="photoUpload: { data: { multiple: true, collectionId: $data.photoCollection().id() }, callback: function(data) {$root.add(data, $data)} }">Загрузить фото</a>
                    </p>
                </div>
                <!-- /ko -->
                <div class="create">
                    <p class="title">Создать альбом</p>
                    <p>Название: <input type="text" data-bind="value: newTitle"></p>
                    <p>Описание: <input type="text" data-bind="value: newDescription"></p>
                    <p><input type="submit" value="Создать" data-bind="click: create"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    requirejs(['knockout', 'ko_photo'], function(ko) {
        function AlbumsViewModel(data) {
            var self = this;

            self.albums = ko.observableArray(ko.utils.arrayMap(data, function(item) {
                return new PhotoAlbum(item);
            }));

            self.add = function(photo, event) {
                var attach = new PhotoAttach({ photo : photo });
                attach.photo(photo);
                event.photoCollection().attaches.push(attach);
            }

            self.newTitle = ko.observable('');
            self.newDescription = ko.observable('');

            self.create = function() {
                $.post('/photo/albums/create/', { title: self.newTitle(), description: self.newDescription() }, function(data) {
                    self.albums.push(new PhotoAlbum(data));
                }, 'json');
            }
        }

        a = new AlbumsViewModel(<?=$json?>);
        ko.applyBindings(a, document.getElementById('albums'));
    });
</script>