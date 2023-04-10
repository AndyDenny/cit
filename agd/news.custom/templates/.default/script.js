$(document).ready(function () {
    $(".btn-hider").on("click",function () {
        $(".hider-wrapper").slideDown();
        $(this).val("Уверены?");
    });
    $(".refuse,.agree").on("click",function () {
        let sDataName = $(".btn-hider").data("name");
        $(".hider-wrapper").slideUp();
        $(".btn-hider").val(sDataName);
    });
    $("#form-news-delete .agree").on("click",function () {
        $(".news-item-detail").slideUp();

    });
    //
    $(".update-category_news-wrapper .item.cat-name").on("keyup",function (e){
        if( $(this).val().length > 0  && !( $(".item-category option[value='choose']").prop('selected') ) ){
            $(".update-category").attr('disabled', null);
        }else{
            $(".update-category").attr("disabled","disabled");
        }
    });
    //
    $(".add-item_news-wrapper .item.item-name").on("keyup",function (e){
        if( $(this).val().length > 0){
            $(".add-news-item").attr('disabled', null);
        }else{
            $(".add-news-item").attr("disabled","disabled");
        }
    });
    //
    $(".news-list").on("click",function (e) {
        e.preventDefault();
        window.location.search = "";
    })
});