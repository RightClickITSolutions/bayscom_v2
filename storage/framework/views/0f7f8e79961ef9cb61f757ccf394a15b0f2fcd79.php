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
            <form action="<?php echo e(url('/substore/days-transactions/submit')); ?>" method="POST" >
                            
                <div class="col s12 m12 l12">
                    <div id="form-with-validation" class="card card card-default scrollspy">
                        <div class="card-content">
                            <h4 class="card-title">Product sales</h4>
                              <?php echo e(csrf_field()); ?>

                              <div class="row" >
                                 <div class="input-field col m6 s12">
                                      <select name="substore" class="form-control browser-default"> 
                                        <option value="">Select Store</option>
                                        <?php $__currentLoopData = $substores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $substore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($substore->id); ?>"><?php echo e(ucwords($substore->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                  </div>
                                  <div class="input-field col m6 s12">
                                    <select name="payment" class="form-control browser-default"> 
                                        <option value="">Payment type</option>
                                        <option value="CASH"> CASH</option>
                                        <option value="POS"> POS</option>
                                    </select>
                                  </div>
                               </div>
                              <div class="row">

                                <div class="input-field col m6 s12">
                                  <label class="bmd-label-floating">Requesting staff</label>
                                  <input name="staff_name" disabled="disabled" value="<?php echo e(Auth::user()->name); ?>" type="text" class="form-control" >
                                </div>

                                <div class="input-field col m6 s12">
                                  <label class="bmd-label-floating">Submission date</label>
                                  <input name="date" disabled="disabled" value="<?php echo(date('d-m-Y H:i:s'))?>" type="text" class="form-control" >
                                </div>
                         
                              </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Form Advance -->
                    <!-- Form Advance -->
                    <div class="col s12 m12 l12">
                        <div id="Form-advance" class="card card card-default scrollspy">
                            <div id="products-card" class="card-content">
                                <h4 class="card-title">Products</h4>

                                    <div id="main-form" class="row">
                                        <div class="input-field col m6 s12">
                                        <select name='products[]' class="form-control  browser-default"> 
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

                                    <div id="add-form">
                                    
                                    <!-- <div id="main-form" class="row">
                                        <div class="input-field col m6 s12">
                                        <select name='products[]' class="form-control  browser-default"> 
                                            <option value="">Select Product</option>
                                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($product['id']); ?>"><?php echo e(ucwords($product->name())); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                            
                                        </div>
                                        <div class="input-field col m6 s12">
                                            <input type="number" min="0" value=""  name="quantity[]" class="form-control" class="validate">
                                            <label for="last_name">Quantity</label>
                                        </div>
                                        
                                    </div> -->
                                    
                                    
                                    </div>
                                    
                                        <div class="row">
                                        <div class="input-field col s4">
                                                
                                                <span id="add-product" class="btn  blue darken-1 right" >+product
                                                    
                                                </span>
                                            </div>
                                            <div class="input-field col s8">
                                                <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
                                                    <i class="material-icons right">send</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                    </div>

                        <!-- special prices -->
                    <div class="col s12 m12 l12 hide hidden">
                        <div id="Form-advance" class="card card card-default scrollspy">
                            <div class="card-content">
                                <h4 class="card-title">Special Discount Products</h4>
                                    
                                    <div class="row">
                                        <div class="input-field col m4 s12">
                                        <select name="special_item_products[]" class="form-control browser-default"> 
                                            <option value="">Select Product</option>
                                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($product['id']); ?>"><?php echo e(ucwords($product->name())); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                            
                                        </div>
                                        <div class="input-field col m4 s12">
                                            <input type="number" min="0" value="<?php echo e(old('special_item_product_quantity.0')); ?>"  name="special_item_product_quantity[]" class="form-control" class="validate">
                                            <label for="last_name">Quantity</label>
                                        </div>
                                        <div class="input-field col m4 s12">
                                            <input type="number"  value="<?php echo e(old('special_item_product_price.0')); ?>"  name="special_item_product_price[]" class="form-control" class="validate">
                                            <label for="orice">Price/Unit</label>
                                        </div>
                                    </div>
                                    
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
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
           
            $('#main-form').clone().appendTo('#add-form');
            console.log("got eeem");
          })

      </script>
      <?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layouts.mofad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SB__\mofad_v2\resources\views/sst.blade.php ENDPATH**/ ?>