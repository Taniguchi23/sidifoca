$(function () {
    $("body").on("click", ".pop-up", function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).data("url"),
            beforeSend: function () {
                $.blockUI();
            },
            success: function (html) {
                $("#contenedor").html(html);
                $("#contenedor").modal("show");
                $.unblockUI();
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    alert("Su sesión ha expirado.");
                    location.href = $("meta[name='base-url']").attr('content') + "/ingresar";
                } else {
                    alert("Se ha producido un error.");
                }
                $.unblockUI();
            }
        });
    });
    $("body").on("close.bs.alert", ".alert", function (e) {
        e.preventDefault();
        $(this).hide();
    });
    $("body").on("keyup keypress keydown", ".only-letters", function (e) {
        var regex = new RegExp("^[a-zA-Zá-źÁ-Ź.' \s\-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else if (e.which == 8 || e.which == 13 || e.which == 173 || e.which == 190 || e.which == 9 || e.which == 192 || e.which == 188 || e.which == 44 || e.which == 46) {
            return true;
        } else {
            return false;
        }
    });
    $("body").on("paste", ".only-letters", function (e) {
        var regex = new RegExp("^[a-zA-Zá-źÁ-Ź.' \s\-]+$");
        var text = e.originalEvent.clipboardData.getData('Text');
        text = replaceAll(text, "\n", "");
        text = replaceAll(text, ",", "");
        text = replaceAll(text, "ñ", "");
        text = replaceAll(text, "Ñ", "");
        if (text && !text.match(regex)) {
            e.preventDefault();
            alert('El texto es inválido, solo se permite letras, espacios, comas, guión medio y apóstrofo.');
        }
    });
    $("body").on('keyup keypress keydown', ".only-digits", function(e) {
        var puntaje = $(this).val();
        var max = $(this).attr('max');
        if ($.isNumeric(puntaje) && puntaje >= 0) {
            var puntaje = parseInt(puntaje);
            var max = parseInt(max);
            if (puntaje > max) {
                $(this).val(max);
            } else {
                $(this).val(puntaje);
            }
        } else {
            $(this).val("");
        }
    });
    $("body").on('blur', ".only-digits", function(e) {
        var puntaje = $(this).val();
        if (!$.isNumeric(puntaje)) {
            $(this).val("0");
        }
    })
    $("body").on("keyup keypress keydown", ".description", function (e) {
        var regex = new RegExp("^[a-zA-Zá-źÁ-Ź0-9¿?¡!.;#%&():\/\'\"\º\‘ \s\-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else if (e.which == 8 || e.which == 13 || e.which == 188 || e.which == 44 || e.which == 190 || e.which == 46 || e.which == 96 || e.which == 173 || e.which == 9 || e.which == 192 || e.which == 176 || e.which == 220) {
            return true;
        } else {
            return false;
        }
    });
    $("body").on("paste", ".description", function (e) {
        var regex = new RegExp("^[a-zA-Zá-źÁ-Ź0-9¿?¡!.;#%&():\/\'\"\º\‘ \s\-]+$");
        var text = e.originalEvent.clipboardData.getData('Text');
        text = replaceAll(text, "\n", "");
        text = replaceAll(text, ",", "");
        text = replaceAll(text, "ñ", "");
        text = replaceAll(text, "Ñ", "");
        text = replaceAll(text, "°", "");
        if (text && !text.match(regex)) {
            e.preventDefault();
            alert('El texto es inválido, caracteres especiales permitidos: ¿? ¡! ., :; () - \'" ? / ‘ º # & %');
        }
    });
    $("body").on("keyup keypress keydown", ".alpha-num", function (e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else if (e.which == 8 || e.which == 13 || e.which == 96 || e.which == 9) {
            return true;
        } else {
            return false;
        }
    });
    $("body").on("paste", ".alpha-num", function (e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        if (!e.originalEvent.clipboardData.getData('Text').match(regex)) {
            e.preventDefault();
            alert('El texto es inválido, solo se permite letras y números.');
        }
    });
    $("[download]")
    $(document).on("contextmenu", function (e) {
        return false;
    });
    if ($("#metismenu").length) {
        $("#metismenu").metisMenu();
    }
});

