<?php if (isset($component)) { $__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.guest-lay','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-lay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        Login
     <?php $__env->endSlot(); ?>
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <div class="d-flex flex-stack py-2">
                    <!--begin::Back link-->
                    <div class="me-2"></div>
                    <?php if($flag == 'user'): ?>
                    <div class="m-0">
                        <span class="text-gray-500 fw-bold fs-5 me-2" data-kt-translate="sign-in-head-desc">Not a Member
                            yet?</span>
                        <a href="<?php echo e(route('sign-up', ['flag' => 'user'])); ?>" class="link-primary fw-bold fs-5"
                            data-kt-translate="sign-in-head-link">Sign Up</a>
                    </div>
                    <?php endif; ?>
                    <?php if($flag == 'worker'): ?>
                    <div class="m-0">
                        <span class="text-gray-500 fw-bold fs-5 me-2" data-kt-translate="sign-in-head-desc">Not a Member
                            yet?</span>
                        <a href="<?php echo e(route('sign-up', ['flag' => 'worker'])); ?>" class="link-primary fw-bold fs-5"
                            data-kt-translate="sign-in-head-link">Sign Up</a>
                    </div>
                    <?php endif; ?>
                    <!--end::Sign Up link=-->
                </div>
                <!--begin::Body-->
                <div class="p-20">
                    <!--begin::Form-->
                    <?php if($flag == 'user'): ?>
                    <?php if (isset($component)) { $__componentOriginaled6ce3f04faff79b00d93239184f6e4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled6ce3f04faff79b00d93239184f6e4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-auth','data' => ['form' => 'sign-in','directUrl' => 'test','title' => 'Sign In','description' => 'Get our flexibility and easy management business','id' => 'kt_sign_in_form','action' => 'login']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('sign-in'),'directUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Sign In'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Get our flexibility and easy management business'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('kt_sign_in_form'),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('login')]); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled6ce3f04faff79b00d93239184f6e4e)): ?>
<?php $attributes = $__attributesOriginaled6ce3f04faff79b00d93239184f6e4e; ?>
<?php unset($__attributesOriginaled6ce3f04faff79b00d93239184f6e4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled6ce3f04faff79b00d93239184f6e4e)): ?>
<?php $component = $__componentOriginaled6ce3f04faff79b00d93239184f6e4e; ?>
<?php unset($__componentOriginaled6ce3f04faff79b00d93239184f6e4e); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <?php if($flag == 'worker'): ?>
                    <?php if (isset($component)) { $__componentOriginaled6ce3f04faff79b00d93239184f6e4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled6ce3f04faff79b00d93239184f6e4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-auth','data' => ['form' => 'sign-in','directUrl' => 'home','title' => 'Sign In','description' => 'Get our flexibility and easy management business','id' => 'kt_sign_in_form','action' => 'login','typeRegister' => 'worker']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('sign-in'),'directUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('home'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Sign In'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Get our flexibility and easy management business'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('kt_sign_in_form'),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('login'),'typeRegister' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('worker')]); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled6ce3f04faff79b00d93239184f6e4e)): ?>
<?php $attributes = $__attributesOriginaled6ce3f04faff79b00d93239184f6e4e; ?>
<?php unset($__attributesOriginaled6ce3f04faff79b00d93239184f6e4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled6ce3f04faff79b00d93239184f6e4e)): ?>
<?php $component = $__componentOriginaled6ce3f04faff79b00d93239184f6e4e; ?>
<?php unset($__componentOriginaled6ce3f04faff79b00d93239184f6e4e); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <!--end::Form-->
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="m-0">
                    <!--begin::Toggle-->
                    <button class="btn btn-flex btn-link rotate" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                        <img data-kt-element="current-lang-flag" class="w-25px h-25px rounded-circle me-3"
                            src="<?php echo e(asset('assets/media/flags/united-states.svg')); ?>" alt="" />
                        <span data-kt-element="current-lang-name" class="me-2">English</span>
                        <i class="ki-duotone ki-down fs-2 text-muted rotate-180 m-0"></i>
                    </button>
                    <!--end::Toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4"
                        data-kt-menu="true" id="kt_auth_lang_menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="<?php echo e(asset('assets/media/flags/united-states.svg')); ?>" alt="" />
                                </span>
                                <span data-kt-element=" lang-name">English</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="<?php echo e(asset('assets/media/flags/spain.svg')); ?>" alt="" />
                                </span>
                                <span data-kt-element="lang-name">Spanish</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="<?php echo e(asset('assets/media/flags/germany.svg')); ?>" alt="" />
                                </span>
                                <span data-kt-element="lang-name">German</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="<?php echo e(asset('assets/media/flags/japan.svg')); ?>" alt="" />
                                </span>
                                <span data-kt-element="lang-name">Japanese</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="<?php echo e(asset('assets/media/flags/france.svg')); ?>" alt="" />
                                </span>
                                <span data-kt-element="lang-name">French</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Footer-->
            </div>
        </div>
        <!--begin::Body-->
        <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat"
            style="background-image: url(<?php echo e(asset('assets/media/auth/bg11.png')); ?>)"></div>
        <!--begin::Body-->
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4)): ?>
<?php $attributes = $__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4; ?>
<?php unset($__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4)): ?>
<?php $component = $__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4; ?>
<?php unset($__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4); ?>
<?php endif; ?>
<?php /**PATH D:\development\CollaborateAgenToC\AgentC\resources\views/auth/login.blade.php ENDPATH**/ ?>