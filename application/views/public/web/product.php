<?php defined('BASEPATH') or exit('No direct script access allowed');

?>
<!-- <?php print_r($products); ?> -->

<!-- page-title -->
<div class="ttm-page-title-row" style="background-image: url(<?php echo base_url()?>images/ttm-pagetitle-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="page-title-heading">
                        <h1 class="title">
                            <?php if (!empty($products)) : ?>
                                <?php echo $products[0]->l2_category ?>
                            <?php endif; ?>
                        </h1>
                    </div>
                    <div class="breadcrumb-wrapper">
                        <span class="mr-1"><i class="ti ti-home"></i></span>
                        <a title="Homepage" href="index.html">Home</a>
                        <span class="ttm-bread-sep">&nbsp;/&nbsp;</span>
                        <span class="ttm-textcolor-skincolor">
                            <?php if (!empty($products)) : ?>
                                <?php echo $products[0]->l1_category ?>
                            <?php endif; ?>
                        </span>
                        <span class="ttm-bread-sep">&nbsp;/&nbsp;</span>
                        <span class="ttm-textcolor-skincolor">
                            <?php if (!empty($products)) : ?>
                                <?php echo $products[0]->l2_category ?>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- page-title end-->


<!--site-main start-->
<div class="site-main">

    <!--shop-views-section-->
    <section class="shop-views-section clearfix">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="grid" role="tabpanel">
                        <div class="products row">
                                <?php if (!empty($products)) : ?>
                                    <?php foreach ($products as $product) : ?>
                                        <div class="product col-md-3 col-sm-6 col-xs-12">
                                            <div class="product-box">
                                                <!-- product-box-inner -->
                                                <div class="product-box-inner">
                                                    <div class="product-image-box">
                                                        <img class="img-fluid pro-image-front" src="<?php echo base_url($product_dir) . '' . $product->image->catalog_image ?>" alt="<?php echo $product->product_name; ?>">
                                                        <img class="img-fluid pro-image-back" src="<?php echo base_url($product_dir) . '' . $product->image->catalog_image ?>" alt="<?php echo $product->product_name; ?>">
                                                    </div>
                                                    <div class="product-btn-links-wrapper">
                                                        <div class="product-btn">
                                                            <a href="<?php echo base_url('product-detail') . '/' . urlencode(base64_encode($product->id)); ?>" class="add-to-cart-btn tooltip-top"><i class="ti ti-shopping-cart"></i> Product Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-content-box">
                                                    <a class="product-title" href="<?php echo base_url('product-detail') . '/' . urlencode(base64_encode($product->id)); ?>">
                                                        <h2><?php echo $product->product_name; ?></h2>
                                                    </a>
                                                    <div class="star-ratings">
                                                        <ul class="rating">
                                                            <li><i class="fa fa-star"></i></li>
                                                            <li><i class="fa fa-star"></i></li>
                                                            <li><i class="fa fa-star-o"></i></li>
                                                            <li><i class="fa fa-star-o"></i></li>
                                                            <li><i class="fa fa-star-o"></i></li>
                                                        </ul>
                                                    </div>
                                                    <span class="price">
                                                        <span class="product-Price-amount">
                                                            <span class="product-Price-currencySymbol">₹</span><?php echo $product->price; ?>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                   <!--  <div class="pagination-block res-991-mt-0">
                        <span class="page-numbers current">1</span>
                        <a class="page-numbers" href="#">2</a>
                        <a class="page-numbers" href="#">3</a>
                        <a class="next page-numbers" href="#"><i class="ti ti-arrow-right"></i></a>
                    </div> -->
                </div>
            </div><!-- row end -->
        </div>
    </section>
    <!--team-section end-->


</div>
<!--site-main end-->