$(window).on("load", function (e) {
    $("[data-role='page-number']").attr("disabled", true);
});

$.extend($.blockUI.defaults, {
    message: " ",
    css: {},
    overlayCSS: {
        backgroundColor: "#AAA",
        opacity: 0.3,
        cursor: "wait"
    },
    baseZ: 2000
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content'),
    },
    data: {
        "nonce": $("meta[name='nonce']").attr('content')
    }
});

$.redirect = function (path, data) {
    $.each(data, function (key, value) {
        path = path.replace(new RegExp("@" + key, "g"), value);
    });
    $(location).attr("href", path);
};

$.exec = function (ref, callback) {
    if (typeof ref == 'undefined' || ref == null) {
        return "";
    }
    return callback(ref);
};

$.fn.inputs = function () {
    var o = {};
    var a = this.serializeArray();
    var c = this.find("input[type=checkbox]");
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    $.each(c, function () {
        if (!o.hasOwnProperty(this.name)) {
            o[this.name] = '0';
        }
    });
    return o;
};

$.fn.errors = function (errors, callback) {
    var form = $(this);
    var divError = form.find("#error");
    var ul = divError.find("ul");
    var mover = 0;
    form.find(".form-group").removeClass("has-error");
    form.find(".help-block").remove();
    ul.empty();
    divError.show();
    $.each(errors, function (key, value) {
        if (value != null) {
            if (key == "*") {
                ul.append('<li>' + value + '</li>');
                mover = divError.offset().top;
            }
            else {
                var name = key.split('.');
                var control = name.length > 1
                    ? form.find("[name='" + name[0] + "[]']").eq(name[1])
                    : form.find("[name='" + name[0] + "']");
                if (control.length > 0) {
                    if (mover == 0) {
                        mover = control.offset().top - 189;
                    }
                    if (control.closest(".col-md-7").length > 0) {
                        control.closest(".col-md-7").append('<span class="help-block">' + value[0] + '</span>');
                    } else if (control.closest(".col-md-9").length > 0) {
                        control.closest(".col-md-9").append('<span class="help-block">' + value[0] + '</span>');
                    } else {
                        control.closest(".form-group").append('<span class="help-block">' + value[0] + '</span>');
                    }
                    if (name.length > 1) {
                        var href = control.closest(".tab-pane").attr("id");
                        control.closest("fieldset").find("[href='#" + href + "']").tab("show");
                    }
                    control.closest(".form-group").addClass("has-error");
                }
            }
        }
    });
    $("html, body").animate({
        scrollTop: mover
    });
    callback && callback(divError);
};

$.fn.items = function (config) {
    var select = $(this);
    select.empty();
    if (typeof config == "string") {
        select.append('<option value="">' + config + '</option>');
    } else {
        select.append('<option value="">' + config.placeholder + '</option>');
        $.each(config.data, function (index, value) {
            select.append('<option value="' + value[config.value] + '">' + value[config.text] + '</option>');
        });
    }
};

$.fn.template = function (data) {
    var templateHtml = $(this).html()
        .replace(/\n/g, "")
        .replace(/[\t ]+\</g, "<")
        .replace(/\>[\t ]+\</g, "><")
        .replace(/\>[\t ]+$/g, ">");
    $.each(data, function (key, value) {
        templateHtml = templateHtml.replace(new RegExp("@" + key, "g"), value);
    });
    return templateHtml;
};

$.fn.captcha = function (url) {
    var self = this;
    $.ajax({
        url: url,
        beforeSend: function () {
            //$.blockUI();
        },
        success: function (json) {
            if (!json.success) {
                alert("Se ha producido un error.");
            } else {
                $(self).attr("src", json.data);
            }
            //$.unblockUI();
        },
        error: function () {
            alert("Se ha producido un error.");
            //$.unblockUI();
        }
    });
}

$.fn.toast = function (msg) {
    var toast = $(this);
    toast.html(msg);
    toast.fadeIn();
    setTimeout(function () {
        toast.fadeOut();
    }, 3000);
};

