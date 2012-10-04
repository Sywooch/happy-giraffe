CKEDITOR.dialog.add( 'attach', function( editor ) {
    var html = '';
    $.ajax({
        type : 'GET',
        url: base_url + '/albums/attach/entity/Comment/entity_id/',
        success : function(data) {
            html = data;
        },
        async : false
    });
	return {
		title : 'Вставить фото' ,
		minWidth : 400,
		minHeight : 300,
		contents : [
			{
				id : 'file_attach',
				label : '',
				title : '',
				expand:true,
				padding:0,
				elements :
				[
                    {
                        type : 'html',
                        html : html
                    }
                ]
            }
        ],
        buttons:[]
    };
});