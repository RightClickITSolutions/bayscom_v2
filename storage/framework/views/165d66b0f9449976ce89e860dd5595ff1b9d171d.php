<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <?php $__env->startSection('head'); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="description" content="Mofad">
        <meta name="keywords" content="MOFAD Proprietory systems">
        <meta name="author" content="Right Click">
        <title>BAYSCOM | <?php echo e($page_tittle ?? ''); ?></title>
        <link rel="apple-touch-icon" href="<?php echo e(asset('app-assets/images/favicon/apple-touch-icon-152x152.png')); ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('app-assets/images/favicon/favicon-32x32.')); ?>png">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php echo $__env->make('includes.main-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldSection(); ?>
</head>
<!-- END: Head-->

<body
    class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   "
    data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- END: Header-->


    <!-- BEGIN: SideNav-->
    <?php $__env->startSection('side_nav'); ?>
    <?php echo $__env->make('components.sidebar-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldSection(); ?>
    <!-- END: SideNav-->
    <script type="application/javascript">
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

    </script>
    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="pt-3 pb-1 breadcrumbs-bg" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span><?php echo e($page_tittle ?? 'BAYSCOM'); ?></span></h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item"><a href="index.html"><?php echo e($page_subtittle ?? ''); ?></a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <?php $__env->startSection('content'); ?>
                <div class="col s12">
                    <div class="container">
                        <div class="section">
                            <div class="row user-profile mt-1 ml-0 mr-0">
                                <img class="responsive-img" alt=""
                                    src="<?php echo e(asset('app-assets/images/logo/logo.png')); ?>">
                            </div>
                            <div class="section" id="user-profile">
                                <div class="row">
                                    <!-- User Profile Feed -->
 
                                    <!-- User Post Feed -->
                                    <div class="col s12 m12 l12">
                                        <div class="row">
                                            <div class="card user-card-negative-margin z-depth-0" id="feed">
                                                <div class="card-content card-border-gray">
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <h5><?php echo e(Auth::user()->name ?? ''); ?></h5>
                                                            <p><span class="amber-text"><span
                                                                        class="material-icons star-width vertical-align-middle">star_rate</span>
                                                                    <span
                                                                        class="material-icons star-width vertical-align-middle">star_rate</span>
                                                                    <span
                                                                        class="material-icons star-width vertical-align-middle">star_rate</span>
                                                                    <span
                                                                        class="material-icons star-width vertical-align-middle">star_rate</span>
                                                                    <span
                                                                        class="material-icons star-width vertical-align-middle">star_rate</span>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <ul class="tabs card-border-gray mt-4">
                                                                <li class="tab col m3 s6 p-0"><a class="active"
                                                                        href="#test1">
                                                                        <i
                                                                            class="material-icons vertical-align-middle">crop_portrait</i>
                                                                        Info
                                                                    </a></li>

                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <hr class="mt-5">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Today Highlight -->
                                
                            </div>
                        </div>
                    </div>
                    <!-- START RIGHT SIDEBAR NAV -->

                    <!-- END RIGHT SIDEBAR NAV -->
                    <div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a
                            class="btn-floating btn-large gradient-45deg-yellow-red gradient-shadow"><i
                                class="material-icons">add</i></a>
                        <ul>
                            <!-- <li><a href="css-helpers.html" class="btn-floating blue"><i class="material-icons">help_outline</i></a></li>
                                <li><a href="cards-extended.html" class="btn-floating green"><i class="material-icons">widgets</i></a></li>
                                <li><a href="app-calendar.html" class="btn-floating amber"><i class="material-icons">today</i></a></li>
                                <li><a href="app-email.html" class="btn-floating red"><i class="material-icons">mail_outline</i></a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>
            <?php echo $__env->yieldSection(); ?>
        </div>
    </div>
    <!-- END: Page Main-->

    <!-- BEGIN: Footer-->

    <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startSection('footer_scripts'); ?>
    <?php echo $__env->make('includes.main-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <script>
            $(document).ready(function() {

                <?php if(isset($post_status) && $post_status == 'SUCCESS'): ?>
                    {
                        swal({
                            title: 'success',
                            icon: 'success'
                        });
                    }
                <?php elseif(isset($post_status) && $post_status == 'FAILED'): ?>
                    {
                        swal({
                            title: 'Error',
                            icon: 'error'
                    })
                    }
                <?php endif; ?>

                var today = new Date();
                var date = today.getFullYear();
                document.getElementById("date").innerHTML = date;

            });
        </script>

    <?php echo $__env->yieldSection(); ?>
</body>

</html>
<?php /**PATH D:\SB__\bayscom_v2\resources\views/layouts/mofad.blade.php ENDPATH**/ ?>