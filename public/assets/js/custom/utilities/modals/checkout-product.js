"use strict";

// Class definition
var KTModalNewAddress = function () {
      var submitButton;
      var cancelButton;
      let closeButton;
      var validator;
      var form;
      var modal;
      var modalEl;

      // Init form inputs
      var initForm = function() {
            var dueDate = $(form.querySelector('[name="due_date"]'));
            dueDate.flatpickr({
                  enableTime: true,
                  dateFormat: "d, M Y, H:i",
            });



            // Function to update the file list UI
            function updateFileList() {
                  const fileListContainer = document.getElementById('kt_modal_uploaded_list');
                  fileListContainer.innerHTML = ''; // Clear current list

                  myDropzone.files.forEach((file) => {
                        const fileSize = (file.size / 1024).toFixed(2) + ' KB';
                        const fileExtension = file.name.split('.').pop().toLowerCase();
                        let iconPath = 'assets/media/svg/files/doc.svg'; // Default icon

                        // Set appropriate icon based on file type
                        if (['jpg', 'jpeg', 'png', 'gif','doc', 'docx'].includes(fileExtension)) {
                              iconPath = 'assets/media/svg/files/doc.svg';
                        } else if (fileExtension === 'pdf') {
                              iconPath = 'assets/media/svg/files/pdf.svg';
                        } else if (['xls', 'xlsx'].includes(fileExtension)) {
                              iconPath = 'assets/media/svg/files/xls.svg';
                        }


                        const fileElement = document.createElement('div');
                        fileElement.className = 'd-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed';
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

                        // Add event listener for remove option
                        const select = fileElement.querySelector('select');
                        select.addEventListener('change', function() {
                              if (this.value === '1') {
                                    myDropzone.removeFile(file);
                              }
                        });

                        fileListContainer.appendChild(fileElement);
                  });
            }

            modalEl.addEventListener('show.bs.modal', function (event) {
                  const button = event.relatedTarget;

                  // Data dari tombol
                  const data = {
                        product_code: button.getAttribute('data-product-code'),
                        product_name: button.getAttribute('data-product-name'),
                        product_category: button.getAttribute('data-product-category'),
                        product_price: button.getAttribute('data-product-price'),
                        product_description: button.getAttribute('data-product-description'),
                        product_image: button.getAttribute('data-product-image')
                  };

                  Object.keys(data).forEach(key => {
                        modalEl.querySelectorAll(`[data-field="${key}"]`).forEach(el => {
                              if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                                    el.value = data[key];
                              } else {
                                    el.textContent = data[key];
                              }
                        });
                  });
            });

            // Upload multiple files
            myDropzone.on("successmultiple", function(files, response) {
                  response.file_paths.forEach(function(path) {
                        console.log('Uploaded file path: ' + path);
                        let input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "uploaded_files[]";
                        input.value = path;
                        document.querySelector("form").appendChild(input);
                  });

                  document.querySelector("form").submit();
            });
      }

      let myDropzone = function () {

            function updateFileList() {
                  const fileListContainer = document.getElementById('kt_modal_uploaded_list');
                  fileListContainer.innerHTML = ''; // Clear current list

                  myDropzone.files.forEach((file) => {
                        const fileSize = (file.size / 1024).toFixed(2) + ' KB';
                        const fileExtension = file.name.split('.').pop().toLowerCase();
                        let iconPath = 'assets/media/svg/files/doc.svg'; // Default icon

                        // Set appropriate icon based on file type
                        if (['jpg', 'jpeg', 'png', 'gif','doc', 'docx'].includes(fileExtension)) {
                              iconPath = 'assets/media/svg/files/doc.svg';
                        } else if (fileExtension === 'pdf') {
                              iconPath = 'assets/media/svg/files/pdf.svg';
                        } else if (['xls', 'xlsx'].includes(fileExtension)) {
                              iconPath = 'assets/media/svg/files/xls.svg';
                        }


                        const fileElement = document.createElement('div');
                        fileElement.className = 'd-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed';
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

                        // Add event listener for remove option
                        const select = fileElement.querySelector('select');
                        select.addEventListener('change', function() {
                              if (this.value === '1') {
                                    myDropzone.removeFile(file);
                              }
                        });

                        fileListContainer.appendChild(fileElement);
                  });
            }

            // DropzoneJS
            // Please refer to the DropzoneJS plugin's official documentation for more information: https://www.dropzonejs.com/#usage
            return myDropzone = new Dropzone("#kt_modal_checkout_files_upload", {
                  url: "/upload-file-checkout",
                  paramName: "files[]",
                  maxFiles: 3,
                  maxFilesize: 10,
                  addRemoveLinks: true,
                  autoProcessQueue: false,
                  uploadMultiple: true,
                  parallelUploads: 10,
                  acceptedFiles: ".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx",
                  headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                  },
                  // When file is added
                  addedfile: function(file) {
                        updateFileList();
                  },
                  // When file is removed
                  removedfile: function(file) {
                        updateFileList();
                        this.options.maxFiles = this.options.maxFiles + 1;
                  },
                  // When upload is complete
                  success: function(file, response) {
                        // Add the file path to a hidden input
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'uploaded_files[]';
                        input.value = response.path; // Assuming your server returns the file path
                        document.querySelector("form").appendChild(input);
                  },
                  // When all files are uploaded
                  queuecomplete: function() {
                        form.submit();
                  }
            });

      }

      var handleForm = function() {
            // Stepper custom navigation

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validator = FormValidation.formValidation(
                  form,
                  {
                        fields: {
                              'title': {
                                    validators: {
                                          notEmpty: {
                                                message: 'Title is required'
                                          }
                                    }
                              },
                              'email': {
                                    validators: {
                                          notEmpty: {
                                                message: 'Email is required'
                                          }
                                    }
                              },
                              'name': {
                                    validators: {
                                          notEmpty: {
                                                message: 'Name is required'
                                          }
                                    }
                              },
                              'description': {
                                    validators: {
                                          notEmpty: {
                                                message: 'Description is required'
                                          }
                                    }
                              },
                              'card_number':{
                                    validators: {
                                          notEmpty: {
                                                message: 'Card number is required'
                                          }
                                    }
                              },
                              plugins: {
                                    trigger: new FormValidation.plugins.Trigger(),
                                    bootstrap: new FormValidation.plugins.Bootstrap5({
                                          rowSelector: '.fv-row',
                                          eleInvalidClass: '',
                                          eleValidClass: ''
                                    })
                              }
                        }
                  }
            );

            // Action buttons
            submitButton.addEventListener('click', function (e) {
                  e.preventDefault();

                  // Validate form before submit
                  if (validator) {
                        validator.validate().then(function (status) {
                              console.log('validated!');

                              if (status === 'Valid') {
                                    if (myDropzone.getQueuedFiles().length > 0) {
                                          myDropzone.processQueue();
                                    } else {
                                          form.submit();
                                    }
                                    submitButton.setAttribute('data-kt-indicator', 'on');

                                    // Disable button to avoid multiple click
                                    submitButton.disabled = true;

                                    // Simulate ajax process
                                    setTimeout(function() {
                                          submitButton.removeAttribute('data-kt-indicator');

                                          // Enable button
                                          submitButton.disabled = false;

                                          // Show success message.  For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                          Swal.fire({
                                                text: "Form has been successfully submitted!",
                                                icon: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                customClass: {
                                                      confirmButton: "btn btn-primary"
                                                }
                                          }).then(function (result) {
                                                if (result.isConfirmed) {
                                                      modal.hide();
                                                }
                                          });

                                          //form.submit(); // Submit form
                                    }, 2000);
                              } else {
                                    // Show error message.
                                    Swal.fire({
                                          text: "Sorry, looks like there are some errors detected, please try again.",
                                          icon: "error",
                                          buttonsStyling: false,
                                          confirmButtonText: "Ok, got it!",
                                          customClass: {
                                                confirmButton: "btn btn-primary"
                                          }
                                    });
                              }
                        });
                  }
            });

            let cancelForm = () => {
                  Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {
                              confirmButton: "btn btn-primary",
                              cancelButton: "btn btn-active-light"
                        }
                  }).then(function (result) {
                        if (result.value) {
                              form.reset(); // Reset form
                              modal.hide(); // Hide modal
                        } else if (result.dismiss === 'cancel') {
                              Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                          confirmButton: "btn btn-primary",
                                    }
                              });
                        }
                  });
            }

            cancelButton.addEventListener('click', function (e) {
                  e.preventDefault();

                  cancelForm();
            });

            closeButton.addEventListener('click', function (e) {
                  e.preventDefault();

                  cancelForm();
            });
      }


      return {
            // Public functions
            init: function () {
                  // Elements
                  modalEl = document.querySelector('#kt_modal_checkout');

                  if (!modalEl) {
                        return;
                  }

                  modal = new bootstrap.Modal(modalEl);

                  form = document.querySelector('#kt_modal_checkout_form');
                  submitButton = document.getElementById('kt_modal_checkout_submit');
                  cancelButton = document.getElementById('kt_modal_checkout_cancel');
                  closeButton = document.getElementById('kt_modal_checkout_close');
                  initForm();
                  handleForm();
                  myDropzone();
            }
      };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
      KTModalNewAddress.init();
});
