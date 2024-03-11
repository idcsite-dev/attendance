$(document).ready(function () {
  // Function
  Inputmask("datetime", {
    inputFormat: "HH:MM:ss",
  }).mask("#jamDownload");

  Inputmask("datetime", {
    inputFormat: "HH:MM:ss",
  }).mask("#updateJam");

  // Load DataTables
  $("#dataTable").load(site_url + "jadwal_download/dataTables", function () {
    $("#table1").DataTable();
    initTooltips();
  });

  // Submit Event
  $("#addJadwal").submit(function () {
    $.LoadingOverlay("show");
    let jam = $("#jamDownload").val();
    if (jam == "") {
      Swal.fire({
        title: "Jadwal Download!",
        text: "Jam download wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#jamDownload").focus();
      });
    } else {
      $.ajax({
        type: "POST",
        url: site_url + "jadwal_download/create",
        data: {
          jam: jam,
        },
        success: function (response) {
          console.log(response);
          var data = JSON.parse(response);
          if (data.statusCode == 201) {
            $("#dataTable").load(
              site_url + "jadwal_download/dataTables",
              function () {
                $("#table1").DataTable();
                initTooltips();
              }
            );
            $("#modalAdd").modal("hide");
            $("#addJadwal").trigger("reset");
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
            "Gagal menyimpan data jadwal download",
            "error"
          );
        },
      });
    }
  });

  $("#updateJadwal").submit(function () {
    $.LoadingOverlay("show");
    let id = $("#updateId").val();
    let jam = $("#updateJam").val();
    $.ajax({
      type: "POST",
      url: site_url + "jadwal_download/update",
      data: {
        id: id,
        jam: jam,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#dataTable").load(
            site_url + "jadwal_download/dataTables",
            function () {
              $("#table1").DataTable();
              initTooltips();
            }
          );
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
          url: site_url + "jadwal_download/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            console.log(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(
                site_url + "jadwal_download/dataTables",
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
              "Gagal menghapus data jadwal download",
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
      url: site_url + "jadwal_download/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#updateId").val(data.id);
          $("#updateJam").val(data.jam);
          $("#modalUpdate").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire(
          "Server Error",
          "Gagal mengambil data jadwal download",
          "error"
        );
      },
    });
  });

  $(document).on("click", ".detailData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "jadwal_download/detail",
      data: {
        id: id,
      },
      success: function (response) {
        console.log(response);
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#detailNama").val(data.nama);
          $("#detailNIK").val(data.nik);
          $("#detailGaji").val(formatCurrency(data.gaji));
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
        Swal.fire(
          "Server Error",
          "Gagal mengambil data kenaikan gaji",
          "error"
        );
      },
    });
  });
});
