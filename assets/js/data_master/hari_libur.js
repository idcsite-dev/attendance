$(document).ready(function () {
  // Function
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

  // Load DataTables
  $("#dataTable").load(site_url + "Hari_libur/dataTables", function () {
    $("#table1").DataTable();
    initTooltips();
  });

  // Change Event
  $("#kategoriLibur").change(function () {
    let value = $(this).val();
    let isRequired = $("#jamKerja").prop("required");
    let hasClass = $("#formJamKerja").hasClass("d-none");

    if (value != '' && value == 'PHH') {
      $("#formJamKerja").removeClass("d-none");
      if (!isRequired) {
        $("#jamKerja").attr("required", true);
      }
    } else {
      if (!hasClass) {
        $("#formJamKerja").addClass("d-none");
      }
      if (isRequired) {
        $("#jamKerja").removeAttr("required");
      }
    }
  });
  
  $("#updateKategoriLibur").change(function () {
    let value = $(this).val();
    let isRequired = $("#updateJamKerja").prop("required");
    let hasClass = $("#updateFormJamKerja").hasClass("d-none");

    if (value != '' && value == 'PHH') {
      $("#updateFormJamKerja").removeClass("d-none");
      if (!isRequired) {
        $("#updateJamKerja").attr("required", true);
      }
    } else {
      if (!hasClass) {
        $("#updateFormJamKerja").addClass("d-none");
      }
      if (isRequired) {
        $("#updateJamKerja").removeAttr("required");
      }
    }
  });

  // Submit Event
  $("#addHariLibur").submit(function () {
    $.LoadingOverlay("show");
    let tanggalLibur = $("#tanggalLibur").val();
    let keteranganLibur = $("#keteranganLibur").val();
    let kategoriLibur = $("#kategoriLibur").val();
    let jamKerja = $("#jamKerja").val();
    let jamKerjaDetail;
    if (kategoriLibur == 'PHH') {
      jamKerjaDetail = timeIntoTimestamp(tanggalLibur, jamKerja);
    } else {
      jamKerjaDetail = '1970-01-01 00:00:00';
    }
    $.ajax({
      type: "POST",
      url: site_url + "Hari_libur/create",
      data: {
        tanggalLibur: tanggalLibur,
        keteranganLibur: keteranganLibur,
        kategoriLibur: kategoriLibur,
        jamKerja: jamKerjaDetail,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 201) {
          $("#dataTable").load(site_url + "Hari_libur/dataTables", function () {
            $("#table1").DataTable();
            initTooltips();
          });
          $("#modalAdd").modal("hide");
          $("#addHariLibur").trigger("reset");
          $.LoadingOverlay("hide");
          Swal.fire("Berhasil", data.pesan, "success");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal menyimpan data hari libur", "error");
      },
    });
  });

  $("#updateHariLibur").submit(function () {
    $.LoadingOverlay("show");
    let idLibur = $("#updateId").val();
    let updateTanggalLibur = $("#updateTanggalLibur").val();
    let updateKeteranganLibur = $("#updateKeteranganLibur").val();
    let updateKategoriLibur = $("#updateKategoriLibur").val();
    let updateJamKerja = $("#updateJamKerja").val();
    let updateJamKerjaDetail;
    if (updateKategoriLibur == 'PHH') {
      updateJamKerjaDetail = timeIntoTimestamp(updateTanggalLibur, updateJamKerja);
    } else {
      updateJamKerjaDetail = '1970-01-01 00:00:00';
    }
    $.ajax({
      type: "POST",
      url: site_url + "Hari_libur/update",
      data: {
        idLibur: idLibur,
        tanggalLibur: updateTanggalLibur,
        keteranganLibur: updateKeteranganLibur,
        kategoriLibur: updateKategoriLibur,
        jamKerja: updateJamKerjaDetail,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#dataTable").load(site_url + "Hari_libur/dataTables", function () {
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
        Swal.fire("Server Error", "Gagal menyimpan data hari libur", "error");
      },
    });
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
          url: site_url + "Hari_libur/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(
                site_url + "Hari_libur/dataTables",
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
            Swal.fire(
              "Server Error",
              "Gagal menghapus data hari libur",
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
      url: site_url + "Hari_libur/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#updateId").val(data.id);
          $("#updateTanggalLibur").val(data.tanggal);
          $("#updateKeteranganLibur").text(data.keterangan);
          $("#updateKategoriLibur").val(data.kategori).change();
          $("#updateJamKerja").val(timeExtract(data.jam_kerja));
          $("#modalUpdate").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data hari libur", "error");
      },
    });
  });

  $(document).on("click", ".detailData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "Hari_libur/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#detailJam").val(timeExtract(data.jam_kerja));
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
});
