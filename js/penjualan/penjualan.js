function initializeContent() {
    localStorage.removeItem("selectedBarang");
    localStorage.removeItem("listCart");
    localStorage.setItem("listCart", []);
    initTableBarangModal();
    initTableCart();
}

function initTableBarangModal() {
    //datatables
    var table;
    table = $("#tableBarang").DataTable({
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
            { data: "nama_barang" },
            { data: "merk" },
            { data: "harga_beli" },
            { data: "harga_jual" },
            { data: "stok" },
            { data: "diskon" },
            // { data: "kode_barang" },
            { data: "kode_barang" },
        ],
        //Set column definition initialisation properties.
        columnDefs: [{
                targets: [0], //first column / numbering column
                orderable: false, //set not orderable
                render: function(data, type, row, meta) {
                    var dtTable = $("#tableBarang").DataTable();
                    var pageSize = dtTable.page.len();
                    var pageIndex = dtTable.page.info().page;
                    return pageIndex * pageSize + meta.row + 1;
                },
            },
            // {
            //     targets: [8],
            //     orderable: false,
            //     render: function renderLinkEdit(data, type, row, meta) {
            //         var displayed =
            //             "<input type='number' min='0' class='form-control p-input' id='txt_Barang_NamaBarang_" +
            //             data +
            //             "' > ";
            //         return displayed;
            //     },
            // },
            {
                targets: [8],
                orderable: false,
                render: function renderLinkEdit(data, type, row) {
                    var displayed;
                    var btnSelect =
                        '<button type="button" class="btn btn-info btn-sm mr-2" onclick="selectBarang(this)">Pilih</button>';
                    displayed = btnSelect;
                    return displayed;
                },
            },
        ],
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
    var dttble = $("#tableBarang").DataTable();
    dttble.ajax.reload();
}

function initTableCart() {
    //
    var table;
    table = $("#tableCart").DataTable({
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        searching: false,
        paging: false,
        info: false,
        // Load data for the table's content from an Ajax source
        ajax: function(data, callback, settings) {
            var carts = localStorage.getItem("listCart");
            if (carts) {
                carts = JSON.parse(carts);
            } else {
                carts = [];
            }
            callback({ data: carts });
        },
        columns: [
            { data: null },
            { data: "kode_barang" },
            { data: "nama_barang" },
            { data: "merk" },
            { data: "harga_jual" },
            { data: "diskon" },
            { data: "jumlah_beli" },
            { data: "sub_total" },
            { data: "kode_barang" },
        ],
        //Set column definition initialisation properties.
        columnDefs: [{
                targets: [0], //first column / numbering column
                orderable: false, //set not orderable
                render: function(data, type, row, meta) {
                    var dtTable = $("#tableCart").DataTable();
                    var pageSize = dtTable.page.len();
                    var pageIndex = dtTable.page.info().page;
                    return pageIndex * pageSize + meta.row + 1;
                },
            },
            {
                targets: [8],
                orderable: false,
                render: function renderLinkEdit(data, type, row, meta) {
                    var btnCancel =
                        '<button type="button" class="btn btn-danger" onclick="cancelCartItem(this)">Batal</button>';
                    return btnCancel;
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
                .column(7, { page: "current" })
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(7).footer()).html(pageTotal);
        },
    });
}

function refreshTableCart() {
    var dttble = $("#tableCart").DataTable();
    dttble.ajax.reload();
}

function cancelCartItem(data) {
    let rowData = getRowData(data);

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
            if (localStorage.getItem("listCart")) {
                var cart = JSON.parse(localStorage.getItem("listCart"));
            } else {
                var cart = [];
            }
            let newCartItems = cart.reduce((state, item) => {
                if (item.kode_barang == rowData.kode_barang) {
                    return state;
                }
                return [...state, item];
            }, []);

            localStorage.setItem("listCart", JSON.stringify(newCartItems));
            refreshTableCart();
            showMessage(2, "Sucess!", "Berhasil Dihapus dari Keranjang.");
        }
    });
}

