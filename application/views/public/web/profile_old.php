<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="breadcrumb-area bg-12 text-center">
        <div class="container">
            <h1>My Account</h1>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Breadcrumb Area End -->
    <!-- my account wrapper start -->
    <div class="my-account-wrapper pt-120 pb-120" id="profile_view">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                        Dashboard</a>
                                    <a href="#orders" class="active" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                                    <!-- <a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i> Download</a> -->
                                    <a href="#payments" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payments</a>
                                    <a href="#subscription" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Subscription</a>
                                    <a href="#change_password" data-bs-toggle="tab"><i class="fa fa-user"></i> Change Password</a>
                                    <a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong><?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?></strong> (<strong><?php echo $this->session->userdata('email') ?></strong>)</p>
                                            </div>

                                            <p class="mb-0">Hello This is Bhoomi Farm dashboard</p>
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

                                                                        <?php elseif ($value->delivered == '0') : ?>
                                                                            <a href="javascript:void(0)"><span class="badge bg-secondary">Order Not Placed</span></a>
                                                                        <?php elseif ($value->delivered == '2') : ?>
                                                                            <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-primary">Order Processing</span></a>
                                                                        <?php elseif ($value->delivered == '3') : ?>
                                                                            <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-danger">Cancel Order</span></a>
                                                                        <?php elseif ($value->delivered == '4') : ?>
                                                                            <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-primary">Reschedule Order </span></a>
                                                                        <?php elseif ($value->delivered == '5') : ?>
                                                                            <a href="<?php echo base_url('welcome/order_processing') ?>"><span class="badge bg-secondary">Pause Order</span></a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                Orders
                                                                            </button>
                                                                            <?php if ($value->delivered == '4' || $value->delivered == '1') : ?>
                                                                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">

                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/cancel_order') . '/' . $value->id; ?>">Cancel Order</a></li>
                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/pause_order') . '/' . $value->id; ?>">Pause Order</a></li>
                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/reschedule_order') . '/' . $value->id; ?>">Reschedule Order</a></li>
                                                                                </ul>
                                                                            <?php elseif ($value->delivered == '5') : ?>
                                                                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/cancel_order') . '/' . $value->id; ?>">Cancel Order</a></li>
                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/reschedule_order') . '/' . $value->id; ?>">Reschedule Order</a></li>
                                                                                </ul>
                                                                            <?php endif; ?>
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
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
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
                                    <div class="tab-pane fade" id="subscription" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Subscription</h3>
                                            <div class="myaccount-table text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Subscription Id</th>
                                                            <th>Name</th>
                                                            <th>Members</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($subscriptions)) : ?>
                                                            <?php foreach ($subscriptions as $key => $value) :  ?>
                                                                <tr>
                                                                    <td><?php echo $value->id; ?></td>
                                                                    <td><?php echo $value->name; ?></td>
                                                                    <td><?php echo $value->nop . ' Members'; ?></td>
                                                                    <td>
                                                                        <?php if ($value->p_status == '1') : ?>
                                                                            <span class="badge bg-primary">Active</span>

                                                                        <?php elseif ($value->p_status === '2') : ?>
                                                                            <span class="badge bg-danger">Cancel</span>
                                                                        <?php elseif ($value->p_status === '3') : ?>
                                                                            <span class="badge bg-secondary">Pause</span>
                                                                        <?php elseif ($value->p_status === '4') : ?>
                                                                            <span class="badge bg-danger">Expire</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                Action
                                                                            </button>
                                                                            <?php if ($value->p_status == '1') : ?>
                                                                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">

                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/cancel_plan') . '/' . $value->pid; ?>">Cancel Subscription</a></li>
                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/pause_plan') . '/' . $value->pid; ?>">Pause Subscription</a></li>
                                                                                </ul>
                                                                            <?php elseif ($value->p_status == '3') : ?>
                                                                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/resume_plan') . '/' . $value->pid; ?>">Resume Subscription</a></li>

                                                                                    <li><a class="dropdown-item" href="<?php echo base_url('welcome/cancel_plan') . '/' . $value->pid; ?>">Cancel Subscription</a></li>
                                                                                </ul>
                                                                            <?php endif; ?>
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
                                    <div class="tab-pane fade" id="change_password" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Password change</h3>
                                            <div class="account-details-form">
                                                <form method="post" id="change_submit">
                                                    <fieldset>
                                                        <!-- <legend></legend> -->
                                                        <div class="single-input-item">
                                                            <label for="old_password" class="required">Current Password</label>
                                                            <input type="password" name="password" id="old_password" />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="new_password" class="required">New Password</label>
                                                                    <input type="password" name="new_password" id="new_password" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="confirm_password" class="required">Confirm Password</label>
                                                                    <input type="password" name="confirm_password" id="confirm_password" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="single-input-item">
                                                        <button class="check-btn sqr-btn" type="submit">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
</div>