<?php $__env->startSection('head'); ?> 
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
                                <p class="caption mb-0">Station/Lubebay Sales</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Station/Lube Bay sales</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead >
                                                  <th>
                                                  SST ID
                                                  </th>
                                                
                                                 
                                                  <th>
                                                  Total amount
                                                  </th>
                                                  <th>
                                                    Substore 
                                                  </th>
                                                  <th>
                                                    Substore admin
                                                  </th>
                                                  <th>
                                                    date posted
                                                  </th>
                                                  
                                                  <th>
                                                    Confirmation
                                                  </th>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $sst_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <tr>
                                                    <td>
                                                      <a href="<?php echo e(url('sst/view-details/'.$sst->id)); ?>"><?php echo e($sst->id); ?></a>
                                                    </td>
                                                    
                                                   
                                                    <td>
                                                    <?php echo e($sst->amount); ?>

                                                    </td>
                                                    <td>
                                                    <?php echo e($sst->substore->name); ?>

                                                    </td>
                                                    <td>
                                                    <?php echo e($sst->createdBy->name); ?>

                                                    </td>
                                                    <td>
                                                    <?php echo e($sst->updated_at); ?>

                                                    </td>
                                                    <td>
                                                    <?php if(!$sst->reversed()): ?>
                                                        <?php if($sst->approval->l1!=0): ?>
                                                          <?php echo e($sst->approvedBy('l1')); ?>

                                                        
                                                        <?php else: ?>
                                                          <?php echo $__env->make('includes.approve_form',['action'=>'/approve-sst','process_id'=>$sst->id,'process_type'=>'SST','level'=>'l1','button_label'=>'Confirm'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                          <br>
                                                          <?php echo $__env->make('includes.decline_form',['action'=>'/approve-sst','process_id'=>$sst->id,'process_type'=>'SST','level'=>'l1','button_label'=>'Cancel'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                          
                                                        
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                     Sale entry Reversal <br> by 
                                                     <?php echo e($sst->reversalApprovedBy('l1')); ?>

                                                    <?php endif; ?>
                                                          
                                                    </td>
                                                    
                                                    
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
      
   
<?php echo $__env->make('layouts.mofad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SB__\mofad_v2\resources\views/view_approve_sst.blade.php ENDPATH**/ ?>