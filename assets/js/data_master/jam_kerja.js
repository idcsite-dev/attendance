$(document).ready(function () {
  // Function
  $("#txtRangeJamKerja").daterangepicker();

  function formatCurrency(amount) {
    var formattedAmount =
      "Rp. " +
      parseFloat(amount)
        .toFixed(2)
        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
    return formattedAmount;
  }

  // Load DataTables
  $("#dataTable").load(site_url + "jam_kerja/dataTables", function () {
    $("#table1").DataTable();
    initTooltips();
  });

  // Search Data Karyawan
  $("#searchKaryawan").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: site_url + "Karyawan/searchData",
        type: "POST",
        dataType: "json",
        data: {
          search: request.term,
        },
        success: function (data) {
          response(data);
        },
        error: function (xhr) {
          Swal.fire("Error", xhr, "error");
        },
      });
    },
    appendTo: "#modalAdd",
    select: function (event, ui) {
      if (ui.item.value != "") {
        $("#nama").val(ui.item.nama);
        $("#karyawan").val(ui.item.value);
        $("#searchKaryawan").val("");
      }
      return false;
    },
    focus: function (event) {
      event.preventDefault();
    },
  });

  // Submit Event
  $("#addGaji").submit(function () {
    $.LoadingOverlay("show");
    let jam_kerja = $("#jam_kerja").val();
    let id_karyawan = $("#karyawan").val();
    if (id_karyawan == "") {
      Swal.fire({
        title: "Nama Karyawan masih kosong!",
        text: "Pilih Karyawan terlebih dahulu!",
        icon: "warning",
      }).then(function () {
        $("#searchKaryawan").focus();
      });
    } else {
      $.ajax({
        type: "POST",
        url: site_url + "Gaji/create",
        data: {
          id_karyawan: id_karyawan,
          jam_kerja: jam_kerja,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 201) {
            $("#dataTable").load(site_url + "Gaji/dataTables", function () {
              $("#table1").DataTable();
              initTooltips();
            });
            $("#modalAdd").modal("hide");
            $("#addGaji").trigger("reset");
            $.LoadingOverlay("hide");
            Swal.fire("Berhasil", data.pesan, "success");
          } else {
            $.LoadingOverlay("hide");
            Swal.fire("Gagal", data.pesan, "error");
          }
        },
        error: function () {
          $.LoadingOverlay("hide");
          Swal.fire("Server Error", "Gagal menyimpan data jam_kerja", "error");
        },
      });
    }
  });

  $("#updateGaji").submit(function () {
    $.LoadingOverlay("show");
    let id = $("#updateId").val();
    let jam_kerja = $("#updateGajiPokok").val();
    $.ajax({
      type: "POST",
      url: site_url + "Gaji/update",
      data: {
        id: id,
        jam_kerja: jam_kerja,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#dataTable").load(site_url + "Gaji/dataTables", function () {
            $("#table1").DataTable();
            initTooltips();
          });
          $("#modalUpdate").modal("hide");
          $.LoadingOverlay("hide");
          Swal.fire("Berhasil", data.pesan, "success");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal menyimpan data jenis data", "error");
      },
    });
  });

  $("#importGaji").submit(function () {
    let namaFile = $("#importFile").val();
    let importFile = $("#importFile").prop("files")[0];

    let fileExtension = namaFile.split(".").pop().toLowerCase();
    let sizeFile = importFile["size"];
    if (fileExtension != "xlsx") {
      Swal.fire({
        title: "Informasi",
        text: "File Import Gaji yang dipilih bukan Excel(.xlsx)",
        icon: "info",
      });
    } else if (sizeFile > 500000) {
      Swal.fire({
        title: "Peringatan",
        text: "Ukuran File Import Gaji yang dipilih melebihi 500kb",
        icon: "warning",
      });
    } else {
      $.LoadingOverlay("show");
      let formData = new FormData();
      formData.append("importFile", importFile);
      $.ajax({
        type: "POST",
        url: site_url + "Gaji/import",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
            $("#dataTable").load(site_url + "Gaji/dataTables", function () {
              $("#table1").DataTable();
              initTooltips();
            });
            $("#modalImport").modal("hide");
            $("#importGaji").trigger("reset");
            $.LoadingOverlay("hide");
            Swal.fire("Berhasil", data.pesan, "success");
          } else {
            $.LoadingOverlay("hide");
            Swal.fire("Gagal", data.pesan, "error");
          }
        },
        error: function () {
          $.LoadingOverlay("hide");
          Swal.fire("Server Error", "Gagal mengimport data jam_kerja", "error");
        },
      });
    }
  });

  // Click Event
  $("#importSample").click(function () {
    window.location.href = site_url + "Gaji/sample";
  });

  $(document).on("click", ".deleteData ", function () {
    let id = $(this).attr("id");

    Swal.fire({
      title: "Yakin data akan dihapus ?",
      text: "Data yang dihapus tidak bisa dikembalikan lagi!",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#dc3545",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Hapus",
      cancelButtonText: "Batal",
    }).then(function (result) {
      if (result.value) {
        $.LoadingOverlay("show");
        $.ajax({
          type: "POST",
          url: site_url + "Gaji/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(site_url + "Gaji/dataTables", function () {
                $("#table1").DataTable();
                initTooltips();
              });
              $.LoadingOverlay("hide");
              Swal.fire("Berhasil", data.pesan, "success");
            } else {
              $.LoadingOverlay("hide");
              Swal.fire("Gagal", data.pesan, "error");
            }
          },
          error: function () {
            $.LoadingOverlay("hide");
            Swal.fire(
              "Server Error",
              "Gagal menghapus data jenis data",
              "error"
            );
          },
        });
      }
    });
  });

  $(document).on("click", ".updateData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "Gaji/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#updateId").val(data.id);
          $("#updateGajiPokok").val(data.jam_kerja);
          new Cleave("#updateGajiPokok", {
            numeral: true,
            numeralThousandsGroupStyle: "thousand",
          });
          $("#modalUpdate").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data jam_kerja", "error");
      },
    });
  });

  $(document).on("click", ".detailData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "Gaji/detail",
      data: {
        id: id,
      },
      success: function (response) {
        console.log(response);
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#detailNama").val(data.nama);
          $("#detailNIK").val(data.nik);
          $("#detailGaji").val(formatCurrency(data.jam_kerja));
          $("#detailDepartemen").val(data.departemen);
          $("#detailPosisi").val(data.posisi);
          $("#detailNPWP").val(data.npwp);
          $("#modalDetail").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data jam_kerja", "error");
      },
    });
  });
});
