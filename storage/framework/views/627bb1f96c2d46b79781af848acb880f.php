<?php if($errors->any()): ?>
    <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <i class="ki-duotone ki-shield-search fs-2hx text-light me-4 mb-5 mb-sm-0"><span class="path1"></span><span
                class="path2"></span><span class="path3"></span></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <!--begin::Title-->
            <h4 class="mb-2 light"><?php echo e(__('Whoops! Something went wrong.')); ?></h4>
            <!--end::Title-->

            <!--begin::Content-->
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span><?php echo e($error); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!--end::Content-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
            data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span class="path2"></span></i>
        </button>
        <!--end::Close-->
    </div>
    <!--end::Alert-->
<?php endif; ?><?php /**PATH D:\development\CollaborateAgenToC\AgentC\resources\views/components/validation-errors.blade.php ENDPATH**/ ?>