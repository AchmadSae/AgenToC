let KTReceipt = function (options = {}) {
      let confirmButton;
      const defaultOptions = {
            landingRoute: "/",
      };
      const config = { ...defaultOptions, ...options };

      let confirmReceipt = function () {
            console.log("receipt");

            confirmButton.addEventListener("click", function (e) {
                  e.preventDefault();
                  Swal.fire({
                        text: "Are you sure you would like to close before save it?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, close it!",
                        cancelButtonText: "No, return",
                        customClass: {
                              confirmButton: "btn btn-primary",
                              cancelButton: "btn btn-active-light",
                        },
                  }).then(function (result) {
                        if (result.value) {
                              // redirect route
                              window.location.href = config.landingRoute;
                        } else if (result.dismiss === "cancel") {
                              Swal.fire({
                                    text: "Your receipt is not closed.",
                                    icon: "info",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                          confirmButton: "btn btn-primary",
                                    },
                              });
                        }
                  });
            });
      };
      return {
            init: function () {
                  confirmButton = document.getElementById("receipt-confirm");
                  confirmReceipt();
            },
      };
};

KTUtil.onDOMContentLoaded = function () {
      KTReceipt.init();
};
