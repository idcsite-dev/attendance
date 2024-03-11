$(document).ready(function () {
  // Load DataTables
  $("#dataTable").load(site_url + "Karyawan/dataTables", function () {
    $("#table1").DataTable();
    initTooltips();
  });

  // Click Event
  $(document).on("click", ".detailData ", function () {
    let id = $(this).attr("id");
    $.LoadingOverlay("show");
    $.ajax({
      type: "POST",
      url: site_url + "Karyawan/detail",
      data: {
        id: id,
      },
      success: function (response) {
        console.log(response);
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          $("#detailNama").val(data.nama);
          $("#detailNIK").val(data.nik);
          $("#detailJenisKelamin").val(data.jenis_kelamin);
          $("#detailTempatLahir").val(data.tempat_lahir);
          $("#detailTglLahir").val(data.tanggal_lahir);
          $("#detailDepartemen").val(data.departemen);
          $("#detailSection").val(data.section);
          $("#detailPosisi").val(data.posisi);
          $("#detailLevel").val(data.level);
          $("#detailGolongan").val(data.golongan);
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
        Swal.fire("Server Error", "Gagal mengambil data karyawan", "error");
      },
    });
  });

  $("#syncData").click(function () {
    Swal.fire({
      title: "Apakah anda yakin ingin mengsinkronkan data karyawan ?",
      text: "Data Karyawan akan diganti dengan data yang baru!",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#198754",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Ya, Sinkronisasi Data",
      cancelButtonText: "Batal",
    }).then(function (result) {
      if (result.isConfirmed) {
        $.LoadingOverlay("show");
        $.ajax({
          type: "POST",
          url: site_url + "Karyawan/sync",
          success: function (response) {
            var data = JSON.parse(response);
            if (data.statusCode == 200) {
              $("#dataTable").load(
                site_url + "Karyawan/dataTables",
                function () {
                  $("#table1").DataTable();
                  initTooltips();
                }
              );
              $.LoadingOverlay("hide");
              Swal.fire("Berhasil", data.pesan, "success");
            } else if (data.statusCode == 204) {
              $.LoadingOverlay("hide");
              Swal.fire("Informasi", data.pesan, "info");
            } else {
              $.LoadingOverlay("hide");
              Swal.fire("Error", data.pesan, "error");
            }
          },
          error: function () {
            $.LoadingOverlay("hide");
            Swal.fire(
              "Server Error",
              "Gagal mengsinkronisasi data karyawan",
              "error"
            );
          },
        });
      }
    });
  });
});
