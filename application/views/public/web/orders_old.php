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
                                     <a href="#payments" data-bs-toggle="tab"><i class="fa fa-money"></i> Payments</a>
                                   <!-- <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payment
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
                                        <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert"><?php echo $this->session->flashdata('message')['1']; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                <?php } ?>
                        
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <!-- <h3>Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong>Alex Tuntuni</strong> (If Not <strong>Tuntuni !</strong><a href="login-register.html" class="logout"> Logout</a>)</p>
                                            </div>

                                            <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p> -->
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Orders</h3>
                                            <div class="myaccount-table text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order Number</th>
                                                            <th>Order Id</th>
                                                            <th>Order Date</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($orders)) : ?>
                                                            <?php foreach ($orders as $key => $value) :  ?>
                                                                <tr>
                                                                    <td><?php echo $value->id; ?></td>
                                                                    <td><?php echo $value->order_no; ?></td>
                                                                    <td><?php echo date('d-m-Y', strtotime($value->order_datetime)); ?></td>
                                                                    <td><?php echo date('d-m-Y', strtotime($value->place_order_date)); ?></td>
                                                                    <td>
                                                                    <?php if ($value->delivered == '1') : ?>
                                                                        <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-primary">Order Processing</span></a>

                                                                    <?php elseif($value->delivered == '0'): ?>
                                                                            <a href="javascript:void(0)"><span class="badge bg-secondary">Order Not Placed</span></a>
                                                                    <?php elseif($value->delivered == '2'): ?>
                                                                            <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-primary">Order Processing</span></a>
                                                                    <?php elseif($value->delivered == '3') : ?>
                                                                            <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-danger">Cancel Order</span></a>
                                                                    <?php elseif($value->delivered == '4') : ?>
                                                                            <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-primary">Reschedule Order </span></a>
                                                                    <?php elseif($value->delivered == '5') : ?>
                                                                            <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-secondary">Pause Order</span></a>
                                                                     <?php   endif; ?>
                                                                    </td>
                                                                    <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            Orders
                                                                        </button>
                                                                        <?php if($value->delivered == '4' || $value->delivered == '1') : ?>
                                                                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                                                        
                                                                            <li><a class="dropdown-item" href="<?php echo base_url('welcome/cancel_order').'/'. $value->id; ?>">Cancel Order</a></li>
                                                                            <li><a class="dropdown-item" href="<?php echo base_url('welcome/pause_order').'/'. $value->id; ?>">Pause Order</a></li>
                                                                            <li><a class="dropdown-item" href="<?php echo base_url('welcome/reschedule_order').'/'. $value->id; ?>">Reschedule Order</a></li>
                                                                        </ul>
                                                                        <?php elseif($value->delivered == '5') : ?>
                                                                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                                                            <li><a class="dropdown-item" href="<?php echo base_url('welcome/cancel_order').'/'. $value->id; ?>">Cancel Order</a></li>
                                                                            <li><a class="dropdown-item" href="<?php echo base_url('welcome/reschedule_order').'/'. $value->id; ?>">Reschedule Order</a></li>
                                                                        </ul>
                                                                        <?php   endif; ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                            <?php endforeach  ?>
                                                        <?php endif; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="tab-pane fade" id="payments" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Payments</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Payment Reference</th>
                                                            <th>Payment Mode</th>
                                                            <th>Amount</th>
                                                            <th>Payment Status</th>
                                                            <th>Payment Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if (!empty($payments)) : ?>
                                                            <?php foreach ($payments as $key => $value) :  ?>
                                                                <tr>
                                                                    <td><?php echo $value->referenceId; ?></td>
                                                                    <td><?php echo $value->paymentMode; ?></td>
                                                                    <td><?php echo $value->orderAmount; ?></td>
                                                                    <td><?php echo $value->orderStatus; ?></td>
                                                                    <td><?php echo $value->payment_time; ?></td>
                                                                </tr>

                                                            <?php endforeach  ?>
                                                        <?php endif; ?>

                                                    </tbody>
                                                </table>
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