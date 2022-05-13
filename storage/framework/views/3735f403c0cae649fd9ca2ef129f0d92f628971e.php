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
      <form action="<?php echo e(url('create-pro')); ?>" method="POST" id="form">
      <div class="col s12">
                <div class="container">
                    <div class="seaction">
                    <?php echo $__env->make('includes.post_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      
                            <!-- Form with validation -->
                            <div class="col s12 m12 l12">
                                <div id="form-with-validation" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Pro Request Details</h4>
                                        
                                          <?php echo e(csrf_field()); ?>

                                            <div class="row">
                                                <div class="input-field col m4 s6">
                                                <select name="warehouse" class="form-control browser-default"> 
                                                    <option value="">Select Warehouse</option>
                                                    <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($warehouse['id']); ?>"><?php echo e(ucwords($warehouse->name)); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                

                                                </select>
                                                </div>
                                                <div class="input-field col m4 s6">
                                                   
                                                    <label class="bmd-label-floating">Requesting staff</label>
                                    <input name="staff_name" disabled="disabled" value="<?php echo e(Auth::user()->name); ?>" type="text"  >
                                                   
                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <div class="input-field col s12">
                                                    <input name="date" disabled="disabled" value="<?php echo(date('d-m-Y H:i:s'))?>" type="text"  >
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>



                            <!-- Form Advance -->
                            <div class="col s12 m12 l12">
                                <div id="Form-advance" class="card card card-default scrollspy">
                                    <div id="products-card" class="card-content">
                                        <h4 class="card-title">Products</h4>
                                        
                                            <div id="main-form" class="row">
                                                <div class="input-field col m6 s12">
                                                <select name="products[]" class="form-control  browser-default"> 
                                                  <option value="">Select Product</option>
                                                      <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                          <option value="<?php echo e($product['id']); ?>"><?php echo e(ucwords($product->name())); ?></option>
                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                    
                                                </div>
                                                <div class="input-field col m6 s12">
                                                    <input type="number" min="0" value="<?php echo e(old('quantity.0')); ?>"  name="quantity[]" class="form-control" class="validate">
                                                    <label for="last_name">Quantity</label>
                                                </div>
                                                
                                            </div>
                                            <div id="add-form"></div>
                                            
                                                <div class="row">
                                                <div class="input-field col s4">
                                                        <span id="add-product" class="btn  blue darken-1 right" >+product
                                                           
                                                        </span>
                                                    </div>
                                                    <div class="input-field col s8">
                                                        <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Request
                                                            <i class="material-icons right">send</i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>


                        </div>


        </form>
      <?php $__env->stopSection(); ?>

      <?php $__env->startSection('footer'); ?>
        <?php echo \Illuminate\View\Factory::parentPlaceholder('footer'); ?>

      <?php $__env->stopSection(); ?>
      <?php $__env->startSection('footer_scripts'); ?>
      <?php echo \Illuminate\View\Factory::parentPlaceholder('footer_scripts'); ?>
      <script>
          $('#add-product').on("click", function(){
           
            cloned_form  = $('#main-form').clone();
            $('#add-form').append(cloned_form);
            console.log("got eeem");
          })

            // $('#form').on('submit', function(e) {
            //     //prevent the default submithandling
            //     e.preventDefault();
            //     //send the data of 'this' (the matched form) to yourURL
            //     $.post("<?php echo e(url('create-pro')); ?>", $(this).serialize());
                
            //     console.log("subtit clicked aposted");
            // });

      </script>
      <?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layouts.mofad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SB__\bayscom_v2\resources\views/pro.blade.php ENDPATH**/ ?>