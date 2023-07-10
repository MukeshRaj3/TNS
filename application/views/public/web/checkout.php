<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- page-title -->
<div class="ttm-page-title-row" style="background-image: url(<?php echo base_url() ?>images/ttm-pagetitle-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="page-title-heading">
                        <h1 class="title">Checkout</h1>
                    </div>
                    <div class="breadcrumb-wrapper">
                        <span class="mr-1"><i class="ti ti-home"></i></span>
                        <a title="Homepage" href="index.html">Home</a>
                        <span class="ttm-bread-sep">&nbsp;/&nbsp;</span>
                        <span class="ttm-textcolor-skincolor">Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- page-title end-->

<!--site-main start-->
<div class="site-main">

    <!-- checkout-section -->
    <section class="checkout-section clearfix">
        <div class="container">
            <?php if ($this->session->flashdata('message') !== NULL) { ?>
                <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('message')['1']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <div class="row">
                <!-- <div class="col-lg-12">
                        <div class="ttm-form-tag">
                            <div class="checkout-top-form-tag"> Have a coupon? <a href="#">Click here to enter your code</a></div>
                        </div>
                        <div class="ttm-form-tag">
                            <div class="checkout-top-form-tag"> Returning customer? <a href="#">Click here to login</a></div>
                        </div>
                    </div> -->
                <div class="col-lg-6">
                    <div class="billing-fields">
                        <div class="content-sec-head-style">
                            <div class="content-area-sec-title">
                                <h5>Billing details</h5>
                            </div>
                        </div>
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header card-bg" id="headingOne">

                                    <button class="btn btn-link collapsed text-decoration-none" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <h6 class="mb-0 ">Add New Address</h6>
                                    </button>

                                </div>

                                <div id="collapseThree" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                        $attributes = array('id' => 'add_address');
                                        echo form_open("welcome/add_address", $attributes); ?>

                                        <div class="billing-fields-wrapper pt-10">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="checkout-form-list ">
                                                        <!-- <label for="first_name">First Name <span class="required">*</span></label> -->
                                                        <input type="text" name="first_name" id="first_name" class="input-text" placeholder="First name" onkeydown="checkCharacterOnly(event);" maxlength="100" autocomplete="off" value="<?php echo $this->input->post('first_name'); ?>">
                                                        <div class="error"><?php echo form_error('first_name'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="checkout-form-list">
                                                        <!-- <label for="last_name">Last Name <span class="required">*</span></label> -->
                                                        <input type="text" name="last_name" id="last_name" class="input-text" placeholder="Last name" onkeydown="checkCharacterOnly(event);" maxlength="100" autocomplete="off" value="<?php echo $this->input->post('last_name'); ?>">
                                                        <div class="error"><?php echo form_error('last_name'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="checkout-form-list mt-4">
                                                        <!-- <label for="address">Address <span class="required">*</span></label> -->
                                                        <input type="text" name="address" id="address" class="input-text" placeholder="Apartment, suite, unit etc." maxlength="100" autocomplete="off" value="<?php echo $this->input->post('address'); ?>">
                                                        <div class="error"><?php echo form_error('address'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="checkout-form-list mt-4">
                                                        <!-- <label for="last_name">Land Mark <span class="required">*</span></label> -->
                                                        <input type="text" name="land_mark" id="land_mark" class="input-text" placeholder="Land Mark." maxlength="100" autocomplete="off" value="<?php echo $this->input->post('land_mark'); ?>">
                                                        <div class="error"><?php echo form_error('land_mark'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="checkout-form-list mt-4">
                                                        <!-- <label for="city">City / Town <span class="required">*</span></label> -->
                                                        <input type="text" name="city" id="city" class="input-text" placeholder="City / Town" maxlength="100" autocomplete="off" value="<?php echo $this->input->post('city'); ?>">
                                                        <div class="error"><?php echo form_error('city'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="checkout-form-list mt-4">
                                                        <!-- <label for="state">State / County <span class="required">*</span></label> -->
                                                        <input type="text" name="state" id="state" class="input-text" placeholder="State / County" maxlength="100" autocomplete="off" value="<?php echo $this->input->post('state'); ?>">
                                                        <div class="error"><?php echo form_error('state'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="checkout-form-list mt-4">
                                                        <!-- <label for="postcode">Postcode / Zip <span class="required">*</span></label> -->
                                                        <input type="text" name="postcode" id="postcode" class="input-text" placeholder="Postcode / Zip" maxlength="100" autocomplete="off" value="<?php echo $this->input->post('postcode'); ?>">
                                                        <div class="error"><?php echo form_error('postcode'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="checkout-form-list mt-4">
                                                        <!-- <label for="email" class="form-label">Contact Email <span class="required">*</span></label> -->
                                                        <input type="text" name="email" value="<?php echo $this->input->post('email'); ?>" id="email" class="input-text" placeholder="Email" autocomplete="off" role="presentation">
                                                        <div class="error"><?php echo form_error('email'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="checkout-form-list mt-4">
                                                        <!-- <label for="phone" class="form-label">Contact Tel Number <span class="required">*</span></label> -->
                                                        <input type="text" name="phone" id="phone" class="input-text" placeholder="Business Tel Number" maxlength="10" onkeydown="checkNumberOnly(event);" autocomplete="off" value="<?php echo $this->input->post('phone'); ?>">
                                                        <div class="error"><?php echo form_error('phone'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="order-button-payment mt-4">
                                                        <input class="button btn-primary text-white p-3" id="add_address" type="submit" value="Add New" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php
                        $attributes = array('id' => '');
                        echo form_open("welcome/place_order", $attributes); ?>
                        <?php if (!empty($carts['addresses'])) {
                            foreach ($carts['addresses'] as $key => $addr) {
                                // print_r($addr);
                        ?>
                                <div class="checkout-payment-method mt-4 mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" id="address_details<?php echo $addr->id ?>" type="radio" name="address_id" value="<?php echo $addr->id ?>" required>
                                        <label class="form-check-label" for="address_details<?php echo $addr->id ?>">
                                            Select Address
                                            <!-- </label> -->
                                    </div>
                                    <label class="d-flex w-100 text-capitalize" for="address_details<?php echo $addr->id ?>">
                                        <p class="width:10px p-2"><?php echo $addr->first_name . ' ' . $addr->last_name . ', ' . $addr->address . ', ' . $addr->land_mark . ', ' . $addr->city . ', ' . $addr->state  . ', ' . $addr->postcode . ', ' . $addr->email . ', ' . $addr->phone ?></p>
                                        <!-- </label> -->
                                </div>
                        <?php }
                        }

                        ?>

                    </div>
                </div>
                <div class="col-lg-6">

                    <div class=" res-991-pt-15">
                        <div class="content-sec-head-style">
                            <div class="content-area-sec-title">
                                <h5>Your Orders</h5>
                            </div>
                        </div>
                        <div id="order_review" class="checkout-review-order">
                            <table class="cart_table checkout-review-order-table">
                                <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-total text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="checkout_data">

                                </tbody>
                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td>
                                            <span class="Price-amount amount">
                                                <span class="Price-currencySymbol">₹</span><span id="sub_total">220.00</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="cart-shipping">
                                        <th>Shipping</th>
                                        <td>
                                            <span class="Price-amount amount">
                                            <span class="Price-currencySymbol">₹ </span>
                                                <?php echo $delivery_charge; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td><strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol final_price"></span></span></strong> </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="text-right place-order mt-30">
                            <!-- <button type="submit" class="button" name="checkout_place_order" id="place_order" value="Place order" data-value="Place order">Place Order</button> -->
                            <input type="hidden" id="final_price" name="final_price" value="">
                            <input type="hidden" id="cart_product_id" name="cart" value="">
                            <input type="hidden" id="cart_qty_id" name="qty" value="">
                            <input type="hidden" id="shipping_charge" name="shipping_charge" value="<?php echo $delivery_charge; ?>">
                            <button class="button btn-primary text-white p-3" name="checkout_place_order" id="place_order" type="submit" value="Place order" data-value="Place order">Place Order</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
    </section>
</div>

<style>
    .error {
        color: red;
    }
</style>
<script>
    $(document).ready(function() {
        checkout_cart();
    });
</script>
<!--site-main end-->