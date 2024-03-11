<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>Login - Attendance</title>

     <link rel="shortcut icon" href="<?=base_url()?>assets/images/shortcut.png" type="image/ico" />

     <link rel="stylesheet" href="<?=base_url()?>assets/assets/compiled/css/app.css" />
     <link rel="stylesheet" href="<?=base_url()?>assets/assets/compiled/css/app-dark.css" />
     <link rel="stylesheet" href="<?=base_url()?>assets/assets/compiled/css/auth.css" />

     <!-- Sweetalert -->
     <link rel='stylesheet' href='<?=base_url();?>assets/assets/extensions/sweetalert2/sweetalert2.min.css'>
     <script src="<?=base_url();?>assets/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>

     <!-- Jquery -->
     <script src="<?=base_url()?>assets/assets/extensions/jquery/jquery.min.js"></script>
     <style>
     #auth {
          overflow: hidden;
     }

     html[data-bs-theme=dark] .form-group[class*=has-icon-] .form-control.form-control-xl {
          padding-left: 1rem;
     }

     .form-group[class*=has-icon-] .form-control.form-control-xl {
          padding-left: 1rem;
     }
     </style>
</head>

<body>
     <script src="<?=base_url()?>assets/assets/static/js/initTheme.js"></script>
     <div id="auth">
          <div class="row h-100">
               <div class="col-lg-6 col-12">
                    <div id="auth-left">
                         <!-- <div class="auth-logo mb-3">
                        <a href="index.html"><img src="<?=base_url()?>assets/images/logo.png" alt="Logo" /></a>
                    </div> -->
                         <h1 class="auth-title mt-5">Log in.</h1>
                         <p class="auth-subtitle mb-5">
                              Silakan login untuk melanjutkan.
                         </p>

                         <form action="javascript:void(0)" id="loginProcess" method="POST" data-parsley-validate>
                              <div class="form-group mb-4">
                                   <input type="text" id="nik" class="form-control form-control-xl" placeholder="NIK"
                                        required />
                              </div>
                              <div class="form-group position-relative has-icon-right mb-4">
                                   <input type="password" id="sesi" class="form-control form-control-xl"
                                        placeholder="Password" required />
                                   <div class="form-control-icon">
                                        <i class="bi bi-eye" id="password_icon"></i>
                                   </div>
                              </div>
                              <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-2">
                                   Log in
                              </button>
                         </form>
                    </div>
               </div>
               <div class="col-lg-6">
                    <div id="auth-right">
                         <img src="<?=base_url()?>assets/images/login_side.jpg" alt="" style="width:100%;">
                    </div>
               </div>
          </div>
     </div>
     <script>
     let site_url = '<?=base_url()?>';
     </script>
     <script src="<?=base_url()?>assets/js/custom/password.js"></script>
     <script src="<?=base_url()?>assets/js/authentication/login.js"></script>
</body>

</html>