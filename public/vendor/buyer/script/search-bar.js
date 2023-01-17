//autocomplete to search
$(function () {

    $("#project,#project-1").autocomplete({
        source: function( request, response ) {
            var data = { 'query': request.term};
            $.ajax({
                type: 'GET',
                url: config.routes.quickSearch,
                async: true,
                dataType: 'json',
                data: data,
                success: function(data){
                    console.log(data);
                    response( data );
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var error = JSON.parse(XMLHttpRequest.responseText);
                    error.errors.forEach(function (status) {
                        $.notify({
                            content :status,
                            alertType: "alert-warning",
                            timeout: 8000
                        });
                    });
                }
            });
        },
        minLength: 0,
        focus: function (event, ui) {
            $("#project-1").val(ui.item.name);
            return false;
        },
        select: function (event, ui) {
            window.location = (ui.item.desc=="Product")?config.routes.productDetail+ui.item.slug:config.routes.store+ui.item.slug;

        }
    })
        .data("autocomplete")._renderItem = function (ul, item) {
        return $("<li>")
            .data("item.autocomplete", item)
            .append("<a href='"+config.routes.productDetail+item.slug+"'>"+ "<p class='truncate-overflow-one'>"+ item.name + "</p>" +"<span>"+ item.desc + "</sapn>" + "</a>")
            .appendTo(ul);
    };

    // $("#project,#project-1").keyup(function (e) {
    //     if ( e.keyCode == 13 ) {
    //         e.preventDefault();
    //        alert('a');
    //     }
    // });
});
jQuery.curCSS = function(element, prop, val) {
};