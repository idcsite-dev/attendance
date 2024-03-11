$(document).ready(function () {
  // Input
  $("#nik").on("input", function (event) {
    var inputValue = $(this).val();
    var numericValue = inputValue.replace(/\D/g, "");
    $(this).val(numericValue);
  });

  // Submit Event
  $("#loginProcess").submit(function () {
    let nik = $("#nik").val();
    let sesi = $("#sesi").val();
    $.ajax({
      type: "POST",
      url: site_url + "Authentication/process",
      data: {
        nik: nik,
        sesi: sesi,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.statusCode == 200) {
          window.location.href = site_url + "dashboard";
        } else if (data.statusCode == 400) {
          Swal.fire(
            "Password Tidak Valid!",
            "Masukkan Password yang benar!",
            "warning"
          );
        } else if (data.statusCode == 401) {
          Swal.fire("Akun anda kadaluarsa!", "Hubungi administrator!", "error");
        } else {
          Swal.fire("Anda tidak terdaftar!", "Data Tidak Ditemukan!", "error");
        }
      },
      error: function () {
        Swal.fire("Server Error", "Gagal login", "error");
      },
    });
  });
});
