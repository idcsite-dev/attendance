$(document).ready(function () {
  // Function
  $(":input").inputmask();

  function formatCurrency(amount) {
    var formattedAmount =
      "Rp. " +
      parseFloat(amount)
        .toFixed(2)
        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
    return formattedAmount;
  }

  // Load DataTables
  $("#dataTable").load(site_url + "Mesin/dataTables", function () {
    $("#table1").DataTable();
    initTooltips();
  });

  // Submit Event
  $("#addMesin").submit(function () {
    let kodemesin = $("#kodemesin").val();
    let tipemesin = $("#tipemesin").val();
    let lokasimesin = $("#lokasimesin").val();
    let ipaddress = $("#ipaddress").val();
    let port = $("#port").val();
    let stat_download = $("#stat_download").val();

    if (kodemesin == "") {
      Swal.fire({
        title: "Kode Mesin",
        text: "Kode mesin wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#kodemesin").focus();
      });
      return;
    }

    if (tipemesin == "") {
      Swal.fire({
        title: "Tipe Mesin",
        text: "Tipe mesin wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#tipemesin").focus();
      });
      return;
    }

    if (lokasimesin == "") {
      Swal.fire({
        title: "Lokasi Mesin",
        text: "Lokasi mesin wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#lokasimesin").focus();
      });
      return;
    }

    if (port == "") {
      Swal.fire({
        title: "Port Mesin",
        text: "Port mesin wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#port").focus();
      });
      return;
    }

    if (stat_download == "") {
      Swal.fire({
        title: "Status Download",
        text: "Status Download wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#stat_download").focus();
      });
      return;
    }

    if (ipaddress == "") {
      Swal.fire({
        title: "Ip address",
        text: "IP Address wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#ipaddress").focus();
      });
    } else {
      $.LoadingOverlay("show");
      $.ajax({
        type: "POST",
        url: site_url + "mesin/create",
        data: {
          kodemesin: kodemesin,
          tipemesin: tipemesin,
          lokasimesin: lokasimesin,
          port: port,
          ipaddress: ipaddress,
          stat_download: stat_download,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 201) {
            $("#dataTable").load(site_url + "mesin/dataTables", function () {
              $("#table1").DataTable();
              initTooltips();
            });
            $("#modalAdd").modal("hide");
            $("#addMesin").trigger("reset");
            $.LoadingOverlay("hide");
            Swal.fire("Berhasil", data.pesan, "success");
          } else {
            $.LoadingOverlay("hide");
            Swal.fire("Gagal", data.pesan, "error");
          }
        },
        error: function () {
          $.LoadingOverlay("hide");
          Swal.fire("Server Error", "Gagal menyimpan data mesin", "error");
        },
      });
    }
  });

  $("#updateMesin").submit(function () {
    $.LoadingOverlay("show");
    let id = $("#UpdateId").val();
    let kodemesin = $("#kodemesinEdit").val();
    let tipemesin = $("#tipemesinEdit").val();
    let lokasimesin = $("#lokasimesinEdit").val();
    let ipaddress = $("#ipaddressEdit").val();
    let port = $("#portEdit").val();
    let stat_download = $("#stat_downloadEdit").val();

    if (kodemesin == "") {
      Swal.fire({
        title: "Kode Mesin",
        text: "Kode mesin wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#kodemesin").focus();
      });
      return;
    }

    if (tipemesin == "") {
      Swal.fire({
        title: "Tipe Mesin",
        text: "Tipe mesin wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#tipemesin").focus();
      });
      return;
    }

    if (lokasimesin == "") {
      Swal.fire({
        title: "Lokasi Mesin",
        text: "Lokasi mesin wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#lokasimesin").focus();
      });
      return;
    }

    if (port == "") {
      Swal.fire({
        title: "Port Mesin",
        text: "Port mesin wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#port").focus();
      });
      return;
    }

    if (stat_download == "") {
      Swal.fire({
        title: "Status Download",
        text: "Status Download wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#stat_download").focus();
      });
      return;
    }

    if (ipaddress == "") {
      Swal.fire({
        title: "Ip address",
        text: "IP Address wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#ipaddress").focus();
      });
    } else {
      $.ajax({
        type: "POST",
        url: site_url + "mesin/update",
        data: {
          id: id,
          kodemesin: kodemesin,
          tipemesin: tipemesin,
          lokasimesin: lokasimesin,
          port: port,
          ipaddress: ipaddress,
          stat_download: stat_download,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
            $("#dataTable").load(site_url + "mesin/dataTables", function () {
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
          Swal.fire("Server Error", "Gagal menyimpan data mesin", "error");
        },
      });
    }
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
          url: site_url + "mesin/delete",
          data: {
            id: id,
          },
          success: function (response) {
            // alert(response);
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(site_url + "mesin/dataTables", function () {
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

  $(document).on("click", ".editData ", function () {
    let id = $(this).attr("id");
    let kodemesin = $("#kodemesinEdit").val();
    let tipemesin = $("#tipemesinEdit").val();
    let lokasimesin = $("#lokasimesinEdit").val();
    let ipaddress = $("#ipaddressEdit").val();
    let port = $("#portEdit").val();
    let stat_download = $("#stat_downloadEdit").val();

    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "mesin/detail",
      data: {
        id: id,
        kodemesin: kodemesin,
        tipemesin: tipemesin,
        lokasimesin: lokasimesin,
        port: port,
        ipaddress: ipaddress,
        stat_download: stat_download,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $.LoadingOverlay("hide");
          $("#UpdateId").val(id);
          $("#kodemesinEdit").val(data.kd_mesin);
          $("#tipemesinEdit").val(data.tipe_mesin);
          $("#lokasimesinEdit").val(data.lokasi_mesin);
          $("#ipaddressEdit").val(data.ip_mesin);
          $("#portEdit").val(data.port_mesin);
          $("#stat_downloadEdit").val(data.status_tarik);
          $("#modalUpdate").modal("show");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil mesin", "error");
      },
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
          $("#updateGajiPokok").val(data.insentif);
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
        Swal.fire("Server Error", "Gagal mengambil data insentif", "error");
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
          $("#detailGaji").val(formatCurrency(data.insentif));
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
        Swal.fire("Server Error", "Gagal mengambil data insentif", "error");
      },
    });
  });
});
