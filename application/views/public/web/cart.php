<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- page-title -->
<div class="ttm-page-title-row" style="background-image: url(<?php echo base_url()?>images/ttm-pagetitle-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="page-title-heading">
                        <h1 class="title">Cart</h1>
                    </div>
                    <div class="breadcrumb-wrapper">
                        <span class="mr-1"><i class="ti ti-home"></i></span>
                        <a title="Homepage" href="index.html">Home</a>
                        <span class="ttm-bread-sep">&nbsp;/&nbsp;</span>
                        <span class="ttm-textcolor-skincolor">Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- page-title end-->

<!--site-main start-->
<div class="site-main">

    <!-- cart-section -->
    <section class="cart-section clearfix">
        <div class="container-fluid">
            <!-- row -->
            <div class="row ">
                <div class="col-lg-9">
                    <!-- cart_table -->
                    <table class="table cart_table shop_table_responsive">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">Images</th>
                                <th class="product-name">Products</th>
                                <!-- <th class="product-name">Bunch</th> -->
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="cart_product">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="actions">
                                    <div class="coupon">
                                        <a class="ttm-btn ttm-btn-size-md ttm-btn-shape-square ttm-btn-style-fill ttm-icon-btn-left ttm-btn-color-skincolor" href="javascript:void(0)" onclick="window.history.go(-2); return false;"><i class="ti ti-arrow-left"></i>Back To Shop</a>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-3 cart-collaterals" id="cart_footer">
                    <div class="cart_totals res-767-mt-30">
                        <h5>Cart totals<span id="total_price"></span></h5>
                        <h5>Shipping</h5>
                        <p class="text-input">
                            <input type="radio" name="grpShipping" Checked>Standard<span class="total_shipping"></span>
                        </p>
                        <h5>Total<span class="final_price">₹1460.00</span></h5>
                    </div>
                    <div class="proceed-to-checkout">
                        <?php if (!empty($this->session->userdata('user_id'))) : ?>
                            <a href="<?php echo base_url('checkout'); ?>" class="checkout-button button">Proceed to checkout</a>
                        <?php else : ?>
                            <a href="<?php echo base_url('auth/session'); ?>" class="checkout-button button">Proceed to checkout</a>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </section><!-- cart-section end-->

</div>
<!--site-main end-->

<script>
    $(document).ready(function() {
        showCart();
    });
</script>