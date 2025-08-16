<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title); ?></title>
    <link rel="shortcut icon" href="<?php echo e(asset('assets/media/logos/favicon.ico')); ?>" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="<?php echo e(asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')); ?>" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?php echo e(asset('assets/css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/plugins/global/plugins.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
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
        <?php echo e($slot); ?>

        <!-- end Page Content -->
    </div>

    <?php echo $__env->yieldPushContent('modals'); ?>
    <?php echo $__env->make('sweetalert::alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="<?php echo e(asset('assets/plugins/global/plugins.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/scripts.bundle.js')); ?>"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>

</html>
<?php /**PATH E:\iseng\AgenToC\resources\views/components/guest-lay.blade.php ENDPATH**/ ?>