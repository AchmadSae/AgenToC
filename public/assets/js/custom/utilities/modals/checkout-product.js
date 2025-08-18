"use strict";

// Class definition
var KTModalCheckout = (function () {
      let submitButton;
      let cancelButton;
      let closeButton;
      let validator;
      let form;
      let modal;
      let modalEl;
      let dropzoneInstance;
      let inputEmail;
      let is_registered;
      let myDropzone = function () {
            Dropzone.autoDiscover = false;
            // Initialize Dropzone
            const dropzoneElement = document.querySelector(
                  "#kt_modal_checkout_files_upload",
            );
            const checkoutForm = document.querySelector(
                  "#kt_modal_checkout_form",
            );
            const submitButton = document.querySelector(
                  "#kt_modal_checkout_submit",
            );
            function updateFileList(files) {
                  const fileListContainer = document.getElementById(
                        "kt_modal_uploaded_list",
                  );
                  fileListContainer.innerHTML = ""; // Clear current list
                  if (!files || !files.length) {
                        fileListContainer.innerHTML =
                              "<li>No files uploaded yet.</li>";
                        return;
                  }
                  files.forEach((file) => {
                        const fileSize = (file.size / 1024).toFixed(2) + " KB";
                        const fileExtension = file.name
                              .split(".")
                              .pop()
                              .toLowerCase();
                        let iconPath = "assets/media/svg/files/doc.svg"; // Default icon

                        // Set appropriate icon based on file type
                        if (
                              [
                                    "jpg",
                                    "jpeg",
                                    "png",
                                    "gif",
                                    "doc",
                                    "docx",
                              ].includes(fileExtension)
                        ) {
                              iconPath = "assets/media/svg/files/doc.svg";
                        } else if (fileExtension === "pdf") {
                              iconPath = "assets/media/svg/files/pdf.svg";
                        } else if (["xls", "xlsx"].includes(fileExtension)) {
                              iconPath = "assets/media/svg/files/xls.svg";
                        }

                        const fileElement = document.createElement("div");
                        fileElement.className =
                              "d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed";
                        fileElement.innerHTML = `
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-35px me-5">
                                <img src="${iconPath}" alt="${fileExtension}" />
                            </div>
                            <div class="ms-6">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">${file.name}</a>
                                <div class="fw-semibold text-muted">${fileSize}</div>
                            </div>
                        </div>
                        <div class="min-w-100px">
                            <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Edit">
                                <option></option>
                                <option value="1">Remove</option>
                                <option value="2">Modify</option>
                                <option value="3">Select</option>
                            </select>
                        </div>
                    `;
                        fileListContainer.appendChild(fileElement);
                  });
                  // // Event Dropzone
                  // myDropzone.on("addedfile", function() {
                  //       updateFileList(dropzoneInstance.files); // Kirim daftar file
                  // });
                  //
                  // myDropzone.on("removedfile", function() {
                  //       updateFileList(dropzoneInstance.files); // Update lagi setelah remove
                  // });
            }
            // Create a new Dropzone instance
            dropzoneInstance = new Dropzone(dropzoneElement, {
                  url: "/upload-file-checkout",
                  paramName: "files",
                  maxFiles: 3,
                  maxFilesize: 10,
                  addRemoveLinks: true,
                  autoProcessQueue: false,
                  uploadMultiple: true,
                  parallelUploads: 10,
                  acceptedFiles: ".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx",
                  headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                              'meta[name="csrf-token"]',
                        ).content,
                  },

                  init: function () {
                        const dz = this;
                        let uploadTimeout;
                        dz.on("addedfile", function () {
                              updateFileList(dz.files);
                        });

                        dz.on("removedfile", function () {
                              updateFileList(dz.files);
                        });

                        dz.on("sendingmultiple", function () {
                              console.log("Starting file upload...");
                              uploadTimeout = setTimeout(function () {
                                    if (dz.files.length > 0) {
                                          dz.cancelUpload(
                                                dz.getUploadingFiles()[0],
                                          );
                                          Swal.fire({
                                                text: "Upload timed out. Please try again with a smaller file or better connection.",
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "OK",
                                          });
                                          submitButton.removeAttribute(
                                                "data-kt-indicator",
                                          );
                                          submitButton.disabled = false;
                                    }
                              }, 300000); // 5 minutes
                        });

                        dz.on("successmultiple", function (files, response) {
                              console.log("Upload successful:", response);

                              if (
                                    response &&
                                    response.status &&
                                    response.file_paths
                              ) {
                                    // Remove any existing file inputs to prevent duplicates
                                    checkoutForm
                                          .querySelectorAll(
                                                'input[name="uploaded_files[]"]',
                                          )
                                          .forEach((input) => input.remove());

                                    // Add new file inputs
                                    response.file_paths.forEach(
                                          function (path) {
                                                let input =
                                                      document.createElement(
                                                            "input",
                                                      );
                                                input.type = "hidden";
                                                input.name = "uploaded_files[]";
                                                input.value = path;
                                                checkoutForm.appendChild(input);
                                          },
                                    );

                                    console.log("Submitting form...");
                                    checkoutForm.submit();
                              } else {
                                    console.error(
                                          "Response not valid:",
                                          response,
                                    );
                                    submitButton.removeAttribute(
                                          "data-kt-indicator",
                                    );
                                    submitButton.disabled = false;
                              }
                        });

                        dz.on("errormultiple", function (files, message) {
                              console.error("Upload error:", message);
                              submitButton.removeAttribute("data-kt-indicator");
                              submitButton.disabled = false;

                              Swal.fire({
                                    text: "Error uploading files. Please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                              });
                        });
                  },
            });
      };
      // Init form inputs
      var initForm = function () {
            var dueDate = $(form.querySelector('[name="due_date"]'));
            dueDate.flatpickr({
                  enableTime: true,
                  dateFormat: "Y-m-d H:i", // This matches the HTML5 datetime-local format
                  time_24hr: true,
                  altInput: true,
                  altFormat: "d, M Y, H:i", // This is just for display
                  defaultDate: new Date(), // Optional: set a default date
                  minDate: "today",
            });
            // Function to update the file list UI

            modalEl.addEventListener("show.bs.modal", function (event) {
                  const button = event.relatedTarget;

                  // Data dari tombol

                  let product_code = button.getAttribute("data-product-code");
                  let product_name = button.getAttribute("data-product-name");
                  let product_category = button.getAttribute(
                        "data-product-category",
                  );
                  let product_price = button.getAttribute("data-product-price");
                  let product_description = button.getAttribute(
                        "data-product-description",
                  );
                  let product_image = button.getAttribute("data-product-image");
                  let product_group_name = button.getAttribute(
                        "data-product-group-name",
                  );
                  $("#kt_modal_checkout_product_code").val(product_code);
                  $("#kt_modal_checkout_title").text(product_name);
                  $("#kt_modal_checkout_product_group_name").val(
                        product_group_name,
                  );
                  $("#kt_modal_checkout_product_price").val(product_price);
            });
      };

      // Handle form validation and submittion
      var handleForm = function () {
            // Stepper custom navigation

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validator = FormValidation.formValidation(form, {
                  fields: {
                        title: {
                              validators: {
                                    notEmpty: {
                                          message: "Title is required",
                                    },
                              },
                        },
                        email: {
                              validators: {
                                    notEmpty: {
                                          message: "Email is required",
                                    },
                                    emailAddress: {
                                          message: "Please enter a valid email address",
                                    },
                              },
                        },
                        description: {
                              validators: {
                                    notEmpty: {
                                          message: "descriptions is required",
                                    },
                              },
                        },
                        name: {
                              validators: {
                                    notEmpty: {
                                          message: "Name is required",
                                    },
                              },
                        },
                        card_number: {
                              validators: {
                                    notEmpty: {
                                          message: "card number is required",
                                    },
                              },
                        },
                  },
                  plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                              rowSelector: ".fv-row",
                              eleInvalidClass: "",
                              eleValidClass: "",
                        }),
                  },
            });

            // Action buttons
            submitButton.addEventListener("click", function (e) {
                  e.preventDefault();

                  // Validate form before submit
                  if (validator) {
                        validator.validate().then(function (status) {
                              console.log("Form validation status:", status);

                              if (status === "Valid") {
                                    // Show loading state
                                    submitButton.setAttribute(
                                          "data-kt-indicator",
                                          "on",
                                    );
                                    submitButton.disabled = true;

                                    // Check if there are files to upload
                                    const filesToUpload =
                                          dropzoneInstance.files;
                                    console.log(
                                          "Files to upload:",
                                          filesToUpload.length,
                                    );

                                    if (filesToUpload.length > 0) {
                                          console.log(
                                                "Starting file upload process...",
                                          );
                                          dropzoneInstance.processQueue();
                                    } else {
                                          console.log(
                                                "No files to upload, submitting form directly",
                                          );
                                          form.submit();
                                    }
                              } else {
                                    // Show error message.
                                    Swal.fire({
                                          text: "Sorry, looks like there are some errors detected, please try again.",
                                          icon: "error",
                                          buttonsStyling: false,
                                          confirmButtonText: "Ok, got it!",
                                          customClass: {
                                                confirmButton:
                                                      "btn btn-primary",
                                          },
                                    });
                              }
                        });
                  }
            });

            cancelButton.addEventListener("click", function (e) {
                  e.preventDefault();

                  Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {
                              confirmButton: "btn btn-primary",
                              cancelButton: "btn btn-active-light",
                        },
                  }).then(function (result) {
                        if (result.value) {
                              form.reset(); // Reset form
                              modal.hide(); // Hide modal
                        } else if (result.dismiss === "cancel") {
                              Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                          confirmButton: "btn btn-primary",
                                    },
                              });
                        }
                  });
            });
            closeButton.addEventListener("click", function (e) {
                  Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {
                              confirmButton: "btn btn-primary",
                              cancelButton: "btn btn-active-light",
                        },
                  }).then(function (result) {
                        if (result.value) {
                              form.reset(); // Reset form
                              modal.hide(); // Hide modal
                        } else if (result.dismiss === "cancel") {
                              Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                          confirmButton: "btn btn-primary",
                                    },
                              });
                        }
                  });
            });

            // Add change event listener
            is_registered.addEventListener("change", function () {
                  this.value = this.checked ? "1" : "0";
                  const email = inputEmail.value.trim();
                  console.log("Checkbox value changed to:", this.value);
                  if (!email || !isValidEmail(email) || !this.checked) {
                        inputEmail.setCustomValidity("");
                        return;
                  }

                  console.log("Checking email:", email, "flag:", this.value);

                  $.ajax({
                        type: "GET",
                        url: "/isRegistered/" + email,
                        success: function (response) {
                              console.log("Email check response:", response);

                              if (response && response.status) {
                                    // Email exists
                                    console.log(response.data, email);
                                    // Set the card number and name from the response
                                    $("#kt_modal_checkout_card_number").val(
                                          response.data.card_number,
                                    );
                                    $("#kt_modal_checkout_name").val(
                                          response.data.name,
                                    );

                                    inputEmail.setCustomValidity(
                                          "Your is registered with us",
                                    );
                              } else {
                                    // Email does not exist
                                    Swal.fire({
                                          text: response.data,
                                          icon: "info",
                                          buttonsStyling: false,
                                          confirmButtonText: "Ok, got it!",
                                          customClass: {
                                                confirmButton:
                                                      "btn btn-primary",
                                          },
                                    });
                                    inputEmail.setCustomValidity("");
                              }

                              // Trigger validation UI update
                              inputEmail.reportValidity();
                        },
                        error: function (xhr, status, error) {
                              console.error("Email check failed:", {
                                    status: status,
                                    error: error,
                                    responseText: xhr.responseText,
                              });
                        },
                  });
            });
            // Helper function to validate email format
            function isValidEmail(email) {
                  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                  return re.test(email);
            }
      };

      return {
            // Public functions
            init: function () {
                  // Elements
                  modalEl = document.querySelector("#kt_modal_checkout");

                  if (!modalEl) {
                        return;
                  }

                  modal = new bootstrap.Modal(modalEl);

                  form = document.querySelector("#kt_modal_checkout_form");
                  submitButton = document.getElementById(
                        "kt_modal_checkout_submit",
                  );
                  cancelButton = document.getElementById(
                        "kt_modal_checkout_cancel",
                  );
                  closeButton = document.getElementById(
                        "kt_modal_checkout_close",
                  );
                  inputEmail = document.getElementById(
                        "kt_modal_checkout_email",
                  );
                  is_registered = document.getElementById(
                        "kt_modal_checkout_is_registered",
                  );
                  myDropzone();
                  initForm();
                  handleForm();
            },
      };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
      KTModalCheckout.init();
});
