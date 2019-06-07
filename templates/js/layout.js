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
        },
        focus: function(event, ui){
            var val = ui.item.label
            $(this).val(val.substring(0, val.indexOf("(")));
            return false;
        }
    });
    if(document.cookie===""){
        $("#banner .wrapper").html("<span>Devi abilitare l'uso dei cookie per utilizzare il sito</span>");
    }
})

function ajax_error(req, text, error){
    alert(text);
}

function ajax_common(resp, errorFunction){
    if(resp.CSRF)
        setCookie("CSRF",resp.CSRF);
    if(resp.r==303)
        location.href=resp.url;
    if(resp.r==410)
        location.reload();
    if(resp.r==404 && resp.msg){
        if(typeof errorFunction === "function")
            errorFunction(resp);
        else
            error_message(resp.r, resp.msg);
    }
}

function error_message(error, msg){
    alert(error+": "+msg);
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
