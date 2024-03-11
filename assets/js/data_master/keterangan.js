$(document).ready(function () {
  // Variable
  let addInput = 'jenis';
  let updateInput = 'updateJenis';

  // Others
  $("#kode").on("input", function () {
    $(this).val(
      $(this)
        .val()
        .replace(/[^a-zA-Z]/g, "")
    );

    if ($(this).val().length > 10) {
      $(this).val($(this).val().slice(0, 10));
    }
  });

  $("#updateKode").on("input", function () {
    $(this).val(
      $(this)
        .val()
        .replace(/[^a-zA-Z]/g, "")
    );

    if ($(this).val().length > 10) {
      $(this).val($(this).val().slice(0, 10));
    }
  });

  // Function
  function option(fieldID, value = null) {
    $.ajax({
      type: "POST",
      url: site_url + "Jenis_keterangan/option",
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

  // Load DataTables
  $("#dataTable").load(site_url + "Keterangan/dataTables", function () {
    $("#table1").DataTable();
    initTooltips();
  });

  // Submit Event
  $("#addKeterangan").submit(function () {
    $.LoadingOverlay("show");
    let kode = $("#kode").val();
    let status = $("#status").val();
    let keterangan = $("#keterangan").val();
    let jenis = $("#jenis").val();
    $.ajax({
      type: "POST",
      url: site_url + "Keterangan/create",
      data: {
        kode: kode,
        status: status,
        keterangan: keterangan,
        jenis: jenis,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 201) {
          $("#dataTable").load(site_url + "Keterangan/dataTables", function () {
            $("#table1").DataTable();
            initTooltips();
          });
          $("#modalAdd").modal("hide");
          $("#addKeterangan").trigger("reset");
          $.LoadingOverlay("hide");
          Swal.fire("Berhasil", data.pesan, "success");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal menyimpan data keterangan", "error");
      },
    });
  });

  $("#updateKeterangan").submit(function () {
    $.LoadingOverlay("show");
    let id = $("#updateId").val();
    let updateKode = $("#updateKode").val();
    let updateStatus = $("#updateStatus").val();
    let updateKeterangan = $("#updateDataKeterangan").val();
    let updateJenis = $("#updateJenis").val();
    $.ajax({
      type: "POST",
      url: site_url + "Keterangan/update",
      data: {
        id: id,
        kode: updateKode,
        status: updateStatus,
        keterangan: updateKeterangan,
        jenis: updateJenis,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#dataTable").load(site_url + "Keterangan/dataTables", function () {
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
        Swal.fire("Server Error", "Gagal menyimpan data keterangan", "error");
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
          url: site_url + "Keterangan/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(
                site_url + "Keterangan/dataTables",
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
              "Gagal menghapus data keterangan",
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
      url: site_url + "Keterangan/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#updateId").val(data.id);
          $("#updateKode").val(data.kode);
          $("#updateStatus").val(data.status);
          $("#updateDataKeterangan").val(data.keterangan);
          option(updateInput, data.id_jenis);
          $("#modalUpdate").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data keterangan", "error");
      },
    });
  });
});
