
<div class="col-md-11 col-lg-11 col-sm-11 padd1">
            <div class="container-fluid mrg-btm">
                <div class="heading-part">
                    <h1 class="main_headng">Edit Product</h1>
                    <a href=""><img src="images/button-icon.png" alt=""></a>

                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo base_url('seller/product/edit_product/'.$res['id']) ?>" method="post">
                            <div class="row">
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-1">
                                        <label for="product_id" class="form-label">Product Id</label>
                                        <input type="text" class="form-control form-control-sm" id="product_id" name="product_id" value="<?php echo $res['product_id'] ?>" />
                                    <?php echo form_error('product_id', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-5">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control form-control-sm" id="product_name"
                                            name="product_name" placeholder="Enter Product Name" value="<?php echo $res['product_name'] ?>" />
                                        <?php echo form_error('product_name', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select form-select-sm" id="category" name="l1c_id">
                                            <option selected>Select Category</option>
                                              <?php if(!empty($categories))
                                    {
                                        foreach ($categories as $key => $value) {?>
                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['l1_category'] ?></option>
                                               
                                            <?php } } ?>
                                            
                                            <?php ?>
                                            </select>
                                    <?php echo form_error('l1c_id', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="sub_category" class="form-label">Sub Category</label>
                                        <select class="form-select form-select-sm" id="l2c_id"
                                            name="l2c_id">
                                            <option selected>Select Sub Category</option>
                                        
                                        </select>
                                    <?php echo form_error('l2c_id', '<div class="error">', '</div>'); ?>

                                    </div>
                                </div>
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-2">
                                        <label for="stock" class="form-label">Stock</label>
                                        <select class="form-select form-select-sm" id="stock" name="stock">
                                            <option selected>Select Stock</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    <?php echo form_error('stock', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-2">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="text" class="form-control form-control-sm" id="quantity"
                                            name="quantity" placeholder="Enter Qunatity" value="<?php echo $res['quantity'] ?>" />
                                    <?php echo form_error('quantity', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-2">
                                        <label for="mrp" class="form-label">MRP (INR)</label>
                                        <input type="text" class="form-control form-control-sm" id="mrp" name="mrp"
                                            placeholder="Enter MRP in Rs." value="<?php echo $res['mrp'] ?>"/>
                                    <?php echo form_error('mrp', '<div class="error">', '</div>'); ?>

                                    </div>
                                     <div class="col-lg-2">
                                        <label for="mrp" class="form-label">Selling Price (INR)</label>
                                        <input type="text" class="form-control form-control-sm" id="price" name="price"
                                            placeholder="Enter Selling in Rs." value="<?php echo $res['price'] ?>"/>
                                    <?php echo form_error('price', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <!-- <div class="col-lg-3">
                                        <label for="discount" class="form-label">Discount (INR)</label>
                                        <input type="text" class="form-control form-control-sm" id="discount"
                                            name="discount_percent" placeholder="Enter discount in Rs." value="<?php echo $res['discount_percent'] ?>"/>
                                    <?php echo form_error('discount_percent', '<div class="error">', '</div>'); ?>

                                    </div> -->
                                    <div class="col-lg-2">
                                        <label for="discount" class="form-label">Unit Discount (INR)</label>
                                        <input type="text" class="form-control form-control-sm" id="discount_percent"
                                            name="discount_percent" placeholder="Enter discount in Rs." />
                                    <?php echo form_error('discount_percent', '<div class="error">', '</div>'); ?>

                                    </div>
                                     <div class="col-lg-2">
                                        <label for="discount" class="form-label">Product Discount (INR)</label>
                                        <input type="text" class="form-control form-control-sm" id="discount_percent"
                                            name="discount_percent" placeholder="Enter discount in Rs." />
                                    <?php echo form_error('discount_percent', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <!-- <div class="col-lg-2">
                                        <label for="purchase_price" class="form-label">Purchase Price (Optional)</label>
                                        <input type="text" class="form-control form-control-sm" id="purchase_price"
                                            name="purchase_price" placeholder="Enter Purchase Price" value="<?php echo $res['purchase_price'] ?>"/>
                                    <?php echo form_error('purchase_price', '<div class="error">', '</div>'); ?>

                                    </div> -->
                                </div>
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-2">
                                        <label for="unit" class="form-label">Unit</label>
                                        <select class="form-select form-select-sm" id="unit" name="unit">
                                            <option selected>Select</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    <?php echo form_error('unit', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="purchase_price" class="form-label">GSTIN (HSN/SAC Code)</label>
                                        <!-- <input type="text" class="form-control form-control-sm" id="hsn_code"
                                            name="hsn_code" placeholder="Enter HSN/SAC Code"  value="<?php //echo $res['hsn_code'] ?>" /> -->
                                            <select class="form-select form-select-sm" id="hsn_code" name="hsn_code">
                                             <option selected>Select</option>
                                            <option value="851590">851590</option>
                                            <option value="851591">851591</option>
                                            <option value="851592">851592</option>
                                            <option value="851593">851593</option>
                                            <option value="851594">851594</option>  
                                        </select>
                                    <?php echo form_error('hsn_code', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="applicable_tax" class="form-label">Applicable Tax (GST)</label>
                        <input type="text" class="form-control form-control-sm" id="applicable_tax" name="applicable_tax" value="<?php echo $res['applicable_tax'] ?>"/>
                                    <?php echo form_error('applicable_tax', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="price_for_seller" class="form-label">Price For Seller</label>
                                        <input type="text" class="form-control form-control-sm" id="price_for_seller"
                                            name="price_for_seller" value="<?php echo $res['price_for_seller'] ?>" />
                                    <?php echo form_error('price_for_seller', '<div class="error">', '</div>'); ?>

                                    </div>
                                </div>
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-4">
                                        <label for="price_for_seller" class="form-label">Product Images</label>
                                        <input type="file" name="image[]" class="form-control">
                                        <br>
                                        <div class="row">
                                                      
                                             <?php  if(!empty($product_img)) {
                                                foreach ($product_img as $key => $value) { 
                                                    ?>
                                                   
                                            <div class="col-lg-6 col-sm-6 col-6 pro-img">
                                                <img src="<?php echo base_url('images/product/'.$value->search_image); ?>" alt="">
                                            </div>
                                            <?php } } ?>
                    
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="price_for_seller" class="form-label">Product Video</label>
                                        <input type="file" name="video" class="form-control"><br>
                                        <div class="col-lg-6 col-sm-6 col-6 pro-video">
                                            <video width="260" height="200" controls>
                                                <source src="<?php echo base_url('images/product/'.$res['video']); ?>" type="video/mp4">
                                
                                              </video>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="product_description" class="form-label">Product Description</label>
                                        <textarea class="form-control text-area" id="product_description"
                                            name="short_description"
                                            placeholder="Enter Product Description"><?php echo $res['short_description'] ?></textarea>
                                    <?php echo form_error('product_description', '<div class="error">', '</div>'); ?>

                                    </div>

                                </div>
                                <!-- <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-10">
                                        <label for="product_description" class="form-label">Product Description</label>
                                        <textarea class="form-control" id="product_description"
                                            name="product_description"
                                            placeholder="Enter Product Description"></textarea>
                                    </div>
                                    <div class="col-lg-2 add-btn">
                                        <button class="btn btn-sm mt-2" style="background-color: #fff107;">ADD
                                            PRODUCT</button>
                                    </div>
                                </div> -->
                                
                            </div>
                            <div class="add-btn">
                                <button class="btn btn-sm mt-2" style="background-color: #FFD200;">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>