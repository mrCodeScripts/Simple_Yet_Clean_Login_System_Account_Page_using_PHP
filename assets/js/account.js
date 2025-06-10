"use strict";

const uploadProfileModal = document.querySelector(".upload-profile-img-bg");
const closeUploadProfile = document.getElementById("close-btn");
const openUploadProfile = document.querySelector(".edit-img");

openUploadProfile.addEventListener("click", () => {
  uploadProfileModal.classList.remove("close-upload-profile-img");
});

closeUploadProfile.addEventListener("click", () => {
  uploadProfileModal.classList.add("close-upload-profile-img");
});
