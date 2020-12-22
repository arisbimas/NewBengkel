$(document).ready(function() {
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

function showMessage(type, header, body) {
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

    Command: toastr[msgType](body, header);
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-right",
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