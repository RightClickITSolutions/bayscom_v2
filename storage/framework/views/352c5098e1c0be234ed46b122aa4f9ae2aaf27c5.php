<?php $__env->startSection('head'); ?> 
   <!-- BEGIN: VENDOR CSS-->
   <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/vendors.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/flag-icon/css/flag-icon.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/data-tables/css/select.dataTables.min.css')); ?>">
    <!-- END: VENDOR CSS-->
    <?php echo \Illuminate\View\Factory::parentPlaceholder('head'); ?>
   
<?php $__env->stopSection(); ?>

      <?php $__env->startSection('side_nav'); ?>
        <?php echo \Illuminate\View\Factory::parentPlaceholder('side_nav'); ?>
      <?php $__env->stopSection(); ?>
      <?php $__env->startSection('top_nav'); ?>
            <?php echo \Illuminate\View\Factory::parentPlaceholder('top_nav'); ?>
      <?php $__env->stopSection(); ?>
      <!-- End Navbar -->
      <?php $__env->startSection('content'); ?>
      <?php echo $__env->make('includes.post_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0">List of PRfs Raised</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">PRFs</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                            <thead>
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                      Total Value
                                                    </th>
                                                    <th>
                                                      Customer
                                                    </th>
                                                   
                                                    <!-- <th>
                                                      Expected Payment Date
                                                    </th> -->
                                                    <th>
                                                      Created by
                                                    </th>
                                                    <th>
                                                      Date
                                                    </th>
                                                   
                                                    <th>
                                                      Status
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      <?php $__currentLoopData = $prf_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                      <td>
                                                        <a href="<?php echo e(url('/prf/invoice/'.$prf->id)); ?>"><?php echo e($prf->id); ?></a>
                                                      </td>
                                                      
                                                      <td>
                                                      <?php echo e(number_format($prf->order_total,2)); ?>

                                                      </td>
                                                      <td>
                                                      <?php echo e($prf->customer->name?? 'N/A'); ?>

                                                      </td>
                                                                                                          
                                                      <td>
                                                      <?php echo e($prf->createdBy->name); ?>

                                                      </td>
                                                      <td>
                                                      <?php echo e($prf->created_at); ?>

                                                      </td>
                                                     
                                                      <?php if(!$prf->reversed()): ?>
                                                      <td>
                                                            <a href="<?php echo e(url('admin/prf/reversal/'.$prf->id)); ?>">Reverse </a>
                                                      </td>
                                                      <?php else: ?>
                                                      <td>
                                                            This PRF has been revered
                                                      </td>
                                                      <?php endif; ?>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </tbody>
                                                </table>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                <div class="content-overlay"></div>
            </div>
      <?php $__env->stopSection(); ?>

      <?php $__env->startSection('footer'); ?>
        <?php echo \Illuminate\View\Factory::parentPlaceholder('footer'); ?>
     
      <?php $__env->stopSection(); ?>
      
    <?php $__env->startSection('footer_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('footer_scripts'); ?>
    
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?php echo e(asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/vendors/data-tables/js/dataTables.select.min.js')); ?>"></script>
    <!-- END PAGE VENDOR JS-->

   
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?php echo e(asset('app-assets/js/scripts/data-tables.js')); ?>"></script>
    
      <?php $__env->stopSection(); ?>
      
     
   
     
   
<?php echo $__env->make('layouts.mofad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SB__\mofad_v2\resources\views/admin_reverse_prf.blade.php ENDPATH**/ ?>