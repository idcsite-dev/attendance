$(document).ready(function () {
  // Function
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
        $("#posisi").val(ui.item.posisi);
        $("#depart").val(ui.item.depart);
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
  $("#dataTable").load(site_url + "Authority/dataTables", function () {
    $("#table1").DataTable({
      responsive: true,
    });
    initTooltips();
  });

  // Submit Event
  $("#addUsers").submit(function () {
    let nama_user = $("#nama").val();
    let sesi = $("#sesi").val();
    let tgl_aktif = $("#tglAktif").val();
    let tgl_expired = $("#tglExpired").val();
    let akses = $("#akses").val();
    let id_karyawan = $("#karyawan").val();
    if (akses == "") {
      Swal.fire({
        title: "Akses!",
        text: "Akses wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#akses").focus();
        return;
      });
    }

    if (nama_user == "") {
      Swal.fire({
        title: "Nama User masih kosong!",
        text: "Pilih Karyawan terlebih dahulu!",
        icon: "warning",
      }).then(function () {
        $("#searchKaryawan").focus();
      });
    } else if (tgl_expired < tgl_aktif) {
      Swal.fire({
        title: "Tanggal Expired harus setelah Tanggal Aktif!",
        text: "Isi Tanggal Expired dengan benar!",
        icon: "warning",
      }).then(function () {
        $("#tglExpired").focus();
      });
    } else {
      $.LoadingOverlay("show");
      $.ajax({
        type: "POST",
        url: site_url + "Authority/create",
        data: {
          nama_user: nama_user,
          sesi: sesi,
          tgl_aktif: tgl_aktif,
          akses: akses,
          tgl_expired: tgl_expired,
          id_karyawan: id_karyawan,
        },
        success: function (response) {
          alert(response);
          var data = JSON.parse(response);
          if (data.statusCode == 201) {
            $("#dataTable").load(
              site_url + "Authority/dataTables",
              function () {
                $("#table1").DataTable();
                initTooltips();
              }
            );
            $("#modalAdd").modal("hide");
            $("#addUsers").trigger("reset");
            $.LoadingOverlay("hide");
            Swal.fire("Berhasil", data.pesan, "success");
          } else {
            $.LoadingOverlay("hide");
            Swal.fire("Gagal", data.pesan, "error");
          }
        },
        error: function () {
          $.LoadingOverlay("hide");
          Swal.fire("Server Error", "Gagal menyimpan data user", "error");
        },
      });
    }
  });

  $("#updateUsers").submit(function () {
    let id = $("#updateId").val();
    let akses = $("#editAkses").val();
    let sesi = $("#updateSesi").val();
    let tgl_aktif = $("#updateTglAktif").val();
    let tgl_expired = $("#updateTglExpired").val();

    if (akses == "") {
      swal("Error", "Akses wajib dipilih!", "error");
      return;
    }

    if (tgl_expired < tgl_aktif) {
      Swal.fire({
        title: "Tanggal Expired harus setelah Tanggal Aktif!",
        text: "Isi Tanggal Expired dengan benar!",
        icon: "warning",
      }).then(function () {
        $("#updateTglExpired").focus();
      });
    } else {
      $.LoadingOverlay("show");
      $.ajax({
        type: "POST",
        url: site_url + "Authority/update",
        data: {
          id: id,
          akses: akses,
          sesi: sesi,
          tgl_aktif: tgl_aktif,
          tgl_expired: tgl_expired,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
            $("#dataTable").load(
              site_url + "Authority/dataTables",
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
          Swal.fire("Server Error", "Gagal menyimpan data user", "error");
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
          url: site_url + "Authority/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(
                site_url + "Authority/dataTables",
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
            Swal.fire("Server Error", "Gagal menghapus data user", "error");
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
      url: site_url + "Authority/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        console.log(data);
        if (data.statusCode == 200) {
          $("#updateId").val(data.id);
          $("#editNIK").val(data.no_nik);
          $("#editNama").val(data.nama);
          $("#editDepart").val(data.depart);
          $("#editPosisi").val(data.posisi);
          $("#editAkses").val(data.akses);
          $("#updateTglAktif").val(data.tgl_aktif);
          $("#updateTglExpired").val(data.tgl_expired);
          $("#modalUpdate").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data user", "error");
      },
    });
  });

  $(document).on("click", ".detailData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "Authority/detail",
      data: {
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#detailNIK").val(data.no_nik);
          $("#detailNama").val(data.nama);
          $("#detailDepart").val(data.depart);
          $("#detailPosisi").val(data.posisi);
          $("#detailAkses").val(data.akses);
          $("#detailTglAktif").val(formatIndonesianDate(data.tgl_aktif));
          $("#detailTglExpired").val(formatIndonesianDate(data.tgl_expired));
          $("#modalDetail").modal("show");
          $.LoadingOverlay("hide");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal mengambil data user", "error");
      },
    });
  });
});
