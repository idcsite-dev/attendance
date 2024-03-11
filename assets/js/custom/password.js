function ShowAndHide(inputID, iconID) {
  document.getElementById(`${iconID}`).addEventListener("click", function () {
    let formPasswordToggleIcon = document.getElementById(`${iconID}`);
    let formPasswordToggleInput = document.getElementById(`${inputID}`);

    if (formPasswordToggleInput.getAttribute("type") === "text") {
      formPasswordToggleInput.setAttribute("type", "password");
      formPasswordToggleIcon.classList.remove("bi-eye-slash");
      formPasswordToggleIcon.classList.add("bi-eye");
    } else if (formPasswordToggleInput.getAttribute("type") === "password") {
      formPasswordToggleInput.setAttribute("type", "text");
      formPasswordToggleIcon.classList.remove("bi-eye");
      formPasswordToggleIcon.classList.add("bi-eye-slash");
    }
  });
}
if (document.getElementById("sesi")) {
  ShowAndHide("sesi", "password_icon");
}

if (document.getElementById("updateSesi")) {
  ShowAndHide("updateSesi", "update_password_icon");
}

if (document.getElementById("oldPassword")) {
  ShowAndHide("oldPassword", "oldPasswordIcon");
}

if (document.getElementById("newPassword")) {
  ShowAndHide("newPassword", "newPasswordIcon");
}

if (document.getElementById("confirmPassword")) {
  ShowAndHide("confirmPassword", "confirmPasswordIcon");
}
