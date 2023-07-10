 
  <div class="col-md-11">
            <div class="container-fluid">
                <h1 class="main_headng">Add New Products to the Inventory</h1>
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo base_url('seller/product/add_product'); ?>" method="post"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-1">
                                        <label for="product_id" class="form-label">Product Id</label>
                                        <input type="text" class="form-control form-control-sm" id="product_id"
                                            name="product_id" />
                                    <?php echo form_error('product_id', '<div class="error">', '</div>'); ?>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control form-control-sm" id="product_name"
                                            name="product_name" placeholder="Enter Product Name" />
                                    <?php echo form_error('product_name', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select form-select-sm" id="category" name="     l1c_id">
                                            <option selected>Select Category</option>
                                            <option value="1">One</option>
                                            
                                            <?php ?>
                                            </select>
                                    <?php echo form_error('l1c_id', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="sub_category" class="form-label">Sub Category</label>
                                        <select class="form-select form-select-sm" id="sub_category"
                                            name="l2c_id">
                                            <option selected>Select Sub Category</option>
                                            <option value="1">One</option>
                                           
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
                                            name="quantity" placeholder="Enter Qunatity" />
                                    <?php echo form_error('quantity', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-2">
                                        <label for="mrp" class="form-label">MRP (INR)</label>
                                        <input type="text" class="form-control form-control-sm" id="mrp" name="mrp"
                                            placeholder="Enter MRP in Rs." />
                                    <?php echo form_error('mrp', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-2">
                                        <label for="price" class="form-label">Selling Price (INR)</label>
                                        <input type="text" class="form-control form-control-sm" id="price" name="price"
                                            placeholder="Enter Selling in Rs." />
                                    <?php echo form_error('price', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-2">
                                        <label for="discount" class="form-label">Discount (INR)</label>
                                        <input type="text" class="form-control form-control-sm" id="discount_percent"
                                            name="discount_percent" placeholder="Enter discount in Rs." />
                                    <?php echo form_error('discount_percent', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-2">
                                        <label for="purchase_price" class="form-label">Purchase Price (Optional)</label>
                                        <input type="text" class="form-control form-control-sm" id="purchase_price"
                                            name="purchase_price" placeholder="Enter Purchase Price" />
                                    <?php echo form_error('purchase_price', '<div class="error">', '</div>'); ?>

                                    </div>
                                </div>
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-2">
                                        <label for="unit_id" class="form-label">Unit</label>
                                        <select class="form-select form-select-sm" id="unit_id" name="unit_id">
                                            <option selected>Select</option>
                                            <option value="1">One</option>
                                          
                                        </select>
                                    <?php echo form_error('unit_id', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="hsn_code" class="form-label">GSTIN (HSN/SAC Code)</label>
                                        <input type="text" class="form-control form-control-sm" id="hsn_code"
                                            name="hsn_code" placeholder="Enter HSN/SAC Code" />
                                    <?php echo form_error('hsn_code', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="applicable_tax" class="form-label">Applicable Tax (GST)</label>
                                        <input type="text" class="form-control form-control-sm" id="applicable_tax"
                                            name="applicable_tax" />
                                    <?php echo form_error('applicable_tax', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-3">
                                        <label for="price_for_seller" class="form-label">Price For Seller</label>
                                        <input type="text" class="form-control form-control-sm" id="price_for_seller"
                                            name="price_for_seller" />
                                    <?php echo form_error('price_for_seller', '<div class="error">', '</div>'); ?>

                                    </div>
                                </div>
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-6">
                                        <label for="image" class="form-label">Upload Product Images</label>
                                        <input type="file" class="form-control form-control-sm" id="image"
                                            name="image" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="video" class="form-label">Upload Product Video</label>
                                        <input type="file" class="form-control form-control-sm" id="video"
                                            name="video" />
                                    </div>
                                </div>
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-10">
                                        <label for="short_description" class="form-label">Product Description</label>
                                        <textarea class="form-control" id="short_description"
                                            name="short_description"
                                            placeholder="Enter Product Description"></textarea>
                                    <?php echo form_error('product_id', '<div class="error">', '</div>'); ?>

                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-sm" style="background-color: #fff107;">ADD PRODUCT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>