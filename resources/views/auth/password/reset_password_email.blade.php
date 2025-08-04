<x-guest-lay>
      <x-slot:title>
            Reset Password
      </x-slot:title>
      <!--begin::Page bg image-->
      <style>body { background-image: url({{ asset('assets/media/auth/bg10.jpeg') }}); } [data-bs-theme="dark"] body { background-image: url({{ asset('assets/media/auth/bg10-dark.jpeg') }}); }</style>
      <!--end::Page bg image-->
      <!--begin::Authentication - Password reset -->
      <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid">
                  <!--begin::Content-->
                  <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                        <!--begin::Image-->
                        <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('assets/media/auth/agency.png') }}" alt="" />
                        <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('assets/media/auth/agency-dark.png') }}" alt="" />
                        <!--end::Image-->
                        <!--begin::Title-->
                        <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post,
                              <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed
                              <br />and provides some background information about
                              <a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their
                              <br />work following this is a transcript of the interview.</div>
                        <!--end::Text-->
                  </div>
                  <!--end::Content-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                  <!--begin::Wrapper-->
                  <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                        <!--begin::Content-->
                        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                              <!--begin::Wrapper-->
                              <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                                    <!--begin::Form-->
                                    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="{{ route('sign-in') }}" action="{{ route('link-email') }}">
                                          <!--begin::Heading-->
                                          <div class="text-center mb-10">
                                                <!--begin::Title-->
                                                <h1 class="text-gray-900 fw-bolder mb-3">Forgot Password ?</h1>
                                                <!--end::Title-->
                                                <!--begin::Link-->
                                                <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
                                                <!--end::Link-->
                                          </div>
                                          <!--begin::Heading-->
                                          <!--begin::Input group=-->
                                          <div class="fv-row mb-8">
                                                <!--begin::Email-->
                                                <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                                                <!--end::Email-->
                                          </div>
                                          <!--begin::Actions-->
                                          <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                                <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
                                                      <!--begin::Indicator label-->
                                                      <span class="indicator-label">Submit</span>
                                                      <!--end::Indicator label-->
                                                      <!--begin::Indicator progress-->
                                                      <span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                      <!--end::Indicator progress-->
                                                </button>
                                                <a href="{{ route('sign-up') }}" class="btn btn-light">Cancel</a>
                                          </div>
                                          <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                              </div>
                              <!--end::Wrapper-->
                              <!--begin::Footer-->
                              <div class="w-lg-500px d-flex flex-stack">
                                    <!--begin::Languages-->
                                    <div class="me-10">
                                          <!--begin::Toggle-->
                                          <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                                <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="assets/media/flags/united-states.svg" alt="" />
                                                <span data-kt-element="current-lang-name" class="me-1">English</span>
                                                <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                                          </button>
                                          <!--end::Toggle-->
                                          <!--begin::Menu-->
                                          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/united-states.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">English</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/spain.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">Spanish</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/germany.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">German</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/japan.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">Japanese</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/france.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">French</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                          </div>
                                          <!--end::Menu-->
                                    </div>
                                    <!--end::Languages-->
                                    <!--begin::Links-->
                                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                          <a href="pages/team.html" target="_blank">Terms</a>
                                          <a href="pages/pricing/column.html" target="_blank">Plans</a>
                                          <a href="pages/contact.html" target="_blank">Contact Us</a>
                                    </div>
                                    <!--end::Links-->
                              </div>
                              <!--end::Footer-->
                        </div>
                        <!--end::Content-->
                  </div>
                  <!--end::Wrapper-->
            </div>
            <!--end::Body-->
      </div>
      <!--end::Authentication - Password reset-->
</x-guest-lay>
