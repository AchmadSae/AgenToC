@props([
    'method' => 'POST',
    'id' => 'kt_sign_up_form',
    'directUrl' => 'login',
    'action' => 'register',
    'title'=> 'Sign Up to our platform',
    'description' => '',
    'typeRegister'=> 'User'

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
        <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="sign-up-title">{{ $title }}
        </h1>
    <!--end::Title-->
        <!--begin::Text-->
        <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="general-desc">
            {{ $description }}    
        </div>
        <!--end::Link-->
    </div>
    <!--end::Heading-->
    <!--begin:: hidden input for decide form -->
    <input type="hidden" name="role" value="{{ $typeRegister }}">
    <!-- end:: hidden input -->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
        <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Username" name="name"
            autocomplete="off" data-kt-translate="sign-up-input-first-name" />
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
        <input class="form-control form-control-lg form-control-solid" type="email" placeholder="Email" name="email"
            autocomplete="off" data-kt-translate="sign-up-input-email" />
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
        <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Skills Focus" name="skill"
            autocomplete="off" />
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
        <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Show Your Tag Line" name="tagline"
            autocomplete="off" />
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
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
    <!--end::Input group=-->
    <!--begin::Input group-->
    <div class="fv-row mb-10">
        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="Confirm Password"
            name="password_confirmation" autocomplete="off" data-kt-translate="sign-up-input-confirm-password" />
    </div>
    <!--end::Input group-->
    <!--begin::Actions-->
    <div class="d-flex flex-stack">
        <!--begin::Submit-->
        <button id="kt_sign_up_submit" class="btn btn-primary" data-kt-translate="sign-up-submit">
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
                <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="p-4" />
            </a>
            <!--end::Symbol-->
            <!--begin::Symbol-->
            <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light me-3">
                <img alt="Logo" src="assets/media/svg/brand-logos/facebook-3.svg" class="p-4" />
            </a>
            <!--end::Symbol-->
            <!--begin::Symbol-->
            <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light">
                <img alt="Logo" src="assets/media/svg/brand-logos/apple-black.svg" class="theme-light-show p-4" />
                <img alt="Logo" src="assets/media/svg/brand-logos/apple-black-dark.svg" class="theme-dark-show p-4" />
            </a>
            <!--end::Symbol-->
        </div>
        <!--end::Social-->
    </div>
    <!--end::Actions-->
</form>