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
                                    <p>Hello, <strong><?php //echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?></strong> (<strong><?php //echo $this->session->userdata('email') ?></strong>)</p>
                                 </div>
                                 <p class="mb-0">Hello This is Bhoomi Farm dashboard</p>
                              </div>
                           </div>
                           <!-- Single Tab Content End -->
                           <!-- Single Tab Content Start -->
                           <div class="tab-pane fade show active" id="orders" role="tabpanel">
                              <div class="myaccount-content">
                                 <h3>Orders</h3>
                                 <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-header">
                        <h4 class="card-title">Order Details</h4>
                     </div>
                     <div class="card-body">
                        <section class="ftco-section testimony-section">
                           <div class="container">
                              <div class="row ftco-animate">
                                 <div class="col-md-12">
                                    <?php if(!empty($order_details)) 
                                    {
                                       //echo "<pre>";
                                       // print_r($order_details); die;


                                     ?>
                                    <div class="tab-content" id="v-pills-tabContent">
                                       <div class="tab-pane active" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab">
                                          <div class="row">
                                             <div class="col-md-6 table table-borderless">
                                                <table>
                                                   <thead>
                                                      <tr>
                                                         <th>Order Id</th>
                                                         <th><span class="badge light badge-primary"><?php echo $order_details->id; ?> </span></th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td>Name</td>
                                                         <td><?php echo $order_details->full_name; ?></td>
                                                      </tr>
                                                      <tr>
                                                         <td>Mobile No.</td>
                                                         <td> +91 <?php echo $order_details->phone; ?></td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div> 
                                             <div class="col-md-12 table table-borderless">
                                                <table>
                                                   <thead>
                                                      <tr>
                                                         <th>Order Status</th>
                                                         <th>
                                                            <?php if($order_details->delivered==0){   ?>
                                                            <span class="badge light badge-mute">
                                                            Order Not Place
                                                            </span>
                                                            <?php }  if($order_details->delivered==1){ ?>
                                                            <span class="badge light badge-primary">
                                                            Order Processing
                                                            </span>
                                                            <?php  } if($order_details->delivered==2){  ?>
                                                            <span class="badge light badge-success">
                                                            Delivered
                                                            </span>
                                                            <?php } if($order_details->delivered==3){ ?>
                                                            <span class="badge light badge-danger">
                                                            Cancel Order
                                                            </span>
                                                            <?php } ?>
                                                         </th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td>Email</td>
                                                         <td><?php echo $_SESSION['email'] ?></td>
                                                      </tr>
                                                      <tr>
                                                         <td>Delivery Address</td>
                                                         <td><?php echo $order_details->address.' '. $order_details->city.' '.$order_details->pincode.' '. $order_details->state; ?></td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div> 
                                          </div>
                                          <hr>
                                          <div class="row text-dark">
                                             <div class="col-md-12">
                                                <div class="card text-center">
                                                   <div class="card-body text-left table-responsive">
                                                      <table class="table table-hover" style="width: 100%;">
                                                         <thead>
                                                            <tr>
                                                    <th>Image</th>
                                                    <th>Product </th> 
                                                    <th>Price</th>
                                                   <th>Qty</th>      
                                                   <th>Amount</th>
                                                      </tr>
                                                         </thead>
                                                         <?php
                                                         $subtotal=0;
                                                         $data=unserialize($order_details->order_item_array);
                                                         //echo "<pre>";
                                                         //print_r($data); die;
                                                            foreach ($data as $product) {

                                               $this->db->select('search_image');
                                                 $this->db->where(['pid' =>$product->id]);
                                                $query_img = $this->db->get('ecom_product_images');
                                                $res_imag= $query_img->result();
                                                 if(!empty($res_imag))
                                                 {
                                                   $img=base_url()."uploads/products/".$res_imag[0]->search_image;
                                                 }else{
                                                   $img="";
                                                 }
                                                            ?>
                                                         <tr>
                                                            <td style="width: 100px;"><img height="80" src="<?php echo$img; ?>"></td>
                                                            <td style="max-width: 200px;">
                                                               <b><?php echo $product->product_name; ?></b><br>
                                                              
                                                            </td>
                                                           
                                                            <td>
                                                               <span class=" fa fa-inr"> <?php echo $product->price; ?> </span>
                                                            </td>
                                          <td>
                                              <?php echo $product->min_order_qty; ?>
                                          </td>
                                                           
                                          <td>
                                       <span class=" fa fa-inr"> <?php $total= $product->price*$product->min_order_qty; 
                                              $subtotal+=$total;

                                              echo $total;
                                                 ?> </span>
                                                            </td>
                                                         </tr>
                                                         <?php
                                                            }
                                                            ?>
                                                         <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td colspan="3"><b>Subtotal</b></td>
                                                            <td><i class="fa fa-inr">&nbsp;</i><?php echo $subtotal; ?></td>
                                                         </tr>
                                                      
                                                         <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td colspan="3"><b>IGST</b></td>
                                                            <td>+ <i class="fa fa-inr">&nbsp;</i><?php //echo $order_details['igst']; ?></td>
                                                         </tr>
                                                         <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td colspan="3"><b>Delivery charge</b></td>
                                                            <td>+ <i class="fa fa-inr">&nbsp;</i><?php //echo $order_details['delivery_charge']; ?></td>
                                                         </tr>
                                                         <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td colspan="3"><b>Total amount</b></td>
                                                            <td><i class="fa fa-inr">&nbsp;</i><?php echo $subtotal; ?></td>
                                                         </tr>
                                                      </table>
                                                   </div>
                                                   <div class="card-footer text-muted">
                                                      <div style="float: left;">
                                                         ORDER TIME : 
                                                         <b><?php //echo date('d-M-Y h:i A', strtotime($order_details['order_datetime'])); ?></b>
                                                      </div>
                                                      <?php  ?>
                                                      <div style="float: right;">
                                                         Delivery Date: 
                                                         <b><?php //echo date('d-M-Y', strtotime($order_details['delivery_date'])); ?></b>
                                                      </div>
                                                      <?php ?>
                                                   </div>
                                                </div>
                                                <br>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
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
