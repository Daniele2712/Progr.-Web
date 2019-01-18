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

function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function delCookie(name) {
    setCookie(name,"",-1);
}
