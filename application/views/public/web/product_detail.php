<?php defined('BASEPATH') or exit('No direct script access allowed');
// print_r($product);
?>
<?php if (!empty($product)) : ?>
    <!-- page-title -->
    <div class="ttm-page-title-row" style="background-image: url(<?php echo base_url()?>images/ttm-pagetitle-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="page-title-heading">
                            <h1 class="title"><?php echo $product->product_name; ?></h1>
                        </div>
                        <div class="breadcrumb-wrapper">
                            <span class="mr-1"><i class="ti ti-home"></i></span>
                            <a title="Homepage" href="<?php echo base_url(); ?>">Home</a>
                            <span class="ttm-bread-sep">&nbsp;/&nbsp;</span>
                            <span class="ttm-textcolor-skincolor">
                                <?php echo $product->l1_category; ?>
                            </span>
                            <span class="ttm-bread-sep">&nbsp;/&nbsp;</span>
                            <span class="ttm-textcolor-skincolor">
                                <?php echo $product->l2_category; ?>
                            </span>
                            <span class="ttm-bread-sep">&nbsp;/&nbsp;</span>
                            <span class="">
                                <?php echo $product->product_name; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- page-title end-->

    <!--site-main start-->
    <div class="site-main">

        <!-- single-product-section -->
        <section class="single-product-section layout-1 clearfix">
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ttm-single-product-details">
                            <div class="ttm-single-product-info clearfix">
                                <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 ml-auto mr-auto">
                                        <div class="product-gallery easyzoom-product-gallery">
                                            <div class="product-look-views left">
                                                <div class="mt-35 mb-35">
                                                    <ul class="thumbnails easyzoom-gallery-slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 1, "arrows":true, "infinite":true, "vertical":true}'>
                                                        <?php if (!empty($product->images)) : ?>
                                                            <?php foreach ($product->images as $image) : ?>
                                                                <li>
                                                                    <a href="<?php echo base_url($product_dir) . $image->catalog_image; ?>" data-standard="<?php echo base_url($product_dir) . $image->catalog_image; ?>">
                                                                        <img class="img-fluid border" src="<?php echo base_url($product_dir) . $image->catalog_image; ?>" alt="" />
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php if (!empty($product->images)) : ?>
                                            <div class="product-look-preview-plus right  ">
                                                <div class="pl-35 res-767-pl-15">
                                                    <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails text-center border ">
                                                        <a href="<?php echo base_url($product_dir) . $product->images[0]->catalog_image; ?>">
                                                            <img class="img-fluid" src="<?php echo base_url($product_dir) . $product->images[0]->catalog_image; ?>" alt="" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="summary entry-summary pl-30 res-991-pl-0 res-991-pt-40">
                                            <h2 class="product_title entry-title  mb-25"><?php echo $product->product_name; ?></h2>
                                            <div class="product_in-stock text-success"><i class="fa fa-check-circle text-success"></i><span class="text-success"> in Stock Only <?php echo $product->stock; ?> left</span></div>
                                            <span class="price">
                                                <ins><span class="product-Price-amount">
                                                        <span class="product-Price-currencySymbol">₹</span><?php echo $product->price; ?>
                                                    </span>
                                                </ins>
                                                <!-- <del><span class="product-Price-amount">
                                                        <span class="product-Price-currencySymbol">₹</span>123.00
                                                    </span>
                                                </del> -->
                                            </span>
                                            <div class="product-details__short-description"><?php echo $product->short_description.', '.$product->long_description; ?> Raising a heavy fur muff that covered the whole of her lower arm towards the viewer regor then turned to look out the window</div>
                                            
                                            <div class="mt-15 mb-25">
                                           
                                                <div class="quantity">
                                                    <label>Quantity: </label>
                                                    <div class="quantity">
                                                            <input type="hidden" value="0" id="bunch_id0">
                                                            <input type="number" value="1" min="1" id="quantity" name="quantity" class="qty" onkeypress="return IsNumeric(event);">
                                                            <span class="inc quantity-button">+</span>
                                                            <span class="dec quantity-button">-</span>
                                                    </div>
                                                </div>
                    
                                            </div>
                                          
                                                <!-- <div class="row">
                                                    <div class="col">
                                                        Quantity
                                                    </div>
                                                    <div class="col">
                                                        <div class="quantity">
                                                            <input type="hidden" value="0" id="bunch_id0">
                                                            <input type="text" value="1" min="1" id="quantity" name="quantity" class="qty">
                                                            <span class="inc quantity-button">+</span>
                                                            <span class="dec quantity-button">-</span>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-3">
                                                </div>
                                                <div class="actions">
                                                    <div class="add-to-cart">
                                                        <button class="ttm-btn ttm-btn-size-md ttm-btn-shape-square ttm-btn-style-fill bg-success text-white" href="javascript:void(0)" id="printcart<?php echo $product->id ?>" onclick="add_to_cart('<?php echo $product->id; ?>', '0')">Add to cart</button>
                                                    </div>
                                                </div>
                                           
                                            <div id="block-reassurance-1" class="block-reassurance">
                                                <ul>
                                                    <li>
                                                        <div class="block-reassurance-item">
                                                            <i class="fa fa-lock"></i>
                                                            <span>Security policy (edit with Customer reassurance module)</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="block-reassurance-item">
                                                            <i class="fa fa-truck"></i>
                                                            <span>Delivery policy (edit with Customer reassurance module)</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="block-reassurance-item">
                                                            <i class="fa fa-arrows-h"></i>
                                                            <span>Return policy (edit with Customer reassurance module)</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-30 pb-60 res-991-pt-0 res-991-pb-30">
                                <div class="row no-gutters ttm-bgcolor-grey border">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <!-- featured-icon-box -->
                                        <div class="featured-icon-box style3 text-center">
                                            <div class="ttm-icon ttm-icon_element-color-skincolor ttm-icon_element-size-md">
                                                <i class="themifyicon ti-truck"></i>
                                            </div>
                                            <div class="featured-content">
                                                <div class="featured-title">
                                                    <h5>Fast & Free Shopping</h5>
                                                </div>
                                                <div class="featured-desc">
                                                    <p>All Order Over ₹199</p>
                                                </div>
                                            </div>
                                        </div><!-- featured-icon-box end-->
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <!-- featured-icon-box -->
                                        <div class="featured-icon-box style3 text-center">
                                            <div class="ttm-icon ttm-icon_element-color-skincolor ttm-icon_element-size-md">
                                                <i class="themifyicon ti-reload"></i>
                                            </div>
                                            <div class="featured-content">
                                                <div class="featured-title">
                                                    <h5>100% Money Back Guaranty</h5>
                                                </div>
                                                <div class="featured-desc">
                                                    <p>30 Days Money Return</p>
                                                </div>
                                            </div>
                                        </div><!-- featured-icon-box end-->
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <!-- featured-icon-box -->
                                        <div class="featured-icon-box style3 text-center">
                                            <div class="ttm-icon ttm-icon_element-color-skincolor ttm-icon_element-size-md">
                                                <i class="themifyicon ti-comments"></i>
                                            </div>
                                            <div class="featured-content">
                                                <div class="featured-title">
                                                    <h5>Support 24/7 Days</h5>
                                                </div>
                                                <div class="featured-desc">
                                                    <p>Hot Line: +123 456 789</p>
                                                </div>
                                            </div>
                                        </div><!-- featured-icon-box end-->
                                    </div>
                                </div>
                            </div>
                            <div class="ttm-tabs tabs-for-single-products" data-effect="fadeIn">
                                <ul class="tabs clearfix">
                                    <li class="tab active"><a href="#">Product description</a></li>
                                    <li class="tab"><a href="#">Privacy policy</a></li>
                                    <li class="tab"><a href="#">Customer reviews</a></li>
                                    <li class="tab"><a href="#">Terms Of Service</a></li>
                                </ul>
                                <div class="content-tab">
                                    <!-- content-inner -->
                                    <div class="content-inner">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        <div class="pt-10">
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always fr</p>
                                        </div>
                                        <div class="pt-15">
                                            <h6>Item Features</h6>
                                            <ul class="ttm-list ttm-list-style-icon ttm-list-icon-color-skincolor">
                                                <li><i class="fa fa-check"></i><span class="ttm-list-li-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span></li>
                                                <li><i class="fa fa-check"></i><span class="ttm-list-li-content">Aliquam eu dolor imperdiet, scelerisque nibh ac, fermentum ligula.</span></li>
                                                <li><i class="fa fa-check"></i><span class="ttm-list-li-content">Contar iquam luctus lorem eget elementum euismod.</span></li>
                                                <li><i class="fa fa-check"></i><span class="ttm-list-li-content">Fusce id justo ac erat suscipit euismod.</span></li>
                                                <li><i class="fa fa-check"></i><span class="ttm-list-li-content">Aenean consectetur est blandit magna dictum.</span></li>
                                                <li><i class="fa fa-check"></i><span class="ttm-list-li-content">Vestibulum sit amet nulla eu justo venenatis.</span></li>
                                                <li><i class="fa fa-check"></i><span class="ttm-list-li-content">Suspendisse id metus rutrum, dictum massa vitae.</span></li>
                                            </ul>
                                        </div>
                                    </div><!-- content-inner end-->
                                    <!-- content-inner -->
                                    <div class="content-inner">
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                        <strong>Contrary to popular belief</strong>
                                        <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                                        <strong>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below:</strong>
                                        - It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                                        - The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.
                                        - Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.
                                        - Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                        <p> It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        [[INSERT ANY OTHER INFORMATION YOU COLLECT: OFFLINE DATA, PURCHASED MARKETING DATA/LISTS]]
                                    </div><!-- content-inner end-->
                                    <!-- content-inner -->
                                    <div class="content-inner">
                                        <div id="reviews" class="woocommerce-Reviews">
                                            <div id="comments">
                                                <ol class="commentlist">
                                                    <li class="review">
                                                        <div class="comment_container">
                                                            <img class="avatar" src="images/blog/blog-comment-01.jpg" alt="comment-img">
                                                            <div class="comment-text">
                                                                <ul class="star-rating">
                                                                    <li class="fa fa-star"></li>
                                                                    <li class="fa fa-star"></li>
                                                                    <li class="fa fa-star"></li>
                                                                    <li class="fa fa-star"></li>
                                                                    <li class="fa fa-star"></li>
                                                                </ul>
                                                                <p class="meta">
                                                                    <strong class="eview__author">Cherie </strong><span class="review__dash">–</span>
                                                                    <time class="woocommerce-review__published-date" datetime="2018-11-01T04:58:58+00:00">Apr 1, 2019</time>
                                                                </p>
                                                                <div class="description">
                                                                    <p>Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante<br>Very good product and amazing quality.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="review">
                                                        <div class="comment_container">
                                                            <img class="avatar" src="images/blog/blog-comment-02.jpg" alt="comment-img">
                                                            <div class="comment-text">
                                                                <ul class="star-rating">
                                                                    <li class="fa fa-star"></li>
                                                                    <li class="fa fa-star"></li>
                                                                    <li class="fa fa-star"></li>
                                                                    <li class="fa fa-star"></li>
                                                                    <li class="fa fa-star"></li>
                                                                </ul>
                                                                <p class="meta">
                                                                    <strong class="eview__author">Cherie </strong><span class="review__dash">–</span>
                                                                    <time class="woocommerce-review__published-date" datetime="2018-11-01T04:58:58+00:00">Apr 1, 2019</time>
                                                                </p>
                                                                <div class="description">
                                                                    <p>Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante<br>Very good product and amazing quality.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div id="review_form_wrapper">
                                                <div class="comment-respond">
                                                    <span class="comment-reply-title">Add a review
                                                        <small><a rel="nofollow" id="cancel-comment-reply-link" href="#">Cancel reply</a></small>
                                                    </span>
                                                    <form action="#" method="post" id="commentform" class="comment-form">
                                                        <p class="comment-notes">
                                                            <span id="email-notes">Your email address will not be published.</span> Required fields are marked <span class="required">*</span>
                                                        </p>
                                                        <div class="comment-form-rating">
                                                            <label for="rating">Your rating</label>
                                                            <ul class="stars">
                                                                <li class="fa fa-star-o"></li>
                                                                <li class="fa fa-star-o"></li>
                                                                <li class="fa fa-star-o"></li>
                                                                <li class="fa fa-star-o"></li>
                                                                <li class="fa fa-star-o"></li>
                                                            </ul>
                                                            <select name="rating" id="rating" required="" tabindex="-1">
                                                                <option value="">Rate…</option>
                                                                <option value="5">Perfect</option>
                                                                <option value="4">Good</option>
                                                                <option value="3">Average</option>
                                                                <option value="2">Not that bad</option>
                                                                <option value="1">Very poor</option>
                                                            </select>
                                                        </div>
                                                        <p class="comment-form-comment">
                                                            <label for="comment">Your review&nbsp;<span class="required">*</span></label>
                                                            <textarea id="comment" name="comment" cols="45" rows="8" required=""></textarea>
                                                        </p>
                                                        <p class="comment-form-author">
                                                            <label for="author">Name&nbsp;<span class="required">*</span></label>
                                                            <input id="author" name="author" type="text" value="" required="">
                                                        </p>
                                                        <p class="comment-form-email">
                                                            <label for="email">Email&nbsp;<span class="required">*</span></label>
                                                            <input id="email" name="email" type="email" value="" required="">
                                                        </p>
                                                        <p class="form-submit">
                                                            <input name="submit" type="submit" class="submit" value="Submit">
                                                        </p>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- content-inner -->
                                    <div class="content-inner">
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                        <strong>Contrary to popular belief</strong>
                                        <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                                        <strong>section-1</strong>
                                        <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                                        <strong>section-2</strong>
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                        <p> It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        [[INSERT ANY OTHER INFORMATION YOU COLLECT: OFFLINE DATA, PURCHASED MARKETING DATA/LISTS]]
                                        <br><br>
                                        <strong>CONTACT_INFORMATION</strong>
                                        Questions about the Terms of Service should be sent to us.....
                                    </div><!-- content-inner end-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </div>

<?php endif; ?>