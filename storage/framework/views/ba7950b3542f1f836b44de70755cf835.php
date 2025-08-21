<?php if (isset($component)) { $__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.guest-lay','data' => ['title' => __('Register')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-lay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Register'))]); ?>
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <!--begin::Body-->
                <div class="p-10">
                    <!--begin::Form-->
                    <?php if($flag == 'user'): ?>
                        <?php if (isset($component)) { $__componentOriginaled6ce3f04faff79b00d93239184f6e4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled6ce3f04faff79b00d93239184f6e4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-auth','data' => ['form' => 'sign-up','directUrl' => 'landing','title' => 'Join our partnership As User','description' => 'Get FLexibility and Easy Management Business','id' => 'kt_sign_up_form','action' => 'register']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('sign-up'),'directUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('landing'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Join our partnership As User'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Get FLexibility and Easy Management Business'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('kt_sign_up_form'),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('register')]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-auth','data' => ['form' => 'sign-up','directUrl' => 'landing','title' => 'Join our partnership As Worker','description' => 'Be our partners for your freelance business','id' => 'kt_sign_up_form','action' => 'register','typeRegister' => 'worker']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('sign-up'),'directUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('landing'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Join our partnership As Worker'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Be our partners for your freelance business'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('kt_sign_up_form'),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('register'),'typeRegister' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('worker')]); ?>
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
<?php /**PATH D:\development\CollaborateAgenToC\AgentC\resources\views/auth/signup.blade.php ENDPATH**/ ?>