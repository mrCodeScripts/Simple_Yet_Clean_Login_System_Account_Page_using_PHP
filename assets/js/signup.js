"use strict";

const passwordSwitches = document.querySelectorAll(".password-switch");
const openEyeIcons = document.querySelectorAll(".password-switch .eye-open");
const closeEyeIcons = document.querySelectorAll(".password-switch .eye-close");
const passwordElements = document.querySelectorAll(
  ".input-wrapper > input[type='password']"
);

passwordSwitches.forEach((el, il) => {
  el.addEventListener("click", () => {
    if (
      passwordElements[il].getAttribute("type").toLowerCase() === "password"
    ) {
      openEyeIcons[il].classList.add("hidden");
      closeEyeIcons[il].classList.remove("hidden");
      passwordElements[il].setAttribute("type", "text");
    } else if (
      passwordElements[il].getAttribute("type").toLowerCase() === "text"
    ) {
      openEyeIcons[il].classList.remove("hidden");
      closeEyeIcons[il].classList.add("hidden");
      passwordElements[il].setAttribute("type", "password");
    }
  });
});
