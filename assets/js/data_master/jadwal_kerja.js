$(document).ready(function () {
  // Function
  Inputmask("datetime", {
    inputFormat: "HH:MM:ss",
  }).mask("#jamMasuk");

  Inputmask("datetime", {
    inputFormat: "HH:MM:ss",
  }).mask("#jamPulang");

  // Load DataTables
  $("#dataTable").load(site_url + "jadwal_kerja/dataTables", function () {
    $("#table1").DataTable();
    initTooltips();
  });

  // $("#table1").DataTable();

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
  $("#addjadwal_kerja").submit(function () {
    let kodejadwalkerja = $("#kodeJadwalKerja").val();
    let jadwalkerja = $("#jadwalKerja").val();
    let jammasuk = $("#jamMasuk").val();
    let jampulang = $("#jamPulang").val();
    let toleransi = $("#waktuToleransi").val();

    if (kodejadwalkerja == "") {
      Swal.fire({
        title: "Kode Jadwal Kerja",
        text: "Kode jadwal kerja wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#kodeJadwalKerja").focus();
      });
      return;
    }

    if (jadwalkerja == "") {
      Swal.fire({
        title: "Jadwal Kerja",
        text: "Jadwal kerja wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#kodeJadwalKerja").focus();
      });
      return;
    }

    if (jammasuk == "") {
      Swal.fire({
        title: "Jam Masuk",
        text: "Jam masuk wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#jamMasuk").focus();
      });
      return;
    }

    if (jampulang == "") {
      Swal.fire({
        title: "Jam Pulang",
        text: "Jam pulang wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#jamPulang").focus();
      });
      return;
    }

    if (toleransi == "") {
      tolerasni = 0;
    }

    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "jadwal_kerja/create",
      data: {
        kodejadwalkerja: kodejadwalkerja,
        jadwalkerja: jadwalkerja,
        jammasuk: jammasuk,
        jampulang: jampulang,
        toleransi: toleransi,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 201) {
          $("#dataTable").load(
            site_url + "jadwal_kerja/dataTables",
            function () {
              $("#table1").DataTable();
              initTooltips();
            }
          );
          $("#modalAdd").modal("hide");
          $("#addjadwal_kerja").trigger("reset");
          $.LoadingOverlay("hide");
          Swal.fire("Berhasil", data.pesan, "success");
        } else {
          $.LoadingOverlay("hide");
          Swal.fire("Gagal", data.pesan, "error");
        }
      },
      error: function () {
        $.LoadingOverlay("hide");
        Swal.fire("Server Error", "Gagal menyimpan data jadwal kerja", "error");
      },
    });
  });

  $("#updateJadwalKerja").submit(function () {
    let id = $("#updateId").val();
    let kodejadwalkerja = $("#kodeJadwalKerjaEdit").val();
    let jadwalkerja = $("#jadwalKerjaEdit").val();
    let jammasuk = $("#jamMasukEdit").val();
    let jampulang = $("#jamPulangEdit").val();
    let toleransi = $("#waktuToleransiEdit").val();

    if (id == "") {
      Swal.fire({
        title: "Jadwal Kerja",
        text: "Jadwal kerja tidak ditemukan!",
        icon: "warning",
      }).then(function () {
        return;
      });
    }

    if (kodejadwalkerja == "") {
      Swal.fire({
        title: "Kode Jadwal Kerja",
        text: "Kode jadwal kerja wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#kodeJadwalKerja").focus();
      });
      return;
    }

    if (jadwalkerja == "") {
      Swal.fire({
        title: "Jadwal Kerja",
        text: "Jadwal kerja wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#kodeJadwalKerja").focus();
      });
      return;
    }

    if (jammasuk == "") {
      Swal.fire({
        title: "Jam Masuk",
        text: "Jam masuk wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#jamMasuk").focus();
      });
      return;
    }

    if (jampulang == "") {
      Swal.fire({
        title: "Jam Pulang",
        text: "Jam pulang wajib diisi!",
        icon: "warning",
      }).then(function () {
        $("#jamPulang").focus();
      });
      return;
    }

    if (toleransi == "") {
      tolerasni = 0;
    }

    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "jadwal_kerja/update",
      data: {
        id: id,
        kodejadwalkerja: kodejadwalkerja,
        jadwalkerja: jadwalkerja,
        jammasuk: jammasuk,
        jampulang: jampulang,
        toleransi: toleransi,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#dataTable").load(
            site_url + "jadwal_kerja/dataTables",
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
        Swal.fire("Server Error", "Gagal menyimpan data jadwal kerja", "error");
      },
    });
  });

  // Click Event
  $("#Hapusjadwal_kerja").click(function () {
    let bulan = $("#lstBulanHapus").val();
    let tahun = $("#lstTahunHapus").val();

    window.location.href =
      site_url +
      "jadwal_kerja/deletejadwal_kerja?bln=" +
      bulan +
      "&thn=" +
      tahun;
  });

  // Click Event
  $("#exportjadwal_kerja").click(function () {
    let bulan = $("#lstBulan").val();
    let tahun = $("#lstTahun").val();

    window.location.href =
      site_url + "jadwal_kerja/sample?bln=" + bulan + "&thn=" + tahun;
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
          url: site_url + "jadwal_kerja/delete",
          data: {
            id: id,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(
                site_url + "jadwal_kerja/dataTables",
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

    if (id == "") {
      swal("Error", "Jadwal kerja tidak ditemukan!", "error");
    } else {
      $.LoadingOverlay("show");
      $.ajax({
        type: "POST",
        url: site_url + "jadwal_kerja/detail",
        data: {
          id: id,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
            $("#updateId").val(data.id);
            $("#kodeJadwalKerjaEdit").val(data.kode);
            $("#jadwalKerjaEdit").val(data.jadwalkerja);
            $("#jamMasukEdit").val(data.jammasuk);
            $("#jamPulangEdit").val(data.jampulang);
            $("#waktuToleransiEdit").val(data.toleransi);
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
            "Gagal mengambil data jadwal kerja",
            "error"
          );
        },
      });
    }
  });
});