$.fn.accordion = function (config) {
    var self = this;
    $.ajax({
        url: config.url,
        beforeSend: function () {
            $(self).block();
        },
        success: function (html) {
            $(self).html(html);
            $(self).unblock();
        },
        error: function () {
            alert("Se ha producido un error.");
            $(self).unblock();
        }
    });
    return self;
}

$.fn.encrypt2 = function () {
    var value = $(this).val();
    var pubkey = $("meta[name='pubkey']").attr('content');
    /*var pem="-----BEGIN PUBLIC KEY-----"
    pem+="MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDfmlc2EgrdhvakQApmLCDOgP0n"
    pem+="NERInBheMh7J/r5aU8PUAIpGXET/8+kOGI1dSYjoux80AuHvkWp1EeHfMwC/SZ9t"
    pem+="6rF4sYqV5Lj9t32ELbh2VNbE/7QEVZnXRi5GdhozBZtS1gJHM2/Q+iToyh5dfTaA"
    pem+="U8bTnLEPMNC1h3qcUQIDAQAB"
    pem+="-----END PUBLIC KEY-----";
    console.log(pem);*/
    var pubkey = $("meta[name='pubkey']").attr('content');
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(pubkey);
    if (value && $.trim(value)) {
        value=encrypt.encrypt(value);
    }
    return value;
};

$.fn.encrypt = function () {
    var o = {};
    var a = this.serializeArray();
    var c = this.find("input[type=checkbox]");
    var e = function (name, value) {
        if (name == "_token") return value;
        if (name == "id_respuesta[]") return value;
        if (name == "observacion") return value;
        if (name == "espacios_coordinacion_ig_is") return value;
        if (name == "m_espacios_coordinacion_ig_is") return value;
        if (name == "detalles") return value;
        if (name == "comentario") return value;
        var pubkey = $("meta[name='pubkey']").attr('content');
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubkey);
        if (value && $.trim(value)) {
            var hextime = new Date().getTime();
            var time = pad(16, hextime, 'a');
            value=encrypt.encrypt(time + value);
        }
        return value;
    }
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(e(this.name, this.value) || '');
        } else {
            o[this.name] = e(this.name, this.value) || '';
        }
    });
    $.each(c, function () {
        if (!o.hasOwnProperty(this.name)) {
            o[this.name] = e('0');
        }
    });
    return o;
};

$.formData = function (form) {
    var formData = new FormData(form);
    var encrypt = function (name, value) {
        if (name == "_token") return value;
        if (name == "id_respuesta[]") return value;
        if (name == "observacion") return value;
        if (name == "espacios_coordinacion_ig_is") return value;
        if (name == "detalles") return value;
        if (name == "comentario") return value;
        var pubkey = $("meta[name='pubkey']").attr('content');
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubkey);
        if (value && $.trim(value)) {
            var hextime = new Date().getTime();
            var time = pad(16, hextime, 'a');
            value=encrypt.encrypt(time + value);
        }
        return value;
    }
    if ($(form).data("encrypt")) {
        for (var pair of formData.entries()) {
            if (pair[1] instanceof File) {
                continue;
            }
            formData.set(pair[0], encrypt(pair[0], pair[1]));
        }
    }
    return formData;
};

function encrypt(value) {
    var pubkey = $("meta[name='pubkey']").attr('content');
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(pubkey);
    if (value && $.trim(value)) {
        var hextime = new Date().getTime();
        var time = pad(16, hextime, 'a');
        value=encrypt.encrypt(time + value);
    }
    return value;
}

function decrypt(value) {
    var privkey = $("meta[name='privkey']").attr('content');
    var decrypt = new JSEncrypt();
    decrypt.setPrivateKey(privkey);
    if (value && $.trim(value)) {
        value=decrypt.decrypt(value);
        //console.log(value);
    }
    return value;
}

function generarToken() {
    var hextime = new Date().getTime();
    var pubkey = $("meta[name='pubkey']").attr('content');
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(pubkey);
    return encrypt.encrypt(hextime);
}