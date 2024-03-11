<!-- Default -->
<script src="<?=base_url()?>assets/assets/extensions/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>assets/assets/static/js/components/dark.js"></script>
<script src="<?=base_url()?>assets/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<script src="<?=base_url()?>assets/assets/compiled/js/app.js"></script>

<script src="<?=base_url()?>assets/assets/static/js/pages/loadingoverlay.min.js"></script>
<script src="<?=base_url();?>assets/assets/static/js/pages/jquery-ui.min.js"></script>

<!-- Datatables -->
<script src="<?=base_url()?>assets/assets/static/js/pages/datatables.min.js"></script>

<!-- Parsley -->
<script src="<?=base_url()?>assets/assets/extensions/parsleyjs/parsley.min.js"></script>
<script src="<?=base_url()?>assets/assets/static/js/pages/parsley.js"></script>

<!-- Cleave -->
<script src="<?=base_url()?>assets/assets/static/js/pages/cleave.min.js"></script>

<!-- Custom -->
<script src="<?=base_url()?>assets/js/custom/password.js"></script>

<!-- datepicker -->
<script type="text/javascript" src="<?=base_url();?>assets/assets/static/js/pages/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/assets/static/js/pages/daterangepicker.min.js"></script>

<!-- inputmask -->
<script type='text/javascript' src="<?=base_url();?>assets/assets/static/js/masked/jquery.inputmask.bundle.js"></script>

<script>
// Variables
let site_url = '<?=base_url()?>';

// Change Password
$("#changePassword").submit(function() {
     let oldPassword = $('#oldPassword').val();
     let newPassword = $('#newPassword').val();
     let confirmPassword = $('#confirmPassword').val();

     Swal.fire({
          title: "Apakah Anda yakin password akan diganti?",
          text: "Password lama anda tidak akan disimpan!",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#0dcaf0",
          cancelButtonColor: "#dc3545",
          confirmButtonText: "Ganti Password",
          cancelButtonText: "Batal",
     }).then(function(result) {
          if (result.value) {
               $.LoadingOverlay("show");
               $.ajax({
                    type: "POST",
                    url: site_url + "Authority/changePassword",
                    data: {
                         oldPassword: oldPassword,
                         newPassword: newPassword,
                         confirmPassword: confirmPassword,
                    },
                    success: function(response) {
                         var data = JSON.parse(response);
                         if (data.statusCode == 200) {
                              $("#modalChangePassword").modal("hide");
                              $("#changePassword").trigger("reset");
                              $.LoadingOverlay("hide");
                              Swal.fire("Berhasil", data.pesan, "success");
                         } else {
                              $.LoadingOverlay("hide");
                              Swal.fire("Gagal", data.pesan, "error");
                         }
                    },
                    error: function() {
                         $.LoadingOverlay("hide");
                         Swal.fire("Server Error", "Gagal mengubah password!",
                              "error");
                    },
               });
          }
     });
});

// Logout
$("#logoutProcess").click(function() {
     Swal.fire({
          title: "Apakah Anda yakin ingin log out?",
          text: "Untuk mengakses aplikasi ini, harap lakukan login kembali!",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#0dcaf0",
          cancelButtonColor: "#dc3545",
          confirmButtonText: "Logout",
          cancelButtonText: "Batal",
     }).then(function(result) {
          if (result.value) {
               window.location.href = site_url + 'Authentication/logout';
          }
     });
});

// Custom Loading Overlay
$.LoadingOverlaySetup({
     image: "<?=base_url()?>assets/assets/compiled/svg/circles.svg"
});

// Flexible Tooltips
let initTooltips = function() {
     let tooltipTriggerList = [].slice.call(document.querySelectorAll(".tooltips"));
     tooltipTriggerList.map(function(tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
     });
};

// Refresh Page Universal
$(document).on("click", ".refreshPage", function() {
     location.reload();
})
</script>