function addToCart() {
    var selectedBarang = JSON.parse(localStorage.getItem("selectedBarang"));
    var qty = parseInt($("#txt_Barang_JumlahBeli").val());
    let isAlreadyInCart = false;
    let isOutOfStok = false;

    //check is barang selected
    if (selectedBarang) {
        //check qty != 0
        if (qty !== 0) {
            if (localStorage.getItem("listCart")) {
                var cart = JSON.parse(localStorage.getItem("listCart"));
            } else {
                var cart = [];
            }

            //check qty > stok
            //1. cek input jml beli with selected barang stok
            if (selectedBarang.stok < qty) {
                showMessage(
                    3,
                    "Warning!",
                    "Sisa " +
                    selectedBarang.nama_barang +
                    " Hanya ada " +
                    selectedBarang.stok
                );
            } else {
                //2. check selected barang stok with items list cart qty
                cart.reduce((state, item) => {
                    if (item.kodeBarang == selectedBarang.kodeBarang) {
                        if (item.jumlah_beli + qty > selectedBarang.stok) {
                            showMessage(
                                3,
                                "Warning!",
                                "Sisa " + item.nama_barang + " Hanya ada " + item.stok
                            );
                            isOutOfStok = true;
                        }
                    }
                }, []);
            }

            //if stok available
            if (!isOutOfStok) {
                let newCartItems = cart.reduce((state, item) => {
                    if (item.kode_barang == selectedBarang.kode_barang) {
                        isAlreadyInCart = true;

                        var hargaAwal = parseInt(item.harga_jual);
                        var diskon = (parseInt(item.diskon) / 100) * hargaAwal;
                        var hargaDiskon = hargaAwal - diskon;

                        const newItem = {
                            ...item,
                            jumlah_beli: parseInt(item.jumlah_beli + qty),
                            sub_total: parseInt((item.jumlah_beli + qty) * hargaDiskon),
                        };
                        return [...state, newItem];
                    }
                    return [...state, item];
                }, []);

                if (!isAlreadyInCart) {
                    var hargaAwal = parseInt(selectedBarang.harga_jual);
                    var diskon = (parseInt(selectedBarang.diskon) / 100) * hargaAwal;
                    var hargaDiskon = hargaAwal - diskon;
                    newCartItems.push({
                        ...selectedBarang,
                        jumlah_beli: parseInt(qty),
                        sub_total: hargaDiskon * parseInt(qty),
                    });
                }

                localStorage.setItem("listCart", JSON.stringify(newCartItems));
                refreshTableCart();
                $("#formPilihBarang")[0].reset();
                localStorage.removeItem("selectedBarang");
                showMessage(2, "Sucess!", "Berhasil Ditambahkan ke Keranjang.");
            }
        } else {
            showMessage(3, "Warning!", "Masukan Jumlah Beli Barang!");
        }
    } else {
        showMessage(3, "Warning!", "Pilih Barang Dulu!");
    }
}

function execute() {
    if (localStorage.getItem("listCart")) {
        HoldOn.open();
        $.ajax({
                url: baseUrl + "Penjualan/AddPenjualan",
                type: "POST",
                dataType: "json",
                data: {
                    listCart: localStorage.getItem("listCart"),
                    totalHarga: $("#totalHarga").text(),
                },
            })
            .done(function(data, status, jqXHR) {
                if (data.response === "success") {
                    showMessage(1, "Success!", data.message);
                    localStorage.removeItem("listCart");
                    refreshTableBarang();
                    refreshTableCart();
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
    } else {
        showMessage(3, "Warning!", "Pilih Barang Terlebih Dahulu.");
    }
}

function showDetail(data) {
    $("#txt_Barang_NamaBarang").val(data.nama_barang);
    $("#txt_Barang_Merk").val(data.id_merk);
    $("#txt_Barang_HargaBeli").val(data.harga_beli);
    $("#txt_Barang_HargaJual").val(data.harga_jual);
    $("#txt_Barang_Jumlah").val(data.stok);
    $("#txt_Barang_Diskon").val(data.diskon);
}

function selectBarang(rowData) {
    var data = getRowData(rowData);
    localStorage.setItem("selectedBarang", JSON.stringify(data));
    showDetail(JSON.parse(localStorage.getItem("selectedBarang")));
    $("#popupBarang").modal("hide");
}