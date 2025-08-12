"use strict";
// Ensure Dropzone does not auto bind
Dropzone.autoDiscover = false;
// Class definition
var KTCreateApp = (function () {
      // Elements
      let modal;
      let modalEl;

      let stepper;
      let form;
      let formSubmitButton;
      let formContinueButton;

      // letiables
      let stepperObj;
      const validations = [];

      // Private Functions
      const initStepper = function () {
            // Initialize Stepper
            stepperObj = new KTStepper(stepper);

            // Stepper change event(handle hiding submit button for the last step)
            stepperObj.on("kt.stepper.changed", function (stepper) {
                  if (stepperObj.getCurrentStepIndex() === 4) {
                        formSubmitButton.classList.remove("d-none");
                        formSubmitButton.classList.add("d-inline-block");
                        formContinueButton.classList.add("d-none");
                  } else if (stepperObj.getCurrentStepIndex() === 5) {
                        formSubmitButton.classList.add("d-none");
                        formContinueButton.classList.add("d-none");
                  } else {
                        formSubmitButton.classList.remove("d-inline-block");
                        formSubmitButton.classList.remove("d-none");
                        formContinueButton.classList.remove("d-none");
                  }
            });

            // Validation before going to next page
            stepperObj.on("kt.stepper.next", function (stepper) {
                  console.log("stepper.next");

                  // Validate form before change stepper step
                  let validator =
                        validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

                  if (validator) {
                        validator.validate().then(function (status) {
                              console.log("validated!");

                              if (status == "Valid") {
                                    stepper.goNext();

                                    //KTUtil.scrollTop();
                              } else {
                                    // Show error message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                    Swal.fire({
                                          text: "Sorry, looks like there are some errors detected, please try again.",
                                          icon: "error",
                                          buttonsStyling: false,
                                          confirmButtonText: "Ok, got it!",
                                          customClass: {
                                                confirmButton: "btn btn-light",
                                          },
                                    }).then(function () {
                                          //KTUtil.scrollTop();
                                    });
                              }
                        });
                  } else {
                        stepper.goNext();

                        KTUtil.scrollTop();
                  }
            });

            // Prev event
            stepperObj.on("kt.stepper.previous", function (stepper) {
                  console.log("stepper.previous");

                  stepper.goPrevious();
                  KTUtil.scrollTop();
            });

            formSubmitButton.addEventListener("click", function (e) {
                  // Validate form before change stepper step
                  let validator = validations[3]; // get validator for last form

                  validator.validate().then(function (status) {
                        console.log("validated!");

                        if (status === "Valid") {
                              // Prevent default button action
                              e.preventDefault();

                              // Disable button to avoid multiple click
                              formSubmitButton.disabled = true;

                              // Show loading indication
                              formSubmitButton.setAttribute(
                                    "data-kt-indicator",
                                    "on",
                              );

                              // Simulate form submission
                              setTimeout(function () {
                                    // Hide loading indication
                                    formSubmitButton.removeAttribute(
                                          "data-kt-indicator",
                                    );

                                    // Enable button
                                    formSubmitButton.disabled = false;

                                    stepperObj.goNext();
                                    //KTUtil.scrollTop();
                              }, 2000);
                        } else {
                              Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                          confirmButton: "btn btn-light",
                                    },
                              }).then(function () {
                                    KTUtil.scrollTop();
                              });
                        }
                  });
            });
      };

      // Init form inputs
      const initForm = function () {
            const myDropzone = new Dropzone(
                  "#kt_modal_create_checkout_file_dropzone",
                  {
                        url: "/task/file/upload", // Change this to your actual upload endpoint
                        paramName: "file",
                        maxFiles: 10,
                        maxFilesize: 10, // MB
                        addRemoveLinks: true,
                        autoProcessQueue: false, // Set to false if you want to manually process the queue
                        uploadMultiple: false,
                        parallelUploads: 10,
                        acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.docx", // Specify allowed file types
                        headers: {
                              "X-CSRF-TOKEN": document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                        },
                        init: function () {
                              var myDropzone = this;

                              // When file is added
                              this.on("addedfile", function (file) {
                                    console.log("File added: " + file.name);
                              });

                              // When upload is successful
                              this.on("success", function (file, response) {
                                    console.log(
                                          "File uploaded successfully",
                                          response,
                                    );
                                    // You can add the file info to a hidden input or process the response
                              });

                              // When there's an error
                              this.on("error", function (file, message) {
                                    console.error("Upload error:", message);
                                    this.removeFile(file);
                              });

                              // When remove button is clicked
                              this.on("removedfile", function (file) {
                                    console.log("File removed: " + file.name);
                                    // Handle file removal from server if needed
                              });
                        },
                  },
            );

            // Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
            const releaseDate = $(
                  form.querySelector('[name="settings_due_date"]'),
            );
            releaseDate.flatpickr({
                  enableTime: true,
                  dateFormat: "d, M Y, H:i",
            });

            // Make sure the directory exists when form is submitted
            form.addEventListener("submit", async function (e) {
                  e.preventDefault();
                  const dz = Dropzone.forElement(
                        "#kt_modal_create_checkout_file_dropzone",
                  );

                  // Build FormData from the form
                  const fd = new FormData(form);

                  // Append files from Dropzone (do NOT upload yet)
                  dz.getAcceptedFiles().forEach((file) => {
                        fd.append("files[]", file, file.name);
                  });

                  try {
                        const res = await fetch(form.getAttribute("action"), {
                              method: "POST",
                              headers: {
                                    "X-CSRF-TOKEN": document
                                          .querySelector(
                                                'meta[name="csrf-token"]',
                                          )
                                          .getAttribute("content"),
                              },
                              body: fd,
                        });

                        // If server responds with redirect (e.g., to receipt page)
                        if (res.redirected) {
                              window.location.href = res.url;
                              return;
                        }

                        const data = await res.json().catch(() => null);
                        if (data && data.success) {
                              // Optional: reset form / close modal / navigate
                              window.location.reload();
                        } else {
                              // If HTML returned (e.g., validation errors), replace content or show message
                              const text = await res.text();
                              console.error("Submit response:", text);
                              alert("Submit failed. Please check your inputs.");
                        }
                  } catch (err) {
                        console.error(err);
                        alert("Network error while submitting the form.");
                  }
            });
      };

      const initValidation = function () {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            // Step 1
            validations.push(
                  FormValidation.formValidation(form, {
                        fields: {
                              title: {
                                    validators: {
                                          notEmpty: {
                                                message: "Title is required",
                                          },
                                    },
                              },
                              description: {
                                    validators: {
                                          notEmpty: {
                                                message: "Description is required",
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
                  }),
            );

            // Step 2
            validations.push(
                  FormValidation.formValidation(form, {
                        fields: {
                              settings_due_date: {
                                    validators: {
                                          notEmpty: {
                                                message: "due date is required",
                                          },
                                    },
                              },
                        },
                        plugins: {
                              trigger: new FormValidation.plugins.Trigger(),
                              // Bootstrap Framework Integration
                              bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: "",
                              }),
                        },
                  }),
            );

            // Step 3
            validations.push(
                  FormValidation.formValidation(form, {
                        fields: {
                              name: {
                                    validators: {
                                          notEmpty: {
                                                message: "Name on card is required",
                                          },
                                    },
                              },
                              card_number: {
                                    validators: {
                                          notEmpty: {
                                                message: "Card member is required",
                                          },
                                          creditCard: {
                                                message: "Card number is not valid",
                                          },
                                    },
                              },
                              email: {
                                    validators: {
                                          notEmpty: {
                                                message: "Email is required",
                                          },
                                          emailAddress: {
                                                message: "The value is not a valid email address",
                                          },
                                    },
                              },
                        },

                        plugins: {
                              trigger: new FormValidation.plugins.Trigger(),
                              // Bootstrap Framework Integration
                              bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: "",
                              }),
                        },
                  }),
            );
      };

      //handel close button modal
      const handleCancelAction = () => {
            const closeButton = modalEl.querySelector(
                  '[data-kt-modal-action-type="close"]',
            );
            closeButton.addEventListener("click", (e) => {
                  cancelAction(e);
            });

            const cancelAction = (e) => {
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
            };
      };

      // Handle parse value form card to modal
      const cardDataToModal = () => {
            const modalEl = document.querySelector("#kt_modal_checkout");

            modalEl.addEventListener("show.bs.modal", (e) => {
                  const button = e.relatedTarget;

                  const data = {
                        productId: button.getAttribute("data-product-id"),
                        productCategory: button.getAttribute(
                              "data-product-category",
                        ),
                        productName: button.getAttribute("data-product-name"),
                        productPrice: button.getAttribute("data-product-price"),
                        productImage: button.getAttribute("data-product-image"),
                        productDescription: button.getAttribute(
                              "data-product-description",
                        ),
                  };

                  Object.keys(data).forEach((key) => {
                        modal.querySelector(`[data-field="${key}"]`).foreach(
                              (element) => {
                                    if (
                                          element.tagName === "INPUT" ||
                                          element.tagName === "TEXTAREA"
                                    ) {
                                          element.value = data[key];
                                    } else {
                                          element.textContent = data[key];
                                    }
                              },
                        );
                  });
            });
      };
      return {
            // Public Functions
            init: function () {
                  // Elements
                  modalEl = document.querySelector("#kt_modal_checkout");

                  if (!modalEl) {
                        return;
                  }

                  modal = new bootstrap.Modal(modalEl);

                  stepper = document.querySelector(
                        "#kt_modal_checkout_stepper",
                  );
                  form = document.querySelector("#kt_modal_checkout_form");
                  formSubmitButton = stepper.querySelector(
                        '[data-kt-stepper-action="submit"]',
                  );
                  formContinueButton = stepper.querySelector(
                        '[data-kt-stepper-action="next"]',
                  );

                  initStepper();
                  initForm();
                  initValidation();
                  handleCancelAction();
                  cardDataToModal();
            },
      };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
      KTCreateApp.init();
});
