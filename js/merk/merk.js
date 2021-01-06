function initializeContent() {
	initTableMerk();
}

function initTableMerk() {
	//datatables
	var table;
	table = $("#tableMerk").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		order: [], //Initial no order.
		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "Merk/ListMerk",
			type: "POST",
			data: function (data) {
				data.merk_filter = $("#merk_filter").val();
			},
		},
		columns: [
			{ data: null, width: "50px" },
			{ data: "nama_merk" },
			{ data: "id_merk", width: "200px" },
		],
		//Set column definition initialisation properties.
		columnDefs: [
			{
				targets: [0], //first column / numbering column
				orderable: false, //set not orderable
				render: function (data, type, row, meta) {
					var dtTable = $("#tableMerk").DataTable();
					var pageSize = dtTable.page.len();
					var pageIndex = dtTable.page.info().page;
					return pageIndex * pageSize + meta.row + 1;
				},
			},
			{
				targets: [2],
				orderable: false,
				render: function (data, type, row) {
					var displayed;
					var btnEdit =
						'<button type="button" class="btn btn-outline-info btn-sm mr-2" onclick="editMerk(this)">Edit</button>';
					var btnHapus =
						'<button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmHapusMerk(this)">Hapus</button>';

					displayed = btnEdit + btnHapus;
					return displayed;
				},
			},
		],
		drawCallback: function (settings) {
			$("#jmlRecordMerk").text(settings.json.recordsFiltered);
		},
	});

	$("#btn-filter").click(function () {
		//button filter event click
		table.ajax.reload(); //just reload table
	});
	$("#btn-reset").click(function () {
		//button reset event click
		$("#form-filter")[0].reset();
		table.ajax.reload(); //just reload table
	});
}

function refreshTableMerk() {
	var dttble = $("#tableMerk").DataTable();
	dttble.ajax.reload();
}

function executeSaveMerk() {
	//
	var namaMerk = $("#txt_AddMerk_NamaMerk").val();

	$.ajax({
		url: baseUrl + "Merk/AddMerk",
		type: "POST",
		dataType: "json",
		data: {
			nama_merk: namaMerk,
		},
	})
		.done(function (data, status, jqXHR) {
			if (data.response === "success") {
				showMessage(1, "Success!", data.message);
				$("#formAddMerk")[0].reset();
				$("#popupAddMerk").modal("hide");
				refreshTableMerk();
			} else {
				showMessage(4, "Error!", data.message);
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			showMessage(4, "Error!", "Can't Connect To Server.");
		})
		.always(function () {
			//
		});
}

function confirmHapusMerk(rowData) {
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
			if ($.when(hapusData(data.id_merk))) {
				refreshTableMerk();
				Swal.fire("Terhapus!", "Data telah terhapus.", "success");
			} else {
				Swal.fire("Error!", "Data tidak dapat dihapus.", "error");
			}
		}
	});
}

function hapusData(id_merk) {
	var result = false;
	//show loader
	HoldOn.open();
	$.ajax({
		url: baseUrl + "Merk/DeleteMerk",
		type: "POST",
		dataType: "json",
		data: {
			id_merk: id_merk,
		},
	})
		.done(function (data, status, jqXHR) {
			if (data.response === "success") {
				result = true;
			} else {
				result = false;
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			result = false;
		})
		.always(function () {
			HoldOn.close();
		});

	return result;
}

function showDetail(data) {
	$("#hdn_KodeMerk").val(data.post.id_merk);
	$("#txt_EditMerk_NamaMerk").val(data.post.nama_merk);
	$("#txt_EditMerk_Merk").val(data.post.id_merk);
	$("#txt_EditMerk_HargaBeli").val(data.post.harga_beli);
	$("#txt_EditMerk_HargaJual").val(data.post.harga_jual);
	$("#txt_EditMerk_Jumlah").val(data.post.stok);
	$("#txt_EditMerk_Diskon").val(data.post.diskon);
}

function editMerk(data) {
	HoldOn.open();
	var rowData = getRowData(data);
	$.ajax({
		url: baseUrl + "Merk/GetMerkById",
		type: "POST",
		dataType: "json",
		data: {
			id_merk: rowData.id_merk,
		},
	})
		.done(function (data, status, jqXHR) {
			if (data.response === "success") {
				$("#popupEditMerk").modal("show");
				showDetail(data);
			} else {
				showMessage(4, "Error!", data.message);
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			showMessage(4, "Error!", jqXHR);
		})
		.always(function () {
			HoldOn.close();
		});
}

function executeEditMerk() {
	//
	var kodeMerk = $("#hdn_KodeMerk").val();
	var namaMerk = $("#txt_EditMerk_NamaMerk").val();
	var id_merk = $("#txt_EditMerk_Merk :selected").val();
	var merk = $("#txt_EditMerk_Merk :selected").text();
	var hrgBeli = $("#txt_EditMerk_HargaBeli").val();
	var hrgJual = $("#txt_EditMerk_HargaJual").val();
	var jumlah = $("#txt_EditMerk_Jumlah").val();
	var diskon = $("#txt_EditMerk_Diskon").val();

	$.ajax({
		url: baseUrl + "Merk/EditMerk",
		type: "POST",
		dataType: "json",
		data: {
			id_merk: kodeMerk,
			nama_merk: namaMerk,
			id_merk: id_merk,
			merk: merk,
			harga_beli: hrgBeli,
			harga_jual: hrgJual,
			stok: jumlah,
			diskon: diskon,
		},
	})
		.done(function (data, status, jqXHR) {
			if (data.response === "success") {
				showMessage(1, "Success!", data.message);
				$("#formEditMerk")[0].reset();
				$("#popupEditMerk").modal("hide");
				refreshTableMerk();
			} else {
				showMessage(4, "Error!", data.message);
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			showMessage(4, "Error!", "Can't Connect To Server.");
		})
		.always(function () {
			//
		});
}
