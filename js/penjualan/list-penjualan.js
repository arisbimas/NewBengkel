let detailPenjualan = [];
let nomorFaktur;

function initializeContent() {
    HoldOn.open();
    initTablePenjualan();
    initTableDetailPenjualan();
    HoldOn.close();
}

function initTablePenjualan() {
    //datatables
    var table;
    table = $("#tablePenjualan").DataTable({
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        // Load data for the table's content from an Ajax source
        ajax: {
            url: baseUrl + "Penjualan/ListDataPenjualan",
            type: "POST",
            data: function(data) {
                data.date_filter = $("#date_filter").val();
            },
        },
        columns: [
            { data: null },
            { data: "nomor_faktur" },
            { data: "total_harga" },
            { data: "created_on" },
            { data: "created_by" },
            { data: "nomor_faktur" },
        ],
        //Set column definition initialisation properties.
        columnDefs: [{
                targets: [0], //first column / numbering column
                orderable: false, //set not orderable
                render: function(data, type, row, meta) {
                    var dtTable = $("#tablePenjualan").DataTable();
                    var pageSize = dtTable.page.len();
                    var pageIndex = dtTable.page.info().page;
                    return pageIndex * pageSize + meta.row + 1;
                },
            },
            {
                targets: [2],
                render: function renderLinkEdit(data, type, row) {
                    return formatNumberID(data);
                },
            },
            {
                targets: [5],
                orderable: false,
                render: function(data, type, row) {
                    var displayed;
                    var btnView =
                        '<button type="button" class="btn btn-outline-info btn-sm mr-2" data-toggle="modal" data-target="#popupViewDetailPenjualan" onclick="viewPenjualan(this)">Detail</button>';
                    displayed = btnView;
                    return displayed;
                },
            },
        ],
        drawCallback: function(settings) {
            $("#jmlRecordPenjualan").text(settings.json.recordsFiltered);
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

function refreshTablePenjualan() {
    var dttble = $("#tablePenjualan").DataTable();
    dttble.ajax.reload();
}

function showDetail(data) {
    $("#hdn_KodePenjualan").val(data.post.kode_barang);
    $("#txt_EditPenjualan_NamaPenjualan").val(data.post.nama_barang);
    $("#txt_EditPenjualan_Merk").val(data.post.id_merk);
    $("#txt_EditPenjualan_HargaBeli").val(data.post.harga_beli);
    $("#txt_EditPenjualan_HargaJual").val(data.post.harga_jual);
    $("#txt_EditPenjualan_Jumlah").val(data.post.stok);
    $("#txt_EditPenjualan_Diskon").val(data.post.diskon);
}

function viewPenjualan(data) {
    HoldOn.open();
    var rowData = getRowData(data);
    nomorFaktur = rowData.nomor_faktur;
    $.ajax({
            url: baseUrl + "Penjualan/GetDetailPenjualanByFaktur",
            type: "POST",
            dataType: "json",
            data: {
                nomor_faktur: rowData.nomor_faktur,
            },
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                if (data.ListData) {
                    detailPenjualan = data.ListData;
                    refreshTableDetailPenjualan();
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

function initTableDetailPenjualan() {
    //
    var table;
    table = $("#tableDetailPenjualan").DataTable({
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        searching: false,
        paging: false,
        info: false,
        // Load data for the table's content from an Ajax source
        ajax: function(data, callback, settings) {
            callback({ data: detailPenjualan });
        },
        columns: [
            { data: null },
            { data: "nomor_faktur" },
            { data: "kode_barang" },
            { data: "nama_barang" },
            { data: "harga_jual" },
            { data: "jumlah_beli" },
            { data: "sub_total" },
        ],
        //Set column definition initialisation properties.
        columnDefs: [{
                targets: [0], //first column / numbering column
                orderable: false, //set not orderable
                render: function(data, type, row, meta) {
                    var dtTable = $("#tableDetailPenjualan").DataTable();
                    var pageSize = dtTable.page.len();
                    var pageIndex = dtTable.page.info().page;
                    return pageIndex * pageSize + meta.row + 1;
                },
            },
            {
                targets: [5, 6],
                render: function renderLinkEdit(data, type, row) {
                    return formatNumberID(data);
                },
            },
        ],
        footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
                data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
                return typeof i === "string" ?
                    i.replace(/[\$,]/g, "") * 1 :
                    typeof i === "number" ?
                    i :
                    0;
            };

            // Total over this page
            pageTotal = api
                .column(6, { page: "current" })
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            //  Update footer
            $(api.column(6).footer()).html(formatNumberIDR(pageTotal));
        },
    });
}

function refreshTableDetailPenjualan() {
    var dttble = $("#tableDetailPenjualan").DataTable();
    dttble.ajax.reload();
}

function cetakStruk() {
    $.ajax({
            url: baseUrl + "Penjualan/cetak_struk",
            type: "POST",
            dataType: "json",
            data: {
                listCart: JSON.stringify(detailPenjualan),
                totalHarga: $("#totalHarga").text(),
                NomorFaktur: JSON.stringify(nomorFaktur),
                WithReturn: true,
            },
        })
        .done(function(data, status, jqXHR) {
            if (data.response === "success") {
                showMessage(1, "Success!", data.message);
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