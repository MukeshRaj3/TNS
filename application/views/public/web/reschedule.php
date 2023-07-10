<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <!-- <div class="breadcrumb-area bg-12 text-center">
        <div class="container">
            <h1>My Account</h1>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li> /
                    <li class="breadcrumb-item active" aria-current="page">Orders</li>
                </ul>
            </nav>
        </div>
    </div> -->
    <!-- Breadcrumb Area End -->
    <!-- my account wrapper start -->
    <div class="my-account-wrapper pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" class="" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                        Dashboard</a>
                                    <a href="#orders" class="active" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                                    <!-- <a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i> Download</a>
                                    <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payment
                                        Method</a>
                                    <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i> address</a>
                                    <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account Details</a>
                                    <a href="login-register.html"><i class="fa fa-sign-out"></i> Logout</a> -->
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                    <?php if ($this->session->flashdata('message') !== NULL) { ?>
                                        <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                                                <?php echo $this->session->flashdata('message')['1']; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                <?php } ?>
                        
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong>Alex Tuntuni</strong> (If Not <strong>Tuntuni !</strong><a href="login-register.html" class="logout"> Logout</a>)</p>
                                            </div>
                                            <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <!-- <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order Number</th>
                                                            <th>Order Id</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if ($orders) : ?>
                                                            <?php foreach ($orders as $key => $value) :  ?>
                                                                <tr>
                                                                    <td><?php echo $value->id; ?></td>
                                                                    <td><?php echo $value->order_no; ?></td>
                                                                    <td><?php echo $value->order_datetime; ?></td>
                                                                    <td>
                                                                        <?php if ($value->delivered == '0') :
                                                                            echo 'Pending'; ?>
                                                                        <?php else :
                                                                            echo 'Delivered';
                                                                        endif;
                                                                        ?>

                                                                    </td>
                                                                    <td><a href="#" class="check-btn sqr-btn ">View</a></td>
                                                                </tr>

                                                            <?php endforeach  ?>
                                                        <?php endif; ?>

                                                    </tbody>
                                                </table> -->
                                                <?php if(!empty($order)): ?>
                                                <?php echo form_open("welcome/place_order"); ?>
                                                <div class="col-12">
                                                    <input type="hidden" name="order_id" value="<?php echo $order->id ?>">
                                                    <div class="input-group date" style="display:inline-table;">
                                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                        <input type="text" class="form-control w-100 datepicker input-sm pull-right" id="from_date" data-date-end-date="0d" name="place_order_date" value="" placeholder="From Date" required onkeypress="return IsReadonly(event);" autocomplete="off" style="position:static;">
                                                    </div>

                                                </div>
                                                <div class="signup-login text-center">
                                                    <p class="white" style="margin-top: 20px;">
                                                        <button type="submit" >Place Order</button>
                                                    </p>
                                                </div>
                                                <?php echo form_close(); ?>
                                                <?php endif ?>
                                                <!-- <a class="btn btn-success" href="<?php echo base_url('welcome/orders') ?>"> go to your orders</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>