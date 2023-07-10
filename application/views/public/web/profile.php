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
                                <div class="list-group">
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
                                        Profile
                                    </a>
                                    <a href="<?php echo base_url('orders') ?>" class="list-group-item list-group-item-action">
                                        Orders
                                    </a>
                                    <a href="<?php echo base_url('payments') ?>" class="list-group-item list-group-item-action">Payments</a>
                                    <a href="<?php echo base_url('change-password') ?>" class="list-group-item list-group-item-action">Change Password</a>
                                    <a href="<?php echo base_url('auth/logout') ?>" class="list-group-item list-group-item-action" tabindex="-1" aria-disabled="true">Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong><?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?></strong> (<strong><?php echo $this->session->userdata('email') ?></strong>)</p>
                                            </div>

                                            <p class="mb-0">Hello This is Bhoomi Farm dashboard</p>
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