$(document).ready(function() {
    $("body").delegate("#movePost button.btn-green-medium", "click", function () {
        $.ajax({
            url:"/community/transfer/",
            data:{
                id:$("#active_post_id").val(),
                CommunityContent:{
                    community_id:$("#community_id").val(),
                    rubric_id:$("#rubric_id").val()
                }
            },
            type:"POST",
            dataType:"JSON",
            success:function (response) {
                if (response.status) {
                    //confirmMessage(this);
                    window.location = response.url;
                }
            },
            context:$(this)
        });
        return false;
    });

    $(".admin-actions .move").click(function () {
        $.fancybox.open($("#transfer_post").tmpl());
        $("#active_post_id").val($(this).prev().val());
        return false;
    });
});
