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
        <div class="container mt-120">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="list-group">
                                    <a href="<?php echo base_url('profile') ?>" class="list-group-item list-group-item-action">
                                        Profile
                                    </a>
                                    <a href="<?php echo base_url('orders') ?>" class="list-group-item list-group-item-action">
                                        Orders
                                    </a>
                                    <a href="<?php echo base_url('payments') ?>" class="list-group-item list-group-item-action">Payments</a>
                                    <a href="<?php echo base_url('change-password') ?>" class="list-group-item list-group-item-action active">Change Password</a>
                                    <a href="<?php echo base_url('auth/logout') ?>" class="list-group-item list-group-item-action" tabindex="-1" aria-disabled="true">Logout</a>
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
                                    <div class="tab-pane  show active" id="change_password" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Password change</h3>
                                            <div class="account-details-form">
                                                <form method="post" id="change_submit">
                                                    <fieldset>
                                                        <!-- <legend></legend> -->
                                                        <div class="single-input-item">
                                                            <label for="old_password" class="required">Current Password</label>
                                                            <input type="password" name="password" id="old_password" />
                                                            <div class="error"><?php echo form_error('password'); ?></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="new_password" class="required">New Password</label>
                                                                    <input type="password" name="new_password" id="new_password" />
                                                                    <div class="error"><?php echo form_error('new_password'); ?></div>
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