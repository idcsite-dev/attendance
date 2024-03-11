$(document).ready(function () {
  // Others
  $("#operatorJenis").on("keydown", function (e) {
    if ($(this).val().length >= 1 && e.which !== 8) {
      e.preventDefault();
    }
  });

  $("#updateOperatorJenis").on("keydown", function (e) {
    if ($(this).val().length >= 1 && e.which !== 8) {
      e.preventDefault();
    }
  });
  
  // Load DataTables
  $("#dataTable").load(site_url + "Jenis_keterangan/dataTables", function () {
    $("#table1").DataTable();
    initTooltips();
  });

  // Submit Event
  $("#addJenisKeterangan").submit(function () {
    $.LoadingOverlay("show");
    let jenisData = $("#jenisData").val();
    let operatorJenis = $("#operatorJenis").val();
    $.ajax({
      type: "POST",
      url: site_url + "Jenis_keterangan/create",
      data: {
        jenis: jenisData,
        operator: operatorJenis,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 201) {
          $("#dataTable").load(
            site_url + "Jenis_keterangan/dataTables",
            function () {
              $("#table1").DataTable();
              initTooltips();
            }
          );
          $("#modalAdd").modal("hide");
          $("#addJenisKeterangan").trigger("reset");
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

  $("#updateJenisKeterangan").submit(function () {
    $.LoadingOverlay("show");
    let id = $("#updateId").val();
    let updateJenisData = $("#updateJenisData").val();
    let updateOperatorJenis = $("#updateOperatorJenis").val();
    $.ajax({
      type: "POST",
      url: site_url + "Jenis_keterangan/update",
      data: {
        id: id,
        jenis: updateJenisData,
        operator: updateOperatorJenis,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#dataTable").load(
            site_url + "Jenis_keterangan/dataTables",
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
          url: site_url + "Jenis_keterangan/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(
                site_url + "Jenis_keterangan/dataTables",
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
      url: site_url + "Jenis_keterangan/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#updateId").val(data.id);
          $("#updateJenisData").val(data.jenis);
          $("#updateOperatorJenis").text(data.operator);
          $("#modalUpdate").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data jenis data", "error");
      },
    });
  });
});
