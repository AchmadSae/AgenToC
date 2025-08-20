<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
'method' => 'POST',
'id' => 'kt_sign_up_form',
'directUrl' => 'login',
'action',
'title'=> 'Sign Up to our platform',
'description' => '',
'form',
'typeRegister' => 'user',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
'method' => 'POST',
'id' => 'kt_sign_up_form',
'directUrl' => 'login',
'action',
'title'=> 'Sign Up to our platform',
'description' => '',
'form',
'typeRegister' => 'user',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<form method="<?php echo e($method); ?>" class="form w-100" novalidate="novalidate" id="<?php echo e($id); ?>"
    data-kt-redirect-url="<?php echo e(route($directUrl)); ?>" action="<?php echo e(route($action)); ?>">
    <?php echo csrf_field(); ?>
    <!--begin::Heading-->
    <div class="text-start mb-10">
        <?php if (isset($component)) { $__componentOriginalb24df6adf99a77ed35057e476f61e153 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb24df6adf99a77ed35057e476f61e153 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.validation-errors','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('validation-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb24df6adf99a77ed35057e476f61e153)): ?>
<?php $attributes = $__attributesOriginalb24df6adf99a77ed35057e476f61e153; ?>
<?php unset($__attributesOriginalb24df6adf99a77ed35057e476f61e153); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb24df6adf99a77ed35057e476f61e153)): ?>
<?php $component = $__componentOriginalb24df6adf99a77ed35057e476f61e153; ?>
<?php unset($__componentOriginalb24df6adf99a77ed35057e476f61e153); ?>
<?php endif; ?>
    </div>
    <div class="text-start mb-10">
        <!--begin::Title-->
        <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="<?php echo e($form); ?>-title"><?php echo e($title); ?>

        </h1>
        <!--end::Title-->
        <!--begin::Text-->
        <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="general-desc">
            <?php echo e($description); ?>

        </div>
        <!--end::Link-->
    </div>
    <!--end::Heading-->
      <!-- begin::defin form auth -->
      <?php switch($form):
            case ('sign-in'): ?>
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
                        <a href="<?php echo e(route('show-pass-request')); ?>" class="link-primary" data-kt-translate="sign-in-forgot-password">Forgot Password ?</a>
                        <!--end::Link-->
                </div>
                  <?php break; ?>
            <?php case ('sign-up'): ?>
                  <input type="text" name="role" value="<?php echo e($typeRegister); ?>" hidden>
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
                  <?php break; ?>
            <?php default: ?>
                  <div class="fv-row mb-10">
                        <img src="<?php echo e(asset('assets/media/auth/404-error.png')); ?> " class="mw-100 mh-300px theme-light-show" alt="">
                        <img src="<?php echo e(asset('assets/media/auth/404-error-dark.png')); ?> " class="mw-100 mh-300px theme-dark-show" alt="">
                  </div>
            <?php break; ?>
      <?php endswitch; ?>

    <!-- end::defin form auth -->

    <!--begin::Actions-->
    <div class="d-flex flex-stack">
        <!--begin::Submit-->
        <button id="kt_sign-up_submit" class="btn btn-primary" data-kt-translate="<?php echo e($form); ?>-submit">
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
                <img alt="Logo" src="<?php echo e(asset('assets/media/svg/brand-logos/google-icon.svg')); ?>" class="p-4" />
            </a>
            <!--end::Symbol-->
            <!--begin::Symbol-->
            <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light me-3">
                <img alt="Logo" src="<?php echo e(asset('assets/media/svg/brand-logos/facebook-4.svg')); ?>" class="p-4" />
            </a>
            <!--end::Symbol-->
            <!--begin::Symbol-->
            <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light">
                <img alt="Logo" src="<?php echo e(asset('assets/media/svg/brand-logos/apple-black.svg')); ?>"
                    class="theme-light-show p-4" />
                <img alt="Logo" src="<?php echo e(asset('assets/media/svg/brand-logos/apple-white.svg')); ?>"
                    class="theme-dark-show p-4" />
            </a>
            <!--end::Symbol-->
        </div>
        <!--end::Social-->
    </div>
    <!--end::Actions-->
</form>
<?php /**PATH D:\development\CollaborateAgenToC\AgentC\resources\views/components/form-auth.blade.php ENDPATH**/ ?>