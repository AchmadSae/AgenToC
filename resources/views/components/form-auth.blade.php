@props([
'method' => 'POST',
'id' => 'kt_sign_up_form',
'directUrl' => 'login',
'action',
'title'=> 'Sign Up to our platform',
'description' => '',
'form',
'typeRegister' => 'user',
])
<form method="{{ $method }}" class="form w-100" novalidate="novalidate" id="{{ $id }}"
    data-kt-redirect-url="{{ route($directUrl) }}" action="{{ route($action) }}">
    @csrf
    <!--begin::Heading-->
    <div class="text-start mb-10">
        <x-validation-errors />
    </div>
    <div class="text-start mb-10">
        <!--begin::Title-->
        <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="{{ $form }}-title">{{ $title }}
        </h1>
        <!--end::Title-->
        <!--begin::Text-->
        <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="general-desc">
            {{ $description }}
        </div>
        <!--end::Link-->
    </div>
    <!--end::Heading-->
      <!-- begin::defin form auth -->
      @switch($form)
            @case('sign-in')
                <!-- begin::Input group Role -->
                <div class="fv-row mb-10">
                    <select class="form-select form-control-lg form-control-solid" aria-label="role" style="cursor: pointer;"
                        name="role">
                        <option value="user">User</option>
                        <option value="worker">Worker</option>
                    </select>
                </div>
                <div class="fv-row mb-10">
                        <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Username" name="username"
                             autocomplete="off" data-kt-translate="sign-in-input-username" />
                </div>
                <div class="position-relative mb-3">
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="Password"
                               name="password" autocomplete="off" data-kt-translate="sign-in-input-password" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                              data-kt-password-meter-control="visibility">
                                          <i class="ki-duotone ki-eye-slash fs-2"></i>
                                          <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                    </span>
                </div>
                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
                        <div></div>
                        <!--begin::Link-->
                        <a href="{{ route('show-pass-request') }}" class="link-primary" data-kt-translate="sign-in-forgot-password">Forgot Password ?</a>
                        <!--end::Link-->
                </div>
                  @break
            @case('sign-up')
                  <input type="text" name="role" value="{{ $typeRegister }}" hidden>
                  <div class="row fv-row mb-7 fv-plugins-icon-container">
                        <!--begin::Col-->
                        <div class="col-xl-6">
                              <input class="form-control form-control-lg form-control-solid" type="text" placeholder="First Name" name="first-name" autocomplete="off" data-kt-translate="sign-up-input-first-name">
                              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-xl-6">
                              <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Last Name" name="last-name" autocomplete="off" data-kt-translate="sign-up-input-last-name">
                              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                        <!--end::Col-->
                  </div>
                  <div class="fv-row mb-10">
                        <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Username" name="username"
                               autocomplete="off" data-kt-translate="sign-up-input-first-name" />
                  </div>
                  <div class="fv-row mb-10">
                        <input class="form-control form-control-lg form-control-solid" type="email" placeholder="Email" name="email"
                               autocomplete="off" data-kt-translate="sign-up-input-email" />
                  </div>
                  <div class="fv-row mb-10" data-kt-password-meter="true">
                        <!--begin::Wrapper-->
                        <div class="mb-1">
                              <!--begin::Input wrapper-->
                              <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="Password"
                                           name="password" autocomplete="off" data-kt-translate="sign-up-input-password" />
                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                          data-kt-password-meter-control="visibility">
                                          <i class="ki-duotone ki-eye-slash fs-2"></i>
                                          <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                    </span>
                              </div>
                              <!--end::Input wrapper-->
                              <!--begin::Meter-->
                              <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                              </div>
                              <!--end::Meter-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Hint-->
                        <div class="text-muted" data-kt-translate="sign-up-hint">Use 8 or more characters with a mix
                              of
                              letters,
                              numbers & symbols.</div>
                        <!--end::Hint-->
                  </div>
                  <div class="fv-row mb-10 fv-plugins-icon-container">
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="Confirm Password" name="confirm-password" autocomplete="off" data-kt-translate="sign-up-input-confirm-password">
                  <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                  @break
            @default
                  <div class="fv-row mb-10">
                        <img src="{{ asset('assets/media/auth/404-error.png') }} " class="mw-100 mh-300px theme-light-show" alt="">
                        <img src="{{ asset('assets/media/auth/404-error-dark.png') }} " class="mw-100 mh-300px theme-dark-show" alt="">
                  </div>
            @break
      @endswitch

    <!-- end::defin form auth -->

    <!--begin::Actions-->
    <div class="d-flex flex-stack">
        <!--begin::Submit-->
        <button id="kt_sign-up_submit" class="btn btn-primary" data-kt-translate="{{ $form }}-submit">
            <!--begin::Indicator label-->
            <span class="indicator-label">Submit</span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
        <!--end::Submit-->
        <!--begin::Social-->
        <div class="d-flex align-items-center">
            <div class="text-gray-500 fw-semibold fs-6 me-6">Or</div>
            <!--begin::Symbol-->
            <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light me-3">
                <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/google-icon.svg') }}" class="p-4" />
            </a>
            <!--end::Symbol-->
            <!--begin::Symbol-->
            <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light me-3">
                <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/facebook-4.svg') }}" class="p-4" />
            </a>
            <!--end::Symbol-->
            <!--begin::Symbol-->
            <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light">
                <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/apple-black.svg') }}"
                    class="theme-light-show p-4" />
                <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/apple-white.svg') }}"
                    class="theme-dark-show p-4" />
            </a>
            <!--end::Symbol-->
        </div>
        <!--end::Social-->
    </div>
    <!--end::Actions-->
</form>
