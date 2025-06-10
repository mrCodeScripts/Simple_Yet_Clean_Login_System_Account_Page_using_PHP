"use strict";

const passwordShowSwitch = document.getElementById("password-show-switch");

passwordShowSwitch.addEventListener("click", (e) => {
  const closeEye = document.querySelector("#eye-close");
  const openEye = document.querySelector("#eye-open");
  const passwordInput = document.getElementById("login-password");

  if (passwordInput.getAttribute("type").toLowerCase() === "password") {
    openEye.classList.add("hidden");
    closeEye.classList.remove("hidden");
    passwordInput.setAttribute("type", "text");
  } else if (passwordInput.getAttribute("type").toLowerCase() === "text") {
    openEye.classList.remove("hidden");
    closeEye.classList.add("hidden");
    passwordInput.setAttribute("type", "password");
  }
});
