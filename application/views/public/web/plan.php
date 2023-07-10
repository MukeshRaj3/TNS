<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div>
    <!-- Header Area End -->
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-12 text-center">
        <div class="container">
            <h1>Subscription Plans</h1>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home /</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscription Plans</li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Breadcrumb Area End -->
    <!-- Shop Area Start -->
    <div class="shop-area pt-110 pb-100 bg-gray mb-95 shop-full-width">
        <div class="container">
            <div class="section-title text-center mb-50">
                <div class="section-img d-flex justify-content-center">
                    <img src="<?php echo base_url($images_dir); ?>icon/title1.png" alt="">
                </div>
                <h2><span>Organic </span>Subscription plans</h2>
            </div>
        </div>
        <div class="container">
            <div class="ht-product-shop tab-content text-center" id="all">
                <div class="tab-pane active show fade" id="grid" role="tabpanel">
                    <?php if (!empty($subscriptions)) : ?>
                        <div class="row" id="first">
                            <div class="col-md-12">
                                <div class="text-left">
                                    <h3 class="text-left mt-4">1-2 Members Plan</h3>
                                </div>
                            </div>
                            <?php foreach ($subscriptions as $subscription) : ?>
                                <?php if ($subscription->id == '1' || $subscription->id == '2' || $subscription->id == '3') : ?>
                                    <div class="col-md-4">
                                        <div class="single-product-item m-2">
                                            <div class="product-image">
                                                <h3 class="fw-bolder text-uppercase pt-5">Silver</h3>
                                                <!-- <p class="fw-bolder text-clr mb-0">Economy Plan</p> -->
                                                <a href="#">
                                                    <!-- <img src="<?php echo base_url($images_dir); ?>product/2.jpg" alt=""> -->
                                                    <h2 class="fw-bolder text-uppercase pt-3"><?php echo intval($subscription->amount); ?>/mo.</h2>
                                                </a>
                                            </div>
                                            <div class="product-text">
                                                <div class="pro-des">
                                                    <hr>
                                                    <div class="d-flex">
                                                        <h4>Fresh Vegetables - </h4><span class="new-price text-clr"> <?php echo $subscription->fresh_veg; ?> Options</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Leafy & Seasonings - </h4><span class="new-price text-clr"> <?php echo $subscription->leafy; ?> Options</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Exotics - </h4><span class="new-price text-clr"><?php echo ($subscription->exotics != '0') ? $subscription->exotics : 'none'; ?></span>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex">
                                                        <h4>Max Order Qty. - </h4><span class="new-price text-clr"> Upto <?php echo $subscription->order_qty; ?> kg </span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Delivery Cycle - </h4><span class="new-price text-clr"> Every <?php echo $subscription->delivery_cycle; ?> Days</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Delivery in a month - </h4><span class="new-price text-clr"> <?php echo $subscription->delivery_in_month; ?> Times</span>
                                                    </div>
                                                    <hr>
                                                    <?php if (!empty($this->session->userdata('user_id'))) : ?>
                                                        <?php if (!empty($plan)) : ?>
                                                            <?php if ($plan->plan_id == $subscription->id) : ?>
                                                                <a href="<?php echo base_url('product/') . urlencode(base64_encode($plan->plan_id)); ?>" class="p-cart-btn plan_btn text-danger">Active Subscription</a>
                                                            <?php else : ?>
                                                                <a href="javascript:void(0)" class="p-cart-btn plan_btn">Upgrade Subscription</a>
                                                            <?php endif ?>
                                                        <?php else : ?>
                                                            <a href="<?php echo base_url('new-product/') . urlencode(base64_encode($subscription->id)); ?>" class="p-cart-btn plan_btn">Get Subscription</a>
                                                        <?php endif ?>
                                                    <?php else : ?>
                                                        <a href="<?php echo base_url('auth/login'); ?>#login_form" class="p-cart-btn plan_btn">Get Subscription</a>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="row" id="second">
                            <hr>
                            <div class="col-md-12">
                                <div class="text-left">
                                    <h3 class="text-left mt-4">3-4 Members Plan</h3>
                                </div>
                            </div>
                            <?php foreach ($subscriptions as $subscription) : ?>
                                <?php if ($subscription->id == '4' || $subscription->id == '5' || $subscription->id == '6') : ?>
                                    <div class="col-md-4">
                                        <div class="single-product-item m-2">
                                            <div class="product-image">
                                                <h3 class="fw-bolder text-uppercase pt-5">Silver</h3>
                                                <!-- <p class="fw-bolder text-clr mb-0">Economy Plan</p> -->
                                                <a href="#">
                                                    <!-- <img src="<?php echo base_url($images_dir); ?>product/2.jpg" alt=""> -->
                                                    <h2 class="fw-bolder text-uppercase pt-3"><?php echo intval($subscription->amount); ?>/mo.</h2>
                                                </a>
                                            </div>
                                            <div class="product-text">
                                                <div class="pro-des">
                                                    <hr>
                                                    <div class="d-flex">
                                                        <h4>Fresh Vegetables - </h4><span class="new-price text-clr"> <?php echo $subscription->fresh_veg; ?> Options</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Leafy & Seasonings - </h4><span class="new-price text-clr"> <?php echo $subscription->leafy; ?> Options</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Exotics - </h4><span class="new-price text-clr"><?php echo ($subscription->exotics != '0') ? $subscription->exotics : 'none'; ?></span>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex">
                                                        <h4>Max Order Qty. - </h4><span class="new-price text-clr"> Upto <?php echo $subscription->order_qty; ?> kg </span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Delivery Cycle - </h4><span class="new-price text-clr"> Every <?php echo $subscription->delivery_cycle; ?> Days</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Delivery in a month - </h4><span class="new-price text-clr"> <?php echo $subscription->delivery_in_month; ?> Times</span>
                                                    </div>
                                                    <hr>
                                                    <?php if (!empty($this->session->userdata('user_id'))) : ?>
                                                        <?php if (!empty($plan)) : ?>
                                                            <?php if ($plan->plan_id == $subscription->id) : ?>
                                                                <a href="<?php echo base_url('product/') . urlencode(base64_encode($plan->plan_id)); ?>" class="p-cart-btn plan_btn text-danger">Active Subscription</a>
                                                            <?php else : ?>
                                                                <a href="javascript:void(0)" class="p-cart-btn plan_btn">Upgrade Subscription</a>
                                                            <?php endif ?>
                                                        <?php else : ?>
                                                            <a href="<?php echo base_url('new-product/') . urlencode(base64_encode($subscription->id)); ?>" class="p-cart-btn plan_btn">Get Subscription</a>
                                                        <?php endif ?>
                                                    <?php else : ?>
                                                        <a href="<?php echo base_url('auth/login'); ?>#login_form" class="p-cart-btn plan_btn">Get Subscription</a>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="row" id="third">
                            <hr>
                            <div class="col-md-12">
                                <div class="text-left">
                                    <h3 class="text-left mt-4">5-7 Members Plan</h3>
                                </div>
                            </div>
                            <?php foreach ($subscriptions as $subscription) : ?>
                                <?php if ($subscription->id == '7' || $subscription->id == '8' || $subscription->id == '9') : ?>
                                    <div class="col-md-4">
                                        <div class="single-product-item m-2">
                                            <div class="product-image">
                                                <h3 class="fw-bolder text-uppercase pt-5">Silver</h3>
                                                <!-- <p class="fw-bolder text-clr mb-0">Economy Plan</p> -->
                                                <a href="#">
                                                    <!-- <img src="<?php echo base_url($images_dir); ?>product/2.jpg" alt=""> -->
                                                    <h2 class="fw-bolder text-uppercase pt-3"><?php echo intval($subscription->amount); ?>/mo.</h2>
                                                </a>
                                            </div>
                                            <div class="product-text">
                                                <div class="pro-des">
                                                    <hr>
                                                    <div class="d-flex">
                                                        <h4>Fresh Vegetables - </h4><span class="new-price text-clr"> <?php echo $subscription->fresh_veg; ?> Options</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Leafy & Seasonings - </h4><span class="new-price text-clr"> <?php echo $subscription->leafy; ?> Options</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Exotics - </h4><span class="new-price text-clr"><?php echo ($subscription->exotics != '0') ? $subscription->exotics : 'none'; ?></span>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex">
                                                        <h4>Max Order Qty. - </h4><span class="new-price text-clr"> Upto <?php echo $subscription->order_qty; ?> kg </span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Delivery Cycle - </h4><span class="new-price text-clr"> Every <?php echo $subscription->delivery_cycle; ?> Days</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <h4>Delivery in a month - </h4><span class="new-price text-clr"> <?php echo $subscription->delivery_in_month; ?> Times</span>
                                                    </div>
                                                    <hr>
                                                    <?php if (!empty($this->session->userdata('user_id'))) : ?>
                                                        <?php if (!empty($plan)) : ?>
                                                            <?php if ($plan->plan_id == $subscription->id) : ?>
                                                                <a href="<?php echo base_url('product/') . urlencode(base64_encode($plan->plan_id)); ?>" class="p-cart-btn plan_btn text-danger">Active Subscription</a>
                                                            <?php else : ?>
                                                                <a href="javascript:void(0)" class="p-cart-btn plan_btn">Upgrade Subscription</a>
                                                            <?php endif ?>
                                                        <?php else : ?>
                                                            <a href="<?php echo base_url('new-product/') . urlencode(base64_encode($subscription->id)); ?>" class="p-cart-btn plan_btn">Get Subscription</a>
                                                        <?php endif ?>
                                                    <?php else : ?>
                                                        <a href="<?php echo base_url('auth/login'); ?>#login_form" class="p-cart-btn plan_btn">Get Subscription</a>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Area End -->
</div>