<?php

defined('BASEPATH') or exit('No direct script access allowed');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="keywords" content="" />

    <meta name="description" content="" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title> Vamonos Print | Home</title>



    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.png" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/bootstrap.min.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/animate.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/font-awesome.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/themify-icons.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/slick.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/slick-theme.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>revolution/css/layers.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>revolution/css/settings.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/magnific-popup.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/megamenu.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/shortcodes.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/main.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/responsive.css" />

</head>



<body>

    <div class="page">





        <header id="masthead" class="header ttm-header-style-01">

            <div class="header_main">

                <div class="container">

                    <div class="row">

                        <div class="col-lg-3 col-sm-3 col-3 order-1">

                            <div class="site-branding p-0">

                                <a class="home-link" href="<?php echo base_url(); ?>" title="Fixfellow" rel="home">

                                    <img src="<?php echo base_url(); ?>images/logo.png" alt="Site Logo" class="site-logo image-fluid">



                                </a>

                            </div>

                        </div>

                        <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right search-bar">

                            <div class="header_search">

                                <div class="header_search_content">

                                    <div id="search_block_top" class="search_block_top">

                                        <form id="searchbox" method="get" action="#">

                                            <input class="search_query form-control" type="text" id="search_query_top" name="s" placeholder="Search For Shopping...." value="">

                                            <div class="categories-block mr-0">

                                                <select id="search_category" name="search_category" class="form-control">

                                                    <option value="all">Choose Category...</option>

                                                    <?php

                                                    if (!empty($categories)) {

                                                        foreach ($categories as $key => $value) {

                                                    ?>

                                                            <option value="all"><?php echo $value->l1_category ?></option>

                                                    <?php

                                                        }
                                                    }

                                                    ?>

                                                </select>

                                            </div>

                                            <button type="submit" name="submit_search" class="btn btn-default button-search"><i class="fa fa-search"></i></button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-3 col-9 order-lg-3 order-2 text-lg-left text-right">

                            <div class="header_extra d-flex flex-row align-items-center justify-content-end">

                                <div class="account dropdown">

                                    <div class="d-flex flex-row align-items-center justify-content-start">

                                        <div class="account_icon">

                                            <i class="fa fa-user"></i>

                                        </div>

                                        <div class="account_content">

                                            <div class="account_text"><a href="#">Sign In</a></div>

                                        </div>

                                    </div>

                                    <div class="account_extra dropdown_link" data-toggle="dropdown">Account</div>

                                    <aside class="widget_account dropdown_content">

                                        <div class="widget_account_content">

                                            <ul>

                                                <?php if ($this->session->userdata('user_id')) : ?>

                                                    <li><i class="fa fa-sign-in mr-2"></i><a href="<?php echo base_url('auth/logout'); ?>">Logout</a>

                                                    </li>

                                                <?php else : ?>

                                                    <li><i class="fa fa-sign-in mr-2"></i><a href="<?php echo base_url('auth/login'); ?>">Login</a>

                                                    </li>

                                                    <li><i class="fa fa-sign-in mr-2"></i><a href="<?php echo base_url('auth/register'); ?>">Register</a></li>

                                                <?php endif; ?>

                                            </ul>

                                        </div>

                                    </aside>

                                </div>

                                <div class="cart dropdown">

                                    <div class="dropdown_link d-flex flex-row align-items-center justify-content-end">

                                        <div class="cart_icon">

                                            <i class="fa fa-shopping-cart"></i>

                                            <div class="cart_count" id="printcartValue">0</div>

                                        </div>

                                        <div class="cart_content">

                                            <a href="<?php echo base_url('product-cart'); ?>">

                                                <div class="cart_text" style="color:#ffd200;">My Cart</div>

                                                <!-- <div class="cart_price">₹257.00</div> -->

                                            </a>

                                        </div>

                                    </div>

                                    <!-- <aside class="widget_shopping_cart dropdown_content">

                            <ul class="cart-list">

                                <li>

                                    <a href="#" class="photo"><img src="<?php echo base_url(); ?>images/product/pro-front-22.png" class="cart-thumb" alt="" /></a>

                                    <h6><a href="#">Print T-shirt</a></h6>

                                    <p>2x - <span class="price">₹220.00</span></p>

                                </li>

                                <li>

                                    <a href="#" class="photo"><img src="<?php echo base_url(); ?>images/product/pro-front-33.png" class="cart-thumb" alt="" /></a>

                                    <h6><a href="#">Promotional Poster</a></h6>

                                    <p>1x - <span class="price">₹38.00</span></p>

                                </li>

                                <li class="total">

                                    <span class="pull-right"><strong>Total</strong>: ₹257.00</span>

                                    <a href="<?php echo base_url('product-cart'); ?>" class="btn btn-default btn-cart">Cart</a>

                                </li>

                            </ul>

                        </aside> -->

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div id="site-header-menu" class="site-header-menu ttm-bgcolor-white clearfix">

                <div class="site-header-menu-inner stickable-header">

                    <div class="container">

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="main_nav_content d-flex flex-row">

                                    <div class="cat_menu_container">

                                        <a href="#" class="cat_menu d-flex flex-row align-items-center">

                                            <div class="cat_icon"><i class="fa fa-bars"></i></div>

                                            <div class="cat_text">

                                                <span>Shop by</span>

                                                <h4>Categories</h4>

                                            </div>

                                        </a>

                                        <ul class="cat_menu_list menu-vertical">

                                            <li><a href="#" class="close-side"><i class="fa fa-times"></i></a></li>

                                            <?php if (!empty($categories)) : ?>

                                                <?php foreach ($categories as $category) : ?>

                                                    <li><a href="#"><?php echo $category->l1_category; ?></a></li>

                                                <?php endforeach; ?>

                                            <?php endif; ?>

                                        </ul>

                                    </div>

                                    <div id="site-navigation" class="site-navigation">

                                        <div class="btn-show-menu-mobile menubar menubar--squeeze">

                                            <span class="menubar-box">

                                                <span class="menubar-inner"></span>

                                            </span>

                                        </div>

                                        <nav class="menu menu-mobile" id="menu">

                                            <ul class="nav">

                                                <li class=" active">

                                                    <a href="<?php echo base_url(); ?>" class="mega-menu-link">Home</a>

                                                </li>

                                                <li class="">

                                                    <a href="<?php echo base_url('all-product'); ?>" class="mega-menu-link">Products</a>

                                                </li>

                                                <li class="mega-menu-item megamenu-fw">

                                                    <a href="#" class="mega-menu-link">Shop</a>

                                                    <ul class="mega-submenu megamenu-content" role="menu">

                                                        <li>

                                                            <div class="row">

                                                                <?php if (!empty($categories)) : ?>

                                                                    <?php foreach ($categories as $category) : ?>

                                                                        <div class="col-menu col-md-3">



                                                                            <a href="<?php echo base_url('subcategories') . '/' . urlencode(base64_encode($category->id)); ?>">

                                                                                <h6 class="title"><?php echo $category->l1_category; ?></h6>

                                                                            </a>



                                                                            <?php if (!empty($category->subcategories)) : ?>

                                                                                <div class="content">

                                                                                    <ul class="menu-col">

                                                                                        <?php foreach ($category->subcategories as $subcategory) : ?>

                                                                                            <li><a href="<?php echo base_url('product') . '/' . urlencode(base64_encode($subcategory->id)); ?>"><?php echo $subcategory->l2_category; ?></a>

                                                                                            </li>

                                                                                        <?php endforeach; ?>

                                                                                    </ul>

                                                                                </div>

                                                                            <?php endif; ?>

                                                                        </div>

                                                                    <?php endforeach; ?>

                                                                <?php endif; ?>

                                                                <div class="col-menu col-md-3">

                                                                    <div class="content">

                                                                        <ul class="menu-col">

                                                                            <li><a href="#">

                                                                                    <img class="img-fluid" src="<?php echo base_url(); ?>images/menu-item-banner.jpg" alt="bimg">

                                                                                </a>

                                                                            </li>

                                                                        </ul>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </li>

                                                    </ul>

                                                </li>

                                                <li class="">

                                                    <a href="#" class="mega-menu-link">About</a>

                                                </li>

                                                <li><a href="#">Contact Us</a></li>

                                            </ul>

                                        </nav>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </header>