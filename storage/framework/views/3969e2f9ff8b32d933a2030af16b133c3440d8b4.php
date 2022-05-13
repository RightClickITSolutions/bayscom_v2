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
      
      <div class="col s12">
                <div class="container">
                    <div class="seaction">
                      
                            <?php echo $__env->make('includes.post_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <!-- Form with validation -->
                            <div class="col s12 m12 l12">
                                <div id="form-with-validation" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Customer Lodgement for: <?php echo e($customer->name); ?> </h4>
                                        <form action="<?php echo e(url('customer/lodgment/'.$customer->id)); ?>" method="POST" >
                                          <?php echo e(csrf_field()); ?>

                                            <div class="row">
                                                <div class="input-field col m6 s6">
                                                  <label class="bmd-label-floating">Receiving Staff</label>
                                                  <input name="staff_name" disabled="disabled" value="<?php echo e(Auth::user()->name); ?>" type="text" class="form-control" >
                                                </div>
                                                <div class="input-field col m6 s6">
                                                   
                                                   
                                                  <label class="bmd-label-floating">Date</label>
                                                  <input name="date" disabled="disabled" value="<?php echo(date('d-m-Y H:i:s'))?>" type="text" class="form-control" >
                            
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="input-field col m12">
                                                  <label class="bmd-label-floating">Payment Amount</label>
                                                  <input type="number" min="0" value="<?php echo e(old('payment_amount')); ?>"  name="payment_amount" class="form-control">
                                                </div>
                                                <div class="input-field col m12">
                                                  <label class="bmd-label-floating">Teller no: Transaction ID</label>
                                                  <input type="text"  value="<?php echo e(old('teller_no')); ?>"  name="teller_no" class="form-control">
                                                </div>
                                                <div class="input-field col m12 ">
                                                    <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
                                                        <i class="material-icons right">payment</i>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                      </form>  
                                    </div>
                                </div>
                            </div>
                        
                        </div>
    
      
      <?php $__env->stopSection(); ?>

      <?php $__env->startSection('footer'); ?>
        <?php echo \Illuminate\View\Factory::parentPlaceholder('footer'); ?>
      <?php $__env->stopSection(); ?>
      
      <?php $__env->startSection('footer_scripts'); ?>
      <?php echo \Illuminate\View\Factory::parentPlaceholder('footer_scripts'); ?>
      <script>
          $('#add-product').on("click", function(){
           
            $('#main-form').clone().appendTo('#add-form');
            console.log("got eeem");
          })

      </script>
      <?php $__env->stopSection(); ?>
    
   
<?php echo $__env->make('layouts.mofad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SB__\mofad_v2\resources\views/customer_lodgment.blade.php ENDPATH**/ ?>