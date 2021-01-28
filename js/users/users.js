function initializeContent() {
    initTableUsers();
}

function initTableUsers() {
    //datatables
    var table;
    table = $("#tableUsers").DataTable({
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        // Load data for the table's content from an Ajax source
        ajax: {
            url: baseUrl + "User/listdatauser",
            type: "POST",
            data: function(data) {
                data.merk_filter = $("#merk_filter").val();
                data.date_filter = $("#date_filter").val();
            },
        },
        columns: [
            { data: null },
            { data: "user_login" },
            { data: "name" },
            { data: "image", width: "200px" },
            { data: "role_name" },
            { data: "user_login" },
        ],
        //Set column definition initialisation properties.
        columnDefs: [{
                targets: [0], //first column / numbering column
                orderable: false, //set not orderable
                render: function(data, type, row, meta) {
                    var dtTable = $("#tableUsers").DataTable();
                    var pageSize = dtTable.page.len();
                    var pageIndex = dtTable.page.info().page;
                    return pageIndex * pageSize + meta.row + 1;
                },
            },
            {
                targets: [3], //first column / numbering column
                orderable: false, //set not orderable
                className: " text-center",
                render: function renderEditLink(data, type, row, meta) {
                    var link =
                        "<img src='" +
                        baseUrl +
                        "assets/img/profile/" +
                        data +
                        "' alt='foto profile' class='img-thumbnail' style='width:180px;border-radius: 100%;'></img>";
                    return link;
                    //
                },
            },
            {
                targets: [4], //first column / numbering column
                orderable: false, //set not orderable
                className: " text-center",
                render: function renderEditLink(data, type, row, meta) {
                    var link;
                    if (row.role_id == 1) {
                        link =
                            "<span class='badge badge-pill badge-primary'>" +
                            data +
                            "</span>";
                    } else if (row.role_id == 2) {
                        link =
                            "<span class='badge badge-pill badge-secondary'>" +
                            data +
                            "</span>";
                    }

                    return link;
                    //
                },
            },
            {
                targets: [5],
                orderable: false,
                className: " text-center",
                render: function(data, type, row) {
                    var displayed;
                    var btnEdit =
                        '<button type="button" class="btn btn-outline-info btn-sm mr-2" onclick="editUsers(this)">Edit</button>';
                    var btnHapus =
                        '<button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmHapusUsers(this)">Hapus</button>';

                    displayed = btnEdit + btnHapus;
                    return displayed;
                },
            },
        ],
        drawCallback: function(settings) {
            $("#jmlRecordUsers").text(settings.json.recordsFiltered);
        },
    });

    $("#btn-filter").click(function() {
        //button filter event click
        table.ajax.reload(); //just reload table
    });
    $("#btn-reset").click(function() {
        //button reset event click
        $("#form-filter")[0].reset();
        table.ajax.reload(); //just reload table
    });
}

function refreshTableUsers() {
    var dttble = $("#tableUsers").DataTable();
    dttble.ajax.reload();
}

function executeSaveUser() {
    $.ajax({
            url: baseUrl + "User/AddUser",
            type: "POST",
            dataType: "JSON",
            data: new FormData($("#formAddUser")[0]),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                showMessage(1, "Success!", data.message);
                $("#formAddUser")[0].reset();
                $("#popupAddUser").modal("hide");
                refreshTableUsers();
            } else {
                showMessage(4, "Error!", data.message);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            showMessage(4, "Error!", "Can't Connect To Server.");
        })
        .always(function() {
            //
        });
}

function confirmHapusUsers(rowData) {
    var data = getRowData(rowData);
    Swal.fire({
        title: "Anda yakin akan menghapus data tersebut?",
        text: "data akan hilang!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Tidak",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya!",
    }).then((result) => {
        if (result.isConfirmed) {
            if ($.when(hapusData(data.user_login))) {
                refreshTableUsers();
                Swal.fire("Terhapus!", "Data telah terhapus.", "success");
            } else {
                Swal.fire("Error!", "Data tidak dapat dihapus.", "error");
            }
        }
    });
}

function hapusData(id) {
    var result = false;
    //show loader
    HoldOn.open();
    $.ajax({
            url: baseUrl + "Users/DeleteUsers",
            type: "POST",
            dataType: "json",
            data: {
                id_brg: id,
            },
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                result = true;
            } else {
                result = false;
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            result = false;
        })
        .always(function() {
            HoldOn.close();
        });

    return result;
}

function showDetail(data) {
    $("#hdn_UserLogin").val(data.user_login);
    $("#txt_EditUser_NamaUser").val(data.name);
    $("#txt_EditUser_Role").val(data.role_id);
}

function editUsers(data) {
    HoldOn.open();
    var rowData = getRowData(data);
    $.ajax({
            url: baseUrl + "User/GetUsersById",
            type: "POST",
            dataType: "json",
            data: {
                user_login: rowData.user_login,
            },
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                $("#popupEditUser").modal("show");
                showDetail(data.user_data);
            } else {
                showMessage(4, "Error!", data.message);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            showMessage(4, "Error!", jqXHR);
        })
        .always(function() {
            HoldOn.close();
        });
}

function executeEditUser() {
    HoldOn.open();
    $.ajax({
            url: baseUrl + "User/EditUser",
            type: "POST",
            dataType: "json",
            data: new FormData($("#formEditUser")[0]),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                showMessage(1, "Success!", data.message);
                if (data.reset_session) {
                    logOut();
                } else {
                    $("#formEditUser")[0].reset();
                    $("#popupEditUser").modal("hide");
                    refreshTableUsers();
                }
            } else {
                showMessage(4, "Error!", data.message);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            showMessage(4, "Error!", "Can't Connect To Server.");
        })
        .always(function() {
            HoldOn.close();
        });
}