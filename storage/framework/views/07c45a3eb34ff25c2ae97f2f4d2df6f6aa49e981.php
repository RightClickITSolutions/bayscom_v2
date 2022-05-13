<?php $__env->startSection('head'); ?>
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
       <!-- Form with validation -->
       <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s6 delete-confirmation" style="padding-bottom: 20px;">
                <?php $__currentLoopData = $pro_reverse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h4>Are you sure you want to Reserve the PRO: <span><?php echo e($item->id); ?></span> ???</h4>
                    <form action="<?php echo e(url('/pro/reverse_pro/delete/inst-delete/'.$item->id)); ?>" method="POST">
                      <?php echo e(csrf_field()); ?>

                        <input type="hidden" value="<?php echo e($item->id); ?>" name="sid">
                        <button class="btn btn-danger btn-yes" type="submit">Yes</button>
                        <button class="btn btn-warning btn-no">No</button>
                    </form>
                        
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
      </div>
      <?php $__env->stopSection(); ?>

      <?php $__env->startSection('footer'); ?>
        <?php echo \Illuminate\View\Factory::parentPlaceholder('footer'); ?>
      <?php $__env->stopSection(); ?>
   
<?php echo $__env->make('layouts.mofad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SB__\mofad_v2\resources\views/pro_prompt_delete.blade.php ENDPATH**/ ?>