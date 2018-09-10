$(document).ready(function(){
    $(".autoload_comune").autocomplete({
        minLenght: 3,
        delay: 100,
        source: function(request, response){
                $.ajax({
                    url:"/api/comune/" + request.term,
                    dataType: "json",
                    method: "SEARCH",
                    success: function(data){
                        response(data);
                    }
                })
            },
        select: function (event, ui) {
            var v = ui.item.value;
            var l = ui.item.label;
            $(this).next('input.autoload_comune_id').val(v);
            this.value = l.substring(0, l.indexOf("("));
            return false;
        }
    })
})

function ajax_error(req, text, error){
    alert(text);
}
