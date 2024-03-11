$(document).ready(function () {
  // Functions
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

  function timeIntoTimestamp(date, time) {
    var combinedDateTimeString = date + "T" + time;

    var combinedDateTime = new Date(combinedDateTimeString);

    var year = combinedDateTime.getFullYear();
    var month = String(combinedDateTime.getMonth() + 1).padStart(2, "0");
    var day = String(combinedDateTime.getDate()).padStart(2, "0");
    var hours = String(combinedDateTime.getHours()).padStart(2, "0");
    var minutes = String(combinedDateTime.getMinutes()).padStart(2, "0");
    var seconds = String(combinedDateTime.getSeconds()).padStart(2, "0");

    // Format timestamp
    var timestamp =
      year +
      "-" +
      month +
      "-" +
      day +
      " " +
      hours +
      ":" +
      minutes +
      ":" +
      seconds;

    return timestamp;
  }

  function timeExtract(time) {
    var currentTime = new Date(time);

    var hours = String(currentTime.getHours()).padStart(2, "0");
    var minutes = String(currentTime.getMinutes()).padStart(2, "0");

    var formattedTime = hours + ":" + minutes;
    return formattedTime;
  }

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
  $("#dataTable").load(site_url + "SPL/dataTables", function () {
    $("#table1").DataTable({
      responsive: true,
    });
    initTooltips();
  });

  // Submit Event
  $("#addSPL").submit(function () {
    let tgl_spl = $("#tglSPL").val();
    let jam_mulai = $("#jamMulai").val();
    let jam_akhir = $("#jamAkhir").val();
    let ket_spl = $("#keterangan").val();
    let id_karyawan = $("#karyawan").val();
    let namaFile = $("#file").val();
    let file = $("#file").prop("files")[0];

    let fileExtension = namaFile.split(".").pop().toLowerCase();
    let sizeFile = file["size"];
    console.log(fileExtension);
    console.log(sizeFile);
    if (id_karyawan == '') {
      Swal.fire({
        title: "Nama Karyawan masih kosong!",
        text: "Pilih Karyawan terlebih dahulu!",
        icon: "warning",
      }).then(function () {
        $("#searchKaryawan").focus();
      });
    } else if (jam_akhir < jam_mulai) {
      Swal.fire({
        title: "Jam Akhir harus setelah Jam Mulai!",
        text: "Isi Jam Akhir dengan benar!",
        icon: "warning",
      }).then(function () {
        $("#jamAkhir").focus();
      });
    } else if (fileExtension != "pdf") {
      Swal.fire({
        title: "Informasi",
        text: "File SPL yang dipilih bukan PDF",
        icon: "info",
      });
    } else if (sizeFile > 200000) {
      Swal.fire({
        title: "Peringatan",
        text: "Ukuran File SPL yang dipilih melebihi 200kb",
        icon: "warning",
      });
    } else {
      // $.LoadingOverlay("show");
      // let formData = new FormData();
      // formData.append("tgl_spl", tgl_spl);
      // formData.append("jam_mulai", timeIntoTimestamp(tgl_spl, jam_mulai));
      // formData.append("jam_akhir", timeIntoTimestamp(tgl_spl, jam_akhir));
      // formData.append("ket_spl", ket_spl);
      // formData.append("id_karyawan", id_karyawan);
      // formData.append("file", file);
      // $.ajax({
      //   type: "POST",
      //   url: site_url + "SPL/create",
      //   data: formData,
      //   processData: false,
      //   contentType: false,
      //   success: function (response) {
      //     var data = JSON.parse(response);
      //     if (data.statusCode == 201) {
      //       $("#dataTable").load(site_url + "SPL/dataTables", function () {
      //         $("#table1").DataTable();
      //         initTooltips();
      //       });
      //       $("#modalAdd").modal("hide");
      //       $("#addSPL").trigger("reset");
      //       $.LoadingOverlay("hide");
      //       Swal.fire("Berhasil", data.pesan, "success");
      //     } else {
      //       $.LoadingOverlay("hide");
      //       Swal.fire("Gagal", data.pesan, "error");
      //     }
      //   },
      //   error: function () {
      //     $.LoadingOverlay("hide");
      //     Swal.fire("Server Error", "Gagal menyimpan data SPL", "error");
      //   },
      // });
    }
  });

  $("#updateSPL").submit(function () {
    let id = $("#updateId").val();
    let tgl_spl = $("#updateTglSPL").val();
    let jam_mulai = $("#updateJamMulai").val();
    let jam_akhir = $("#updateJamAkhir").val();
    let ket_spl = $("#updateKeterangan").val();
    if (jam_akhir < jam_mulai) {
      Swal.fire({
        title: "Jam Akhir harus setelah Jam Mulai!",
        text: "Isi Jam Akhir dengan benar!",
        icon: "warning",
      }).then(function () {
        $("#updateJamAkhir").focus();
      });
    } else {
      $.LoadingOverlay("show");
      $.ajax({
        type: "POST",
        url: site_url + "SPL/update",
        data: {
          id: id,
          tgl_spl: tgl_spl,
          jam_mulai: timeIntoTimestamp(tgl_spl, jam_mulai),
          jam_akhir: timeIntoTimestamp(tgl_spl, jam_akhir),
          ket_spl: ket_spl,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
            $("#dataTable").load(site_url + "SPL/dataTables", function () {
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
          Swal.fire("Server Error", "Gagal menyimpan data SPL", "error");
        },
      });
    }
  });

  $("#uploadSPL").submit(function () {
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
        text: "File SPL yang dipilih bukan PDF",
        icon: "info",
      });
    } else if (sizeFile > 200000) {
      Swal.fire({
        title: "Peringatan",
        text: "Ukuran File SPL yang dipilih melebihi 200kb",
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
        url: site_url + "SPL/upload",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
            $("#dataTable").load(site_url + "SPL/dataTables", function () {
              $("#table1").DataTable();
              initTooltips();
            });
            $("#modalUpload").modal("hide");
            $("#uploadSPL").trigger("reset");
            $.LoadingOverlay("hide");
            Swal.fire("Berhasil", data.pesan, "success");
          } else {
            $.LoadingOverlay("hide");
            Swal.fire("Gagal", data.pesan, "error");
          }
        },
        error: function () {
          $.LoadingOverlay("hide");
          Swal.fire("Server Error", "Gagal menyimpan data SPL", "error");
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
          url: site_url + "SPL/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            console.log(data);
            if (data.statusCode == 200) {
              $("#dataTable").load(site_url + "SPL/dataTables", function () {
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
            Swal.fire("Server Error", "Gagal menghapus data SPL", "error");
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
      url: site_url + "SPL/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#updateId").val(data.id);
          $("#updateTglSPL").val(data.tanggal);
          $("#updateJamMulai").val(timeExtract(data.jam_mulai));
          $("#updateJamAkhir").val(timeExtract(data.jam_akhir));
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
        Swal.fire("Server Error", "Gagal mengambil data SPL", "error");
      },
    });
  });

  $(document).on("click", ".detailData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "SPL/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#detailNama").val(data.karyawan);
          $("#detailTglSPL").val(formatIndonesianDate(data.tanggal));
          $("#detailJamMulai").val(timeExtract(data.jam_mulai));
          $("#detailJamAkhir").val(timeExtract(data.jam_akhir));
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
        Swal.fire("Server Error", "Gagal mengambil data SPL", "error");
      },
    });
  });

  $(document).on("click", ".showFile ", function () {
    window.open(site_url + "SPL/showFile?auth=" + $(this).attr("id"), "_blank");
  });

  $(document).on("click", ".uploadData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "SPL/detail",
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
        Swal.fire("Server Error", "Gagal mengambil data SPL", "error");
      },
    });
  });
});
