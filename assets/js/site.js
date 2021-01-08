var checkCookie;
$(document).ready(function() {
    startCheckCookie();

    function isFunctionExist(fn) {
        if (typeof fn !== "undefined" && typeof fn === "function") {
            return true;
        } else {
            return false;
        }
    }

    if (typeof initializeContent !== "undefined") {
        if (isFunctionExist(initializeContent)) {
            initializeContent();
        }
    }
});

function showMessage(type, header, body, position) {
    var msgType;
    switch (type) {
        case (type = 1):
            msgType = "success";
            break;
        case (type = 2):
            msgType = "info";
            break;
        case (type = 3):
            msgType = "warning";
            break;
        case (type = 4):
            msgType = "error";
            break;
    }

    var positionMsg;
    switch (position) {
        case (position = 1):
            positionMsg = "toast-top-center";
            break;
        default:
            positionMsg = "toast-top-right";
            break;
    }

    Command: toastr[msgType](body, header);
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: positionMsg,
        preventDuplicates: false,
        onclick: null,
        showDuration: "400",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
}

function getRowData(element) {
    var tbl = $(element).parents("table");
    var tbl_DataTable = tbl.DataTable();
    var data = tbl_DataTable.row($(element).parents("tr")).data();
    return data;
}

function startCheckCookie() {
    checkCookie = setInterval("getCookie()", 20000);
}

function stopCheckCookie() {
    clearInterval(checkCookie);
}

function getCookie() {
    var cookie = decodeURIComponent(document.cookie);
    //console.log(cookie);
    if (cookie) {
        var listCookie = cookie.split("&");
        var split1 = listCookie[1].split("=");
        var splitDate = split1[1].split("+").join(" ");
        var newDate = new Date(splitDate);
        var now = new Date();
        if (now >= newDate) {
            logOut();
            stopCheckCookie();
        }
    }
}

function logOut() {
    //do some
    $.ajax({
            url: baseUrl + "Auth/logout",
            type: "POST",
            dataType: "json",
            data: {},
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                $(location).attr("href", baseUrl + "Auth");
            } else {
                showMessage(4, "Error!", "Gagal Logout.");
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            showMessage(4, "Error!", "Can't Connect To Server.");
        })
        .always(function() {
            //
        });
}