var idleTime = 0;
var lifetime = $("meta[name='lifetime']").attr('content');
var refresh = $("meta[name='refresh']").attr('content');

$(document).ready(function () {
    var idleInterval = setInterval(timerIncrement, lifetime);
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 19) {
        if (refresh == "1") {
            location.reload();
        } else {
            window.location.href = $("meta[name='base-url']").attr('content') + "/intranet/cerrar-sesion";
        }
    }
}