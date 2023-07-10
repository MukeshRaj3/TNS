<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
   <div class="breadcrumb-area bg-12 text-center">
      <div class="container">
         <h1>My Account</h1>
         <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="index.html">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">My Orders</li>
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
                           <a href="<?php echo base_url('profile') ?>" class="list-group-item list-group-item-action">
                           Profile
                           </a>
                           <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
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
                                             <th>View</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php if (!empty($orders)) : ?>
                                          <?php foreach ($orders as $key => $value) : 
                                         // echo "<pre>";
                                          //print_r($value); die;

                                          //print_r(unserialize($value->order_item_array)); die;
                                           ?>
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
                                                   <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $key; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                   Orders
                                                   </button>
                                                   <?php if ($value->delivered == '4' || $value->delivered == '1') : ?>
                                                   <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton<?php echo $key; ?>">
                                                      <li><a class="dropdown-item" href="<?php echo base_url('welcome/cancel_order') . '/' . $value->id; ?>">Cancel Order</a></li>
                                                      <li><a class="dropdown-item" href="<?php echo base_url('welcome/pause_order') . '/' . $value->id; ?>">Pause Order</a></li>
                                                      <li><a class="dropdown-item" href="<?php echo base_url('welcome/reschedule_order') . '/' . $value->id; ?>">Reschedule Order</a></li>
                                                   </ul>
                                                   <?php elseif ($value->delivered == '5') : ?>
                                                   <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton<?php echo $key; ?>">
                                                      <li><a class="dropdown-item" href="<?php echo base_url('welcome/cancel_order') . '/' . $value->id; ?>">Cancel Order</a></li>
                                                      <li><a class="dropdown-item" href="<?php echo base_url('welcome/reschedule_order') . '/' . $value->id; ?>">Reschedule Order</a></li>
                                                   </ul>
                                                   <?php endif; ?>
                                                </div>
                                             </td>
                                             <td>
                                             <a href="<?php echo base_url('order-details/'.$value->id); ?>"><span class="badge light badge-danger"><i class="fa fa-eye"></i></span>
                                             </a>
                                           </td>
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
                     <!-- My Account Tab Content End -->
                  </div>
               </div>
               <!-- My Account Page End -->
            </div>
         </div>
      </div>
   </div>
</div>
