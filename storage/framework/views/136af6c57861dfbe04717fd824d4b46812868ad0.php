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
                                                  <thead class=" ">
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                    Products 
                                                    </th>
                                                    <th>
                                                    Customer 
                                                    </th>
                                                    <th>
                                                      Sales rep
                                                    </th>
                                                    <th>
                                                      Date Approved
                                                    </th>
                                                    
                                                    <th>
                                                      Checkout
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      <?php $__currentLoopData = $prf_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                      <td>
                                                        <?php echo e($prf->id); ?>

                                                      </td>
                                                      
                                                      <td>
                                                      <table>
                                                        <tr> <td>Product</td> <td>Quantity</td> </tr>
                                                        <?php $__currentLoopData = $prf->order_snapshot(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                        <tr>
                                                        <td><?php echo e($product->product_name); ?></td> <td><?php echo e($product->product_quantity); ?></td>
                                                        <tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      </table>
                                                      </td>
                                                      <td>
                                                      <?php echo e($prf->customer->name); ?>

                                                      </td>
                                                      <td>
                                                      <?php echo e($prf->createdBy->name); ?>

                                                      </td>
                                                      <td>
                                                      <?php echo e($prf->updated_at); ?>

                                                      </td>
                                                      <td>
                                                            <form action="<?php echo e(url('/prf/store-keeper')); ?>" method="post">
                                                            <?php echo e(csrf_field()); ?>

                                                            <input type="hidden" name="order_id" value="<?php echo e($prf->id); ?>">
                                                            <button type="submit" class="btn btn-success">Issued</button>
                                                            </form>
                                                      </td>
                                                      
                                                      
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </tbody>
                                                </table>              </div>
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
   
<?php echo $__env->make('layouts.mofad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SB__\mofad_v2\resources\views/prf_store_keeper.blade.php ENDPATH**/ ?>