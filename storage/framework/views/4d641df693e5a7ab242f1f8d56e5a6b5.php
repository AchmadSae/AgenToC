<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <title><?php echo e(config('app.name', 'Laravel')); ?></title>

      <!-- Favicon -->
      <link rel="shortcut icon" href="<?php echo e(asset('assets/media/logos/favicon.ico')); ?>" />

      <!-- CSS Files -->
      <link href="<?php echo e(asset('assets/css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />

      <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<?php
    $routeName = Route::currentRouteName();
?>

<body class="
    <?php echo e(in_array($routeName, ['sign-in', 'sign-up']) ? 'auth-bg' : 'bg-body position-relative'); ?>

" data-bs-spy="scroll" data-bs-target="#kt_landing_menu">
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!-- Page Content -->
        <?php echo $__env->yieldContent('content'); ?>
        <!-- end Page Content -->
    </div>

    <?php echo $__env->yieldPushContent('modals'); ?>
    <?php echo $__env->make('sweetalert::alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <!--begin::Javascript-->
    <script src="<?php echo e(asset('assets/plugins/global/plugins.bundle.js')); ?>"></script>
    <!-- Ensure Select2 is present before scripts.bundle.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?php echo e(asset('assets/js/scripts.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom/utilities/modals/checkout-product.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom/landing.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <!--end::Javascript-->
</body>

</html>
<?php /**PATH D:\development\CollaborateAgenToC\AgentC\resources\views/layouts/guest-lay.blade.php ENDPATH**/ ?>