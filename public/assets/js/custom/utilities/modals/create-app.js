"use strict";
// Class definition
var KTCreateApp = function () {
	// Elements
	var modal;
	var modalEl;

	var stepper;
	var form;
	var formSubmitButton;
	var formContinueButton;

	// Variables
	var stepperObj;
	var validations = [];

	// Private Functions
	var initStepper = function () {
		// Initialize Stepper
		stepperObj = new KTStepper(stepper);

		// Stepper change event(handle hiding submit button for the last step)
		stepperObj.on('kt.stepper.changed', function (stepper) {
			if (stepperObj.getCurrentStepIndex() === 4) {
				formSubmitButton.classList.remove('d-none');
				formSubmitButton.classList.add('d-inline-block');
				formContinueButton.classList.add('d-none');
			} else if (stepperObj.getCurrentStepIndex() === 5) {
				formSubmitButton.classList.add('d-none');
				formContinueButton.classList.add('d-none');
			} else {
				formSubmitButton.classList.remove('d-inline-block');
				formSubmitButton.classList.remove('d-none');
				formContinueButton.classList.remove('d-none');
			}
		});

		// Validation before going to next page
		stepperObj.on('kt.stepper.next', function (stepper) {
			console.log('stepper.next');

			// Validate form before change stepper step
			var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
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
								confirmButton: "btn btn-light"
							}
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
		stepperObj.on('kt.stepper.previous', function (stepper) {
			console.log('stepper.previous');

			stepper.goPrevious();
			KTUtil.scrollTop();
		});

	}

	// Init form inputs
	var initForm = function() {
            var dueDate = $(form.querySelector('[name="due_date"]'));
            dueDate.flatpickr({
                  enableTime: true,
                  dateFormat: "d, M Y, H:i",
            });

            let myDropzone = new Dropzone("#kt_modal_checkout_files_upload", {
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

            // Event tombol submit form
            formSubmitButton.addEventListener('click', function(e) {
                  e.preventDefault();

                  var validator = validations[3]; // Validator step terakhir
                  validator.validate().then(function(status) {
                        if (status === 'Valid') {
                              formSubmitButton.disabled = true;
                              formSubmitButton.setAttribute('data-kt-indicator', 'on');

                              if (myDropzone.getQueuedFiles().length > 0) {
                                    myDropzone.processQueue();
                              } else {
                                    form.submit();
                              }
                        } else {
                              Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn btn-light" }
                              });
                        }
                  });
            });

            // Setelah upload selesai
            myDropzone.on("successmultiple", function(files, response) {
                  response.file_paths.forEach(function(path) {
                        let input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "uploaded_files[]";
                        input.value = path;
                        document.querySelector("form").appendChild(input);
                  });

                  document.querySelector("form").submit();
            });
      }



	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message: 'App name is required'
							}
						}
					},
					category: {
						validators: {
							notEmpty: {
								message: 'Category is required'
							}
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
		));

		// Step 2
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					framework: {
						validators: {
							notEmpty: {
								message: 'Framework is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		));

		// Step 3
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					dbname: {
						validators: {
							notEmpty: {
								message: 'Database name is required'
							}
						}
					},
					dbengine: {
						validators: {
							notEmpty: {
								message: 'Database engine is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		));

		// Step 4
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					'card_name': {
						validators: {
							notEmpty: {
								message: 'Name on card is required'
							}
						}
					},
					'card_number': {
						validators: {
							notEmpty: {
								message: 'Card member is required'
							},
                            creditCard: {
                                message: 'Card number is not valid'
                            }
						}
					},
					'card_expiry_month': {
						validators: {
							notEmpty: {
								message: 'Month is required'
							}
						}
					},
					'card_expiry_year': {
						validators: {
							notEmpty: {
								message: 'Year is required'
							}
						}
					},
					'card_cvv': {
						validators: {
							notEmpty: {
								message: 'CVV is required'
							},
							digits: {
								message: 'CVV must contain only digits'
							},
							stringLength: {
								min: 3,
								max: 4,
								message: 'CVV must contain 3 to 4 digits only'
							}
						}
					}
				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		));
	}
      let handleCancelAction;
      handleCancelAction = () => {
            const closeButton = modalEl.querySelector('[data-kt-modal-action-type="close"]');
            closeButton.addEventListener('click', e => {
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
      };

      return {
		// Public Functions
		init: function () {
			// Elements
			modalEl = document.querySelector('#kt_modal_checkout');

			if (!modalEl) {
				return;
			}

			modal = new bootstrap.Modal(modalEl);

			stepper = document.querySelector('#kt_modal_checkout_stepper');
			form = document.querySelector('#kt_modal_checkout_form');
			formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
			formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');

			initStepper();
			initForm();
			initValidation();
                  handleCancelAction();
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTCreateApp.init();
});
