function initializeContent() {
    initTableBarang();
}

function initTableBarang() {
    //datatables
    var table;
    table = $("#table").DataTable({
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        // Load data for the table's content from an Ajax source
        ajax: {
            url: baseUrl + "home/ListBarang",
            type: "POST",
            data: function(data) {
                data.merk_filter = $("#merk_filter").val();
            },
        },
        columns: [
            { data: null },
            { data: "kode_barang" },
            { data: "nama_brg" },
            { data: "merk" },
            { data: "harga_beli" },
            { data: "harga_jual" },
            { data: "stok" },
            { data: "kode_barang" },
        ],
        //Set column definition initialisation properties.
        columnDefs: [{
                targets: [0], //first column / numbering column
                orderable: false, //set not orderable
                render: function(data, type, row, meta) {
                    var dtTable = $("#table").DataTable();
                    var pageSize = dtTable.page.len();
                    var pageIndex = dtTable.page.info().page;
                    return pageIndex * pageSize + meta.row + 1;
                },
            },
            {
                targets: [7],
                orderable: false,
                render: function(data, type, row) {
                    var displayed;
                    var btnEdit =
                        '<button type="button" class="btn btn-info btn-sm mr-2" onclick="editBarang(this)">Edit</button>';
                    var btnHapus =
                        '<button type="button" class="btn btn-danger btn-sm" onclick="confirmHapusBarang(this)">Hapus</button>';

                    displayed = btnEdit + btnHapus;
                    return displayed;
                },
            },
        ],
        drawCallback: function(settings) {
            $("#jmlRecordBarang").text(settings.json.recordsFiltered);
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

function refreshTableBarang() {
    var dttble = $("#table").DataTable();
    dttble.ajax.reload();
}

function executeSaveBarang() {
    //
    var namaBarang = $("#txt_AddBarang_NamaBarang").val();
    var id_merk = $("#txt_AddBarang_Merk :selected").val();
    var merk = $("#txt_AddBarang_Merk :selected").text();
    var hrgBeli = $("#txt_AddBarang_HargaBeli").val();
    var hrgJual = $("#txt_AddBarang_HargaJual").val();
    var jumlah = $("#txt_AddBarang_Jumlah").val();
    var diskon = $("#txt_AddBarang_Diskon").val();

    $.ajax({
            url: baseUrl + "Barang/AddBarang",
            type: "POST",
            dataType: "json",
            data: {
                nama_brg: namaBarang,
                id_merk: id_merk,
                merk: merk,
                harga_beli: hrgBeli,
                harga_jual: hrgJual,
                stok: jumlah,
                diskon: diskon,
            },
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                showMessage(1, "Success!", data.message);
                $("#formAddBarang")[0].reset();
                $("#popupAddBarang").modal("hide");
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

function confirmHapusBarang(rowData) {
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
            if ($.when(hapusData(data.kode_barang))) {
                refreshTableBarang();
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
            url: baseUrl + "Barang/DeleteBarang",
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
    $("#hdn_KodeBarang").val(data.post.kode_barang);
    $("#txt_EditBarang_NamaBarang").val(data.post.nama_brg);
    $("#txt_EditBarang_Merk").val(data.post.id_merk);
    $("#txt_EditBarang_HargaBeli").val(data.post.harga_beli);
    $("#txt_EditBarang_HargaJual").val(data.post.harga_jual);
    $("#txt_EditBarang_Jumlah").val(data.post.stok);
    $("#txt_EditBarang_Diskon").val(data.post.diskon);
}

function editBarang(data) {
    HoldOn.open();
    var rowData = getRowData(data);
    $.ajax({
            url: baseUrl + "Barang/GetBarangById",
            type: "POST",
            dataType: "json",
            data: {
                id_brg: rowData.kode_barang,
            },
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                $("#popupEditBarang").modal("show");
                showDetail(data);
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

function executeEditBarang() {
    //
    var kodeBarang = $("#hdn_KodeBarang").val();
    var namaBarang = $("#txt_EditBarang_NamaBarang").val();
    var id_merk = $("#txt_EditBarang_Merk :selected").val();
    var merk = $("#txt_EditBarang_Merk :selected").text();
    var hrgBeli = $("#txt_EditBarang_HargaBeli").val();
    var hrgJual = $("#txt_EditBarang_HargaJual").val();
    var jumlah = $("#txt_EditBarang_Jumlah").val();
    var diskon = $("#txt_EditBarang_Diskon").val();

    $.ajax({
            url: baseUrl + "Barang/EditBarang",
            type: "POST",
            dataType: "json",
            data: {
                kode_barang: kodeBarang,
                nama_brg: namaBarang,
                id_merk: id_merk,
                merk: merk,
                harga_beli: hrgBeli,
                harga_jual: hrgJual,
                stok: jumlah,
                diskon: diskon,
            },
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                showMessage(1, "Success!", data.message);
                $("#formEditBarang")[0].reset();
                $("#popupEditBarang").modal("hide");
                refreshTableBarang();
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