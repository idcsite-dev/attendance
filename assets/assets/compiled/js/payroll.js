$(document).ready(function () {
  function getperiode() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth() + 1;

    $("#lstTahunGenProll").val(currentYear);
    $("#lstBulanGenProll").val(currentMonth);
  }

  getperiode();

  $("#tblPayroll").DataTable();
  $("#btnProsPayroll").click(function () {
    let bulan = $("#lstBulanGenProll").val();
    let tahun = $("#lstTahunGenProll").val();

    $.ajax({
      type: "POST",
      url: site_url + "data_payroll/getlastpay",
      data: {
        bulan: bulan,
        tahun: tahun,
      },
      timeout: 60000,
      success: function (response) {
        // alert(response);
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#primary").modal("show");
          $("#lstTglGenProllAwal").val(data.tgl_awal);
          $("#lstTglGenProllAkhir").val(data.tgl_akhir);
        } else {
          $("#primary").modal("show");
          $("#lstTglGenProllAwal").val(data.tgl_awal);
          $("#lstTglGenProllAkhir").val(data.tgl_akhir);
        }

        $.LoadingOverlay("hide");
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $.LoadingOverlay("hide");
        if (xhr.status == 404) {
          pesan =
            "Gagal saat mengambil data payroll terakhir, Link data tidak ditemukan";
        } else if (xhr.status == 0) {
          pesan =
            "Gagal saat mengambil data payroll terakhir, Waktu koneksi habis";
        } else {
          pesan =
            "Terjadi kesalahan saat mengambil data payroll terakhir, hubungi administrator";
        }

        Swal.fire("Gagal", pesan, "warning");
      },
    });
  });

  $(document).on("click", ".hapuspayroll", function () {
    let id_pay = $(this).attr("id");

    Swal.fire({
      title: "Hapus Data Payroll?",
      text: "Yakin data payroll akan dihapus?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, hapus!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.LoadingOverlay("show");
        $.ajax({
          type: "POST",
          url: site_url + "data_payroll/hapus",
          data: {
            id_pay: id_pay,
          },
          timeout: 60000,
          success: function (response) {
            // alert(response);
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              Swal.fire({
                title: "Sukses",
                text: data.pesan,
                icon: "success",
              }).then(function () {
                window.location.href = site_url + "data_payroll";
              });
            } else {
              Swal.fire("Gagal", data.pesan, "warning");
            }

            $.LoadingOverlay("hide");
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $.LoadingOverlay("hide");
            if (xhr.status == 404) {
              pesan = "Detail gagal dihapus, Link data tidak ditemukan";
            } else if (xhr.status == 0) {
              pesan = "Detail gagal dihapus, Waktu koneksi habis";
            } else {
              pesan =
                "Terjadi kesalahan saat menghapus data, hubungi administrator";
            }

            Swal.fire("Gagal", pesan, "warning");
          },
        });
      }
    });
  });

  $(document).on("click", ".htggajikary", function () {
    let id_pay = $("#idpay").val();
    let id_pay_kary = $(this).attr("id");
    let nik_nama = $(this).attr("value");

    Swal.fire({
      title: "Hitung Ulang Payroll?",
      text:
        "Yakin data payroll karyawan : " + nik_nama + ", akan dihitung ulang?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, hitung ulang",
    }).then((result) => {
      if (result.isConfirmed) {
        $.LoadingOverlay("show");
        $.ajax({
          type: "POST",
          url: site_url + "data_payroll/hitungulang",
          data: {
            id_pay_kary: id_pay_kary,
          },
          timeout: 3600000,
          success: function (response) {
            alert(response);
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              Swal.fire({
                title: "Sukses",
                text: data.pesan,
                icon: "success",
              }).then(function () {
                $("#tblDetailPayrollKary").load(
                  site_url +
                    "data_payroll/detail_payroll_kary?id_pay=" +
                    id_pay +
                    "&q=0&q2=0"
                );
              });
            } else {
              Swal.fire("Gagal", data.pesan, "warning");
            }

            $.LoadingOverlay("hide");
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $.LoadingOverlay("hide");
            if (xhr.status == 404) {
              pesan = "Detail gagal dihapus, Link data tidak ditemukan";
            } else if (xhr.status == 0) {
              pesan = "Detail gagal dihapus, Waktu koneksi habis";
            } else {
              pesan =
                "Terjadi kesalahan saat menghapus data, hubungi administrator";
            }

            Swal.fire("Gagal", pesan, "warning");
          },
        });
      }
    });
  });

  $(document).on("click", ".dtlkarygaji", function () {
    let id_pay_kary = $(this).attr("id");

    $("#mdlDetailKaryPayroll").modal("show");
    // $.ajax({
    //   type: "POST",
    //   url: site_url + "data_payroll/hapus",
    //   data: {
    //     id_pay: id_pay,
    //   },
    //   timeout: 60000,
    //   success: function (response) {
    //     // alert(response);
    //     var data = JSON.parse(response);
    //     if (data.statusCode == 200) {
    //       Swal.fire({
    //         title: "Sukses",
    //         text: data.pesan,
    //         icon: "success",
    //       }).then(function () {
    //         window.location.href = site_url + "data_payroll";
    //       });
    //     } else {
    //       Swal.fire("Gagal", data.pesan, "warning");
    //     }

    //     $.LoadingOverlay("hide");
    //   },
    //   error: function (xhr, ajaxOptions, thrownError) {
    //     $.LoadingOverlay("hide");
    //     if (xhr.status == 404) {
    //       pesan = "Detail gagal dihapus, Link data tidak ditemukan";
    //     } else if (xhr.status == 0) {
    //       pesan = "Detail gagal dihapus, Waktu koneksi habis";
    //     } else {
    //       pesan =
    //         "Terjadi kesalahan saat menghapus data, hubungi administrator";
    //     }

    //     Swal.fire("Gagal", pesan, "warning");
    //   },
    // });
  });

  $(document).on("click", ".dtlPayroll", function () {
    let id_pay = $(this).attr("id");

    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "data_payroll/detail_payroll",
      data: {
        id_pay: id_pay,
      },
      timeout: 60000,
      success: function (response) {
        //    alert(response);
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#mdlDetailPayroll").modal("show");
          $("#jdlMdlDetailPayroll").text(
            "Detail Payroll | Periode : " + data.bulan + " " + data.tahun
          );
          $("#tblDetailPayrollKary").load(
            site_url +
              "data_payroll/detail_payroll_kary?id_pay=" +
              id_pay +
              "&q=0&q2=0"
          );
          $("#idpay").val(id_pay);
        } else {
          Swal.fire("Gagal", data.pesan, "warning");
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $.LoadingOverlay("hide");
        if (xhr.status == 404) {
          pesan = "Detail gagal ditampilkan, Link data tidak ditemukan";
        } else if (xhr.status == 0) {
          pesan = "Detail gagal ditampilkan, Waktu koneksi habis";
        } else {
          pesan =
            "Terjadi kesalahan saat menampilkan data, hubungi administrator";
        }

        Swal.fire("Gagal", pesan, "warning");
      },
    });
  });

  function genpayroll() {
    console.time();
    let bulan = $("#lstBulanGenProll").val();
    let tahun = $("#lstTahunGenProll").val();
    let tglawal = $("#lstTglGenProllAwal").val();
    let tglakhir = $("#lstTglGenProllAkhir").val();

    $.LoadingOverlay("show");

    $.ajax({
      type: "POST",
      url: site_url + "data_payroll/add_payroll",
      data: {
        bulan: bulan,
        tahun: tahun,
        tglawal: tglawal,
        tglakhir: tglakhir,
      },
      timeout: 3600000,
      success: function (response) {
        alert(response);
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $.LoadingOverlay("hide");
          var waktu = console.timeEnd();
          Swal.fire({
            title: "Sukses",
            text: data.pesan,
            icon: "success",
          }).then(function () {
            $("#primary").modal("hide");
            window.location.href = site_url + "data_payroll";
          });
        } else {
          Swal.fire("Gagal", data.pesan, "warning");
        }
        // $.LoadingOverlay("hide");
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $.LoadingOverlay("hide");
        if (xhr.status == 404) {
          pesan = "Generate payroll gagal, Link data tidak ditemukan";
        } else if (xhr.status == 0) {
          pesan = "Generate payroll gagal, Waktu koneksi habis";
        } else {
          pesan =
            "Terjadi kesalahan saat men-generate payroll, hubungi administrator";
        }

        Swal.fire("Gagal", pesan, "warning");
      },
    });
  }

  $("#btnGenPayroll").click(function () {
    let bulan = $("#lstBulanGenProll").val();
    let tahun = $("#lstTahunGenProll").val();

    var months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];

    bulan = months[bulan - 1];

    Swal.fire({
      title: "Proses Payroll?",
      text:
        "Proses payroll periode bulan " +
        bulan +
        " " +
        tahun +
        "? pastikan semua data pendukung telah lengkap dan benar",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, proses",
    }).then((result) => {
      if (result.isConfirmed) {
        genpayroll();
      }
    });
  });

  // $("#btnSlipGajiAll").click(function () {
  //   let id_pay = $("#idpay").val();
  //   let depart = $("#lstDepartPRoll").val();
  //   let tipe = $("#lstTipePRoll").val();
  // });

  $("#btnTampilProll").click(function () {
    let id_pay = $("#idpay").val();
    let depart = $("#lstDepartPRoll").val().replace(/\s/g, "|");
    let tipe = $("#lstTipePRoll").val();

    if (depart == "") {
      depart = 0;
    }

    if (tipe == "") {
      tipe = 0;
    }

    $("#tblDetailPayrollKary").load(
      site_url +
        "data_payroll/detail_payroll_kary?id_pay=" +
        id_pay +
        "&q=" +
        depart +
        "&q2=" +
        tipe
    );
  });

  $("#btnExpGajiKeExcel").click(function () {
    let dt_href = $(this).attr("dt-href");
    let idpay = $("#idpay").val();

    if (idpay == "") {
      alert("Data wajib dipilih");
      return;
    } else {
      window.location.href = dt_href + "?q=" + idpay;
    }
  });

  $("#btnSlipGajiAll").click(function () {
    let id_pay = $("#idpay").val();
    let href = $(this).attr("dt-href");

    window.open(href + "?q=" + id_pay, "_blank");
  });

  $("#btnImpGajiKeExcel").click(function () {
    $("#modalImport").modal("show");
    // alert("asd");
  });

  $("#importGaji").submit(function () {
    let bulan = $("#lstBulanImp").val();
    let tahun = $("#lstTahunImp").val();
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
      formData.append("bulan", bulan);
      formData.append("tahun", tahun);
      $.ajax({
        type: "POST",
        url: site_url + "data_payroll/import",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // alert(response);
          var data = JSON.parse(response);
          if (data.statusCode == 200) {
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
          Swal.fire("Server Error", "Gagal mengimport data gaji", "error");
        },
      });
    }
  });
});
