$(document).ready(function () {
  // Variable
  let addInput = "keteranganKerja";
  let updateInput = "updateKeteranganKerja";

  // Functions
  function option(fieldID, value = null) {
    $.ajax({
      type: "POST",
      url: site_url + "Keterangan_kerja/option",
      success: function (response) {
        var data = JSON.parse(response);
        $(`#${fieldID}`).html(data.option);
        if (value != null) {
          $(`#${fieldID}`).val(value).change();
        }
      },
      error: function () {
        $(`#${fieldID}`).html(
          "<option value=''>-- JENIS KETERANGAN TIDAK DITEMUKAN --</option>"
        );
      },
    });
  }
  option(addInput);

  function formatIndonesianDate(timestamp) {
    var monthNames = [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "November",
      "Desember",
    ];

    var date = new Date(timestamp);
    var day = date.getDate();
    var month = monthNames[date.getMonth()];
    var year = date.getFullYear();

    var formattedDate = day + " " + month + " " + year;

    return formattedDate;
  }

  // Change Event
  $("#keteranganKerja").change(function () {
    let value = $(this).val();
    let isRequired = $("#file").prop("required");
    let hasClass = $("#fileAbsensi").hasClass("mandatory");

    if (
      value != "" &&
      (value == "3" ||
        value == "4" ||
        value == "8" ||
        value == "9" ||
        value == "10" ||
        value == "11" ||
        value == "16" ||
        value == "19" ||
        value == "20")
    ) {
      if (!hasClass) {
        $("#fileAbsensi").addClass("mandatory");
      }
      if (!isRequired) {
        $("#file").attr("required", true);
      }
    } else {
      $("#fileAbsensi").removeClass("mandatory");
      if (isRequired) {
        $("#file").removeAttr("required");
      }
    }
  });

  // Search Data Karyawan
  $("#searchKaryawan").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: site_url + "Karyawan/searchDataAttendance",
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

  // Load DataTables
  $("#dataTable").load(site_url + "Absensi/dataTables", function () {
    $("#table1").DataTable({
      responsive: true,
    });
    initTooltips();
  });

  // Submit Event
  $("#addAbsensi").submit(function () {
    let tgl_awal = $("#tglAwal").val();
    let tgl_akhir = $("#tglAkhir").val();
    let id_ket_kerja = $("#keteranganKerja").val();
    let ket_att_aktual = $("#keterangan").val();
    let id_karyawan = $("#karyawan").val();
    let namaFile = $("#file").val();
    let file = $("#file").prop("files")[0];

    let fileExtension = namaFile.split(".").pop().toLowerCase();
    let sizeFile = file["size"];
    if (id_karyawan == "") {
      Swal.fire({
        title: "Nama Karyawan masih kosong!",
        text: "Pilih Karyawan terlebih dahulu!",
        icon: "warning",
      }).then(function () {
        $("#searchKaryawan").focus();
      });
    } else if (tgl_akhir < tgl_awal) {
      Swal.fire({
        title: "Tanggal Akhir harus setelah Tanggal Aktif!",
        text: "Isi Tanggal Akhir dengan benar!",
        icon: "warning",
      }).then(function () {
        $("#tglAkhir").focus();
      });
    } else if (fileExtension != "pdf") {
      Swal.fire({
        title: "Informasi",
        text: "File Absensi yang dipilih bukan PDF",
        icon: "info",
      });
    } else if (sizeFile > 200000) {
      Swal.fire({
        title: "Peringatan",
        text: "Ukuran File Absensi yang dipilih melebihi 200kb",
        icon: "warning",
      });
    } else {
      $.LoadingOverlay("show");
      let formData = new FormData();
      formData.append("tgl_awal", tgl_awal);
      formData.append("tgl_akhir", tgl_akhir);
      formData.append("id_ket_kerja", id_ket_kerja);
      formData.append("ket_att_aktual", ket_att_aktual);
      formData.append("id_karyawan", id_karyawan);
      formData.append("file", file);
      $.ajax({
        type: "POST",
        url: site_url + "Absensi/create",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 201) {
            $("#dataTable").load(site_url + "Absensi/dataTables", function () {
              $("#table1").DataTable();
              initTooltips();
            });
            $("#modalAdd").modal("hide");
            $("#addAbsensi").trigger("reset");
            $.LoadingOverlay("hide");
            Swal.fire("Berhasil", data.pesan, "success");
          } else {
            $.LoadingOverlay("hide");
            Swal.fire("Gagal", data.pesan, "error");
          }
        },
        error: function () {
          $.LoadingOverlay("hide");
          Swal.fire("Server Error", "Gagal menyimpan data Absensi", "error");
        },
      });
    }
  });

  $("#updateAbsensi").submit(function () {
    let id = $("#updateId").val();
    let tgl_awal = $("#updateTglAwal").val();
    let tgl_akhir = $("#updateTglAkhir").val();
    let id_ket_kerja = $("#updateKeteranganKerja").val();
    let ket_att_aktual = $("#updateKeterangan").val();
    if (tgl_akhir < tgl_awal) {
      Swal.fire({
        title: "Tanggal Akhir harus setelah Tanggal Aktif!",
        text: "Isi Tanggal Akhir dengan benar!",
        icon: "warning",
      }).then(function () {
        $("#tglAkhir").focus();
      });
    } else {
      $.LoadingOverlay("show");
      $.ajax({
        type: "POST",
        url: site_url + "Absensi/update",
        data: {
          id: id,
          tgl_awal: tgl_awal,
          tgl_akhir: tgl_akhir,
          id_ket_kerja: id_ket_kerja,
          ket_att_aktual: ket_att_aktual,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
            $("#dataTable").load(site_url + "Absensi/dataTables", function () {
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
          Swal.fire("Server Error", "Gagal menyimpan data Absensi", "error");
        },
      });
    }
  });

  $("#uploadAbsensi").submit(function () {
    let id = $("#uploadId").val();
    let id_karyawan = $("#idKaryawan").val();
    let oldFile = $("#oldFile").val();
    let namaFile = $("#uploadFile").val();
    let tanggal = $("#uploadTgl").val();
    let file = $("#uploadFile").prop("files")[0];

    let fileExtension = namaFile.split(".").pop().toLowerCase();
    let sizeFile = file["size"];
    if (fileExtension != "pdf") {
      Swal.fire({
        title: "Informasi",
        text: "File Absensi yang dipilih bukan PDF",
        icon: "info",
      });
    } else if (sizeFile > 200000) {
      Swal.fire({
        title: "Peringatan",
        text: "Ukuran File Absensi yang dipilih melebihi 200kb",
        icon: "warning",
      });
    } else {
      $.LoadingOverlay("show");
      let formData = new FormData();
      formData.append("id", id);
      formData.append("oldFile", oldFile);
      formData.append("id_karyawan", id_karyawan);
      formData.append("tanggal", tanggal);
      formData.append("file", file);
      $.ajax({
        type: "POST",
        url: site_url + "Absensi/upload",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
            $("#dataTable").load(site_url + "Absensi/dataTables", function () {
              $("#table1").DataTable();
              initTooltips();
            });
            $("#modalUpload").modal("hide");
            $("#uploadAbsensi").trigger("reset");
            $.LoadingOverlay("hide");
            Swal.fire("Berhasil", data.pesan, "success");
          } else {
            $.LoadingOverlay("hide");
            Swal.fire("Gagal", data.pesan, "error");
          }
        },
        error: function () {
          $.LoadingOverlay("hide");
          Swal.fire("Server Error", "Gagal menyimpan data Absensi", "error");
        },
      });
    }
  });

  // Click Event
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
          url: site_url + "Absensi/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(
                site_url + "Absensi/dataTables",
                function () {
                  $("#table1").DataTable();
                  initTooltips();
                }
              );
              $.LoadingOverlay("hide");
              Swal.fire("Berhasil", data.pesan, "success");
            } else {
              $.LoadingOverlay("hide");
              Swal.fire("Gagal", data.pesan, "error");
            }
          },
          error: function () {
            $.LoadingOverlay("hide");
            Swal.fire("Server Error", "Gagal menghapus data Absensi", "error");
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
      url: site_url + "Absensi/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#updateId").val(data.id);
          $("#updateTglAwal").val(data.tanggal_awal);
          $("#updateTglAkhir").val(data.tanggal_akhir);
          option(updateInput, data.keterangan_kerja);
          $("#updateKeterangan").val(data.keterangan);
          $("#modalUpdate").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data Absensi", "error");
      },
    });
  });

  $(document).on("click", ".detailData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "Absensi/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#detailNama").val(data.karyawan);
          $("#detailNIK").val(data.no_nik);
          $("#detailDepartemen").val(data.departemen);
          $("#detailPosisi").val(data.posisi);
          $("#detailGolongan").val(data.tipe);
          $("#detailTglAwal").val(formatIndonesianDate(data.tanggal_awal));
          $("#detailTglAkhir").val(formatIndonesianDate(data.tanggal_akhir));
          $("#detailKeteranganKerja").val(data.keteranganKerja);
          $("#detailKeterangan").val(data.keterangan);
          $("#modalDetail").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data Absensi", "error");
      },
    });
  });

  $(document).on("click", ".showFile ", function () {
    window.open(
      site_url + "Absensi/showFile?auth=" + $(this).attr("id"),
      "_blank"
    );
  });

  $(document).on("click", ".uploadData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "Absensi/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#uploadId").val(data.id);
          $("#idKaryawan").val(data.id_karyawan);
          $("#oldFile").val(data.file);
          $("#uploadTgl").val(data.tanggal);
          $("#modalUpload").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data Absensi", "error");
      },
    });
  });
